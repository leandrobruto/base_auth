<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function getIndex($id = null)
    {
        $data = [
            'title' => 'Welcome, Cordylus!',
        ];
        
        return view('Home/index', $data);
    }
}
