<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KonsultasiPaketSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_paket' => 'Konsultasi Umum',
                'harga'      => 0,
                'deskripsi'  => 'Konsultasi awal seputar pengelolaan arsip, cocok untuk yang baru mulai berbenah.',
            ],
            [
                'nama_paket' => 'Audit Arsip',
                'harga'      => 0,
                'deskripsi'  => 'Peninjauan menyeluruh kondisi arsip instansi/organisasi beserta rekomendasi perbaikan.',
            ],
            [
                'nama_paket' => 'Pendampingan Kearsipan',
                'harga'      => 0,
                'deskripsi'  => 'Pendampingan berkelanjutan dalam penataan dan digitalisasi arsip.',
            ],
        ];

        $this->db->table('konsultasi_paket')->insertBatch($data);
    }
}