<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function getIndex()
    {
        
        $data = [
            'title'     => 'Sign in',
        ];

        return view('Login/signin', $data);
    }

    public function postSignIn()
    {
        
        if ($this->request->getMethod('post')) {
            
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $auth = service('auth');
            
            if ($auth->login($email, $password)) {
                $user = $auth->getUserLoggedIn();
                
                return redirect()->to(site_url('admin/dashboard'))->with('success', "Hi $user->name, glad you're back!");
            } else {
                return redirect()->back()->with('attention', "We can't find your login credentials!");
            }

        } else {
            return redirect()->back();
        }
    }

    /**
     * We can display the message 'Your session has expired.',
      * After logout, we must make a request to a URL, in this case 'showLogoutMessage'
      * Because when we log out, all data from the current session, including flashdata, is destroyed.
      * In other words, messages will never be displayed.
      *
      * Therefore, to be able to display it, we just need to create the 'showLogoutMessage' method that will redirect it to the Home,
      * With the desired message.
      *
      * And as this is a redirect, the message will only be displayed once.
     */
    public function getLogout() 
    {
        service('auth')->logout();
 
        return redirect()->to(site_url('login/showLogoutMessage'));
    }

    public function getShowLogoutMessage() 
    {
        return redirect()->to(site_url('login'))->with('info', 'We hope to see you again.');
    }
}
