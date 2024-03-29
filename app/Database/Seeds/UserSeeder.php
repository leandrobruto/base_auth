<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel;

        $user = [
            'name' => 'Ademiro',
            'email' => 'ademiro@admin.com',
            'password' => '123qweasd',
            'cpf' => '759.859.440-69',
            'phone' => '(99) 9999-9999',
            'is_admin' => true,
            'active' => true,
        ];

        $userModel->skipValidation(true)->protect(false)->insert($user);

        dd($user->errors());
    }
}