<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\User;

class Users extends BaseController
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    public function getIndex($id = null)
    {
        $data = [
            'title' => 'Users listing',
            'users' => $this->userModel->withDeleted(true)->paginate(10),
            'pager' => $this->userModel->pager,
        ];

        return view('Admin/Users/index', $data);
    }

    public function getCreate()
    {
        $user = new user();

        $data = [
            'title'     => "Creating a new user",
            'user' => $user,
        ];

        return view('Admin/Users/create', $data);
    }

    public function postRegister()
    {
        if ($this->request->getMethod() === 'post') {
            
            $user = new User($this->request->getPost());
        
            if ($this->userModel->protect(false)->save($user)) {
                return redirect()->to(site_url("admin/users/show/" . $this->userModel->getInsertID()))
                                ->with('success', "User $user->nome successfully registered!");
            } else {
                return redirect()->back()->with('errors_model', $this->userModel->errors())
                                        ->with('attention', "Please check the errors below.")
                                        ->withInput();
            }

        } else {
            /* It's not POST */
            return redirect()->back();
        }
    }

    public function postUploadImage($id = null) 
    {
        $user = $this->buscauserOu404($id);

        $image = $this->request->getFile('foto_user');

        if (!$image->isValid()) {
            $errorCode = $image->getError();

            if ($errorCode == UPLOAD_ERR_NO_FILE) {
                return redirect()->back()->with('attention', 'No files were selected.');
            }
        }

        $imageSize = $image->getSizeByUnit('mb');

        if ($imageSize > 2) {
            return redirect()->back()->with('attention', 'The selected file is too large. Maximum allowed is: 2MB.');
        }

        $imageType = $image->getMimeType();
        $imageTypeClear = explode('/', $imageType);

        $allowedTypes = [
            'jpg', 'jpeg', 'png', 'webp',
        ];
        
        if (!in_array($imageTypeClear[1], $allowedTypes)) {
            return redirect()->back()->with('attention', 'The file does not have the permitted format. Just: ' . implode(', ', $allowedTypes));
        }

        list($widht, $height) = getimagesize($image->getPathName());

        if ($widht < "400" || $height < "400") {
            return redirect()->back()->with('attention', 'The image cannot be smaller than 400 x 400 pixels.');
        }

        // --------------- Store the image. ------------- //

        /* Storing the image and retrieving its path. */
        $imagePath = $image->store('users');

        $imagePath = WRITEPATH . 'uploads/' . $imagePath;

        /* Resizing the same image */
        service('image')
                ->withFile($imagePath)
                ->fit(400, 400, 'center')
                ->save($imagePath);

        /* Recovering the old image to delete it. */
        $oldImage = $user->image;

        /* Assigning the new image. */
        $user->image = $image->getName();
        
        /* Updating the product image. */
        $this->userModel->save($user);

        /* Setting the old image path. */
        $imagePath = WRITEPATH . 'uploads/users/' . $oldImage;
        
        if (is_file($imagePath)) {
            unlink($imagePath);
        }

        return redirect()->to(site_url("admin/users/show/$user->id"))->with('success', 'image changed successfully!');
    }

    public function getShow($id = null)
    {
        $user = $this->findUserOr404($id);

        $data = [
            'title'     => "User Details",
            'user' => $user,
        ];

        return view('Admin/Users/show', $data);
    }

    public function getEdit($id = null)
    {
        $user = $this->findUserOr404($id);

        if ($user->deleted_at != null) {
            return redirect()->back()->with('info', "The user $user->name is deleted. Therefore, it is not possible to edit it.");
        }
        
        $data = [
            'title'     => "Editing the user $user->name",
            'user' => $user,
        ];

        return view('Admin/Users/edit', $data);
    }

    public function postUpdate($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $user = $this->findUserOr404($id);

            if ($user->deleted_at != null) {
                return redirect()->back()->with('info', "The user $user->nome is deleted. Therefore, it is not possible to edit it.");
            }

        } else {
            /* It's not POST */
            return redirect()->back();
        }

        $post = $this->request->getPost();
        
        if (empty($post['password'])) {
            $this->userModel->disablePasswordValidation();
            unset($post['password']);
            unset($post['password_confirmation']);
        }

        $user->fill($post);
        
        if (!$user->hasChanged()) {
            return redirect()->back()->with('info', "There is no data to update.");
        }
        
        if ($this->userModel->protect(false)->save($user)) {
            return redirect()->to(site_url("admin/users/show/$user->id"))
                            ->with('success', "User $user->nome updated successfully!");
        } else {
            return redirect()->back()->with('errors_model', $this->userModel->errors())
                                    ->with('attention', "Please check the errors below.")
                                    ->withInput();
        }
    }

    public function getDelete($id = null)
    {
        $user = $this->findUserOr404($id);

        if ($user->deletado_em != null) {
            return redirect()->back()->with('info', "The user $user->name is already deleted!");
        }

        if ($user->is_admin) {
            return redirect()->back()->with('info', "Cannot delete an <b>Administrator</b> User.");
        }

        $data = [
            'title'     => "Deleting user $user->name",
            'user' => $user,
        ];

        return view('Admin/Users/delete', $data);
    }

    public function postDelete($id = null)
    {
        $user = $this->findUserOr404($id);

        if ($this->request->getMethod() === 'post') {
            $this->userModel->delete($id);
            return redirect()->to(site_url('admin/users'))
                            ->with('success', "User $user->name successfully deleted.");
        }
    }

    public function getUndoDelete($id = null)
    {
        $user = $this->findUserOr404($id);
        
        if ($user->deleted_at == null) {
            return redirect()->back()->with('info', "Only deleted users can be recovered.");
        }

        if ($this->userModel->undoDelete($id)) {
            return redirect()->back()->with('success', "Deletion successfully undone!");
        } else {
            return redirect()->back()->with('errors_model', $this->userModel->errors())
                                    ->with('attention', "Please check the errors below.")
                                    ->withInput();
        }
    }

    /**
     * @param int $id
     * @return object User
     */
    private function findUserOr404($id = null)
    {
        if (!$id || !$user = $this->userModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("We don't find the user $id");
        }
        
        return $user;
    }
}