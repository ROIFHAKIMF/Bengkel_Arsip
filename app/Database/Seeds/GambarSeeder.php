<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GambarSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul'     => 'Aplikasi Bengkel Arsip',
                'gambar'    => 'slide1.jpg',
                'deskripsi' => 'Aplikasi bengkel arsip untuk mengelola data hasil  digital'
            ],
            [
                'judul'     => 'Digitalisasi Arsip',
                'gambar'    => 'slide2.jpg',
                'deskripsi' => 'Digitilisasi arsip bapenda kota semarang'
            ],
            [
                'judul'     => 'Penataan Arsip ',
                'gambar'    => 'slide3.jpg',
                'deskripsi' => 'Dinas pendapatan dan aset daerah kabupaten brebes melakukan penataan arsip yang rapi dan terstruktur'
            ],
            [
                'judul'     => 'Penataan Arsip ',
                'gambar'    => 'slide4.jpg',
                'deskripsi' => 'Badan pendapatan daerah kota semarang melakukan penataan arsip yang rapi dan terstruktur'
            ],
            [
                'judul'     => 'Penataan Arsip ',
                'gambar'    => 'slide5.jpg',
                'deskripsi' => 'Kantor pusat bank jateng melakukan penataan arsip yang rapi dan terstruktur'
            ],
            [
                'judul'     => 'Restorasi',
                'gambar'    => 'slide 7.jpg',
                'deskripsi' => 'Dinas kependudukan dan pencatatan sipil kabupaten karanganyar '
            ],
            [
                'judul'     => 'Digitalisasi Arsip',
                'gambar'    => 'slide8.jpg',
                'deskripsi' => 'Digitilisasi arsip bapenda kota semarang'
            ],
            [
                'judul'     => 'Penataan Arsip ',
                'gambar'    => 'slide9.jpg',
                'deskripsi' =>  'Badan pendapatan daerah kota semarang melakukan penataan arsip yang rapi dan terstruktur'
            ],
            [
                'judul'     => 'Digitalisasi Arsip',
                'gambar'    => 'slide10.jpg',
                'deskripsi' => 'Digitilisasi arsip bapenda kota semarang'
            ],
            [
                'judul'     => 'File Digitalisasi',
                'gambar'    => 'slide11.jpg',
                'deskripsi' => 'Tumupukan file yang akan dijadikan arsip digital'
            ],
            [
                'judul'     => 'Digitalisasi Arsip',
                'gambar'    => 'slide12.jpg',
                'deskripsi' => 'Keraton mangkunegaran surakarta melakukan digitalisasi '
            ],
        ];

        $this->db->table('gambar')->insertBatch($data);
    }
}
