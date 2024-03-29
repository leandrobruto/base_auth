<?php

if (!function_exists('userLoggedIn')) 
{    
    function userLoggedIn() 
    {
        $auth = service('auth');

        return $auth->getUserLoggedIn();
    }
}