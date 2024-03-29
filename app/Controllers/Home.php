<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function getIndex()
    {
        $data = [
            'title' => 'Welcome, Cordylus!',
        ];
        
        return view('Home/index', $data);
    }
}
