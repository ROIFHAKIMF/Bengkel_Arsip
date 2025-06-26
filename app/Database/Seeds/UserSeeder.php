<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
                // membuat data
        $data = [
            [
                'username' => 'Adit',
                'password'  => 123456,
                'role' => 'guest',
            ],
            [
                'username' => 'Rafi',
                'password'  => 123456,
                'role' => 'guest',
            ],
            [
                'username' => 'Roif',
                'password'  => 123456,
                'role' => 'admin',
            ],
        ];
        $this->db->table('user')->insert($data);
    }
}
