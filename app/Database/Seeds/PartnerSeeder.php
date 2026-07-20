<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Partner Satu',  'logo' => null],
            ['nama' => 'Partner Dua',   'logo' => null],
            ['nama' => 'Partner Tiga',  'logo' => null],
            ['nama' => 'Partner Empat', 'logo' => null],
            ['nama' => 'Partner Lima',  'logo' => null],
            ['nama' => 'Partner Enam',  'logo' => null],
        ];

        $this->db->table('partner')->insertBatch($data);
    }
}