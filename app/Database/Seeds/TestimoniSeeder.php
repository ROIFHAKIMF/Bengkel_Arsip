<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestimoniSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'   => 'Andi Prasetyo',
                'foto'   => null,
                'ulasan' => 'Pelayanan digitalisasi arsipnya rapi dan cepat, dokumen lama kantor kami jadi tertata ulang dengan baik.',
                'rating' => 5,
            ],
            [
                'nama'   => 'Siti Rahma',
                'foto'   => null,
                'ulasan' => 'Tim Bengkel Arsip sangat membantu proses restorasi dokumen penting yang sudah rusak dimakan usia.',
                'rating' => 5,
            ],
            [
                'nama'   => 'Budi Santoso',
                'foto'   => null,
                'ulasan' => 'Konsultasi kearsipannya jelas dan mudah dipahami, cocok untuk instansi yang baru mulai berbenah arsip.',
                'rating' => 4,
            ],
        ];

        $this->db->table('testimoni')->insertBatch($data);
    }
}