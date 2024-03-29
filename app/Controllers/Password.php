<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Password extends BaseController
{
    public function __construct() 
    {
        $this->userModel = new \App\Models\UserModel();

    }

    public function getForgot()
    {
        $data = [
            'title' => 'Forgot my password.',
        ];

        return view('Password/forgot', $data);
    }

    public function postProcessForgot()
    {
        if ($this->request->getMethod() === 'post') {
            
            $user = $this->userModel->findUserByEmail($this->request->getPost('email'));

            if ($user === null || !$user->active) {
                return redirect()->to(site_url('password/forgot'))
                        ->with('attention', 'We did not find a valid account with this email.')
                        ->withInput();
            }

            $user->startsPasswordReset();
            
            $this->userModel->save($user);

            $this->sendEmailResetPassword($user);
            
            return redirect()->to(site_url('login'))
                            ->with('success', 'Password reset email sent to your inbox.');
        } else {
        /* It's not POST */
            return redirect()->back();

        }
    }

    public function getReset($token = null) {
        
        if ($token === null) {
            return redirect()->to(site_url('password/forgot'))->with('attention', 'Invalid or expired link.');
        }

        $user = $this->userModel->findUserToResetPassword($token);
        
        if ($user != null) {

            $data = [
                'title' => 'Reset your password.',
                'token' => $token,
            ];

            return view('Password/reset', $data);
        } else {
            return redirect()->to(site_url('password/forgot'))->with('attention', 'Invalid or expired link.');
        }
    }

    public function postProcessReset($token = null) {

        if ($token === null) {
            return redirect()->to(site_url('password/forgot'))->with('attention', 'Invalid or expired link.');
        }

        $user = $this->userModel->findUserToResetPassword($token);

        if ($user != null) {

            $user->fill($this->request->getPost());
            
            if ($this->userModel->save($user)) {

                /**
                 * Setting the 'reset_hash' and 'reset_expires_in' columns to null when invoking the method below
                  * which was defined in the User Entity.
                  *
                  * We have invalidated the old link that was sent to the user's email.
                 */
                $user->completePasswordReset();

                /**
                 * We update the user again with the new values defined above.
                 */
                $this->userModel->save($user);

                return redirect()->to(site_url('login'))->with('success', 'New password registered successfully!');
                
            } else {
                return redirect()->to(site_url("password/reset/$token"))
                                ->with('errors_model', $this->userModel->errors())
                                ->with('attention', 'Please check the errors below.')
                                ->withInput();
            }

        } else {
            return redirect()->to(site_url('password/forgot'))->with('attention', 'Invalid or expired link.');
        }
    }

    private function sendEmailResetPassword(object $user) {

        $email = \Config\Services::email();

        $email->setFrom('no-reply@gameplan.com.br', 'GamePlan');
        $email->setTo($user->email);

        $email->setSubject('Reset password.');
        
        $mensagem = view('Password/reset_email', ['token' => $user->reset_token]);

        $email->setMessage($mensagem);

        $email->send();
    }
}
