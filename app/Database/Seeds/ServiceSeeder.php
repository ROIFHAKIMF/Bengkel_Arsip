<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['title' => 'sv-1.jpg', 'content' => 'DIGITALISASI ARSIP MENJADI BENTUK DIGITAL'],
            ['title' => 'sv-2.jpg', 'content' => 'RESTORASI ARSIP BERHARGA YANG RUSAK'],
            ['title' => 'sv-3.jpg', 'content' => 'PENGOLAHAN DAN PENATAAN ARSIP DAN RUANG ARSIP'],
            ['title' => 'sv-4.png', 'content' => 'PELATIHAN DAN KONSULTASI KEARSIPAN'],
            ['title' => 'sv-5.png', 'content' => 'PENGADAAN SARANA DAN PRASARANA KEARSIPAN.']
        ];

        $this->db->table('services')->insertBatch($data);
    }
}
