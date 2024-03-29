<?php

namespace App\Libraries;

/**
 * @description This library / class will take care of the authentication part of our application
 */

class Auth {
    
    private $user;

    public function login(string $email, string $password) 
    {
        $userModel = new \App\Models\UserModel();

        $user = $userModel->findUserByEmail($email);

        /* If the user cannot be found by email, it returns false */
        if ($user == null) {
            return false;
        }

        /* If the password does not match the password_hash, returns false */
        if (!$user->passwordVerify($password)) {
            return false;
        }

        /* Only allow active users to login */
        if (!$user->active) {
            return false;
        }

        /* Everything is ok and we can log the user into the application using the method below. */
        $this->loginUser($user);

        /* Return true.. Everything is ok */
        return true;
    }


    public function logout() 
    {
        session()->destroy();
    }

    public function getUserLoggedIn() 
    {    
        /**
         * Don't forget to share the instance with services
         */
        if($this->user === null) {
            $this->user = $this->getUserFromSession();
        }

        /* Return the user that was defined at the beginning of the class */
        return $this->user;
    }

    /**
     * @description: The method only allows those who still exist in the database to be logged in to the application and who are active.
     *             Otherwise, you will be logged out if there is a change to your account during your session.
     * @use: In the LoginFilter
     * 
     * @return: returns true if the getUserLoggedIn() method is not null. That is, if the user is logged in.
     */
    public function isLoggedIn() 
    {
        return $this->getUserLoggedIn() != null;
    }

    private function getUserFromSession() 
    {
        if (!session()->has('user_id')) {
            return null;
        }

        /* Instantiate the User model */
        $userModel = new \App\Models\UserModel();

        /* Retrieves user according to session key 'user_id' */
        $user = $userModel->find(session()->get('user_id'));

        /* Only return the user object if it is found and is active */
        if ($user && $user->active) {
            return $user;
        }
    }

    private function loginUser(object $user) {

        $session = session();
        $session->regenerate();
        $session->set('user_id', $user->id);

    }
}