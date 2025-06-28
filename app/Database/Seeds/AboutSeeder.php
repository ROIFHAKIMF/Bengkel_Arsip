<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AboutSeeder extends Seeder
{
    public function run()
    {
         $data = [
            ['title' => 'Apa itu bengkel arsip?', 'content' => 'Bengkel Arsip adalah sebuah usaha dalam bidang Layanan Jasa Manajemen Kearsipan yang Profesional dan Terpercaya'],
            ['title' => 'Kapan sih bengkel arsip didirikan?', 'content' => 'Bengkel Arsip didirikan pada tahun 2016 di Kota Semarang'],
            ['title' => 'Siapa saja customer dari bengkel arsip?', 'content' => 'Customer Bengkel Arsip adalah semua organisasi dan perseorangan yang menghasilkan arsip, baik lembaga pemerintah, organisasi politik, perusahaan, maupun perorangan.'],
            ['title' => 'Berapa lama proses pengerjaannya?', 'content' => 'Tergantung banyaknya arsip dan tingkat kesulitannya, baik untuk pengolahan, digitalisasi, atau restorasi.'],
            ['title' => 'Mengapa memilih bengkel arsip?', 'content' => 'Karena Bengkel Arsip adalah jasa layanan kearsipan yang modern, profesional, dan terpercaya.'],
            ['title' => 'Bagaimana proses arsip dilakukan?', 'content' => 'Tergantung jenis layanan yang dibutuhkan. Tiap layanan memiliki proses khusus seperti digitalisasi, restorasi, atau penataan arsip.']
        ];

        $this->db->table('about')->insertBatch($data);
    }
}
