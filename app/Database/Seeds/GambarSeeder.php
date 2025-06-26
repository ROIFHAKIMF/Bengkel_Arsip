<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GambarSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'gambar'    => 'slide1.jpg',
                'deskripsi' => 'Gambar pemandangan alam'
            ],
            [
                'gambar'    => 'slide2.jpg',
                'deskripsi' => 'Gambar hewan lucu'
            ],
            [
                'gambar'    => 'slide3.jpg',
                'deskripsi' => 'Gambar desain modern'
            ],
            [
                'gambar'    => 'slide4.jpg',
                'deskripsi' => 'Gambar kota di malam hari'
            ],
            [
                'gambar'    => 'slide5.jpg',
                'deskripsi' => 'Gambar ilustrasi abstrak'
            ],
            [
                'gambar'    => 'slide6.jpg',
                'deskripsi' => 'Gambar pemandangan gunung'
            ],
            [
                'gambar'    => 'slide7.jpg',
                'deskripsi' => 'Gambar laut biru'
            ],
            [
                'gambar'    => 'slide8.jpg',
                'deskripsi' => 'Gambar jalanan kota'
            ],
            [
                'gambar'    => 'slide9.jpg',
                'deskripsi' => 'Gambar makanan lezat'
            ],
            [
                'gambar'    => 'slide10.jpg',
                'deskripsi' => 'Gambar teknologi futuristik'
            ],
            [
                'gambar'    => 'slide11.jpg',
                'deskripsi' => 'Gambar arsitektur klasik'
            ],
            [
                'gambar'    => 'slide12.jpg',
                'deskripsi' => 'Gambar suasana hutan'
            ],
        ];

        $this->db->table('gambar')->insertBatch($data);
    }
}
