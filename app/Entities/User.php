<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Token;

class User extends Entity
{
    protected $dates   = [
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    public function passwordVerify(string $password) 
    {
        return password_verify($password, $this->password_hash);
    }
    
    public function startsPasswordReset() 
    {
        /* Instantiates the Token class object */
        $token = new Token();
        
        /**
         * @description: We assign the 'reset_token' attribute to the User object ($this) which will contain the generated token
          * so we can access it in the 'Password/reset_email' view.
         */
        $this->reset_token = $token->getValue();

        /**
         * @description: We assign the 'reset_hash' attribute to the Entities User ($this) object, which will contain the hash of the token.
          */
        $this->reset_hash = $token->getHash();
        
        $this->reset_expires_in = date('Y-m-d H:i:s', time() + 7200);// Expires in 2hrs from the current date and time
    }

    public function completePasswordReset() {

        $this->reset_hash = null;
        $this->reset_expires_in = null;
        
    }

    public function startActivation() 
    {    
        $token = new Token();

        $this->token = $token->getValue();
        $this->activation_hash = $token->getHash();
    }

    public function activate() 
    {    
        $this->active = true;
        $this->activation_hash = null;
        
    }
}
