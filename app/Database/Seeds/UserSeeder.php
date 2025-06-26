<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'Adit',
                'password'  => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
            [
                'username' => 'Rafi',
                'password'  => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
            [
                'username' => 'Roif',
                'password'  => password_hash('123456', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
        ];

        $this->db->table('user')->insertBatch($data); // insertBatch bukan insert
    }
}
