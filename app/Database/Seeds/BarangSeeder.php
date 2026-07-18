<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'      => 'Printer Epson L3210',
                'harga'     => 2850000,
                'stok'      => 5,
                'deskripsi' => 'Printer multifungsi (print, scan, copy) dengan sistem tangki tinta, cocok untuk kebutuhan digitalisasi arsip.',
                'gambar'    => null,
            ],
            [
                'nama'      => 'Scanner Canon DR-C225',
                'harga'     => 6500000,
                'stok'      => 3,
                'deskripsi' => 'Document scanner kecepatan tinggi, mendukung duplex scan otomatis untuk digitalisasi arsip dalam jumlah besar.',
                'gambar'    => null,
            ],
            [
                'nama'      => 'Box Arsip Standar',
                'harga'     => 35000,
                'stok'      => 200,
                'deskripsi' => 'Box arsip karton tebal ukuran standar, cocok untuk penyimpanan dokumen jangka panjang.',
                'gambar'    => null,
            ],
            [
                'nama'      => 'Rak Arsip Besi 4 Tingkat',
                'harga'     => 1250000,
                'stok'      => 10,
                'deskripsi' => 'Rak arsip besi kokoh 4 tingkat, cocok untuk gudang atau ruang penyimpanan arsip.',
                'gambar'    => null,
            ],
            [
                'nama'      => 'Label Arsip Roll',
                'harga'     => 15000,
                'stok'      => 150,
                'deskripsi' => 'Label roll untuk penandaan kategori arsip, memudahkan pencarian dan penataan.',
                'gambar'    => null,
            ],
            [
                'nama'      => 'Map Folder Arsip',
                'harga'     => 8000,
                'stok'      => 300,
                'deskripsi' => 'Map folder tahan lama untuk pengelompokan dokumen sebelum dimasukkan ke box arsip.',
                'gambar'    => null,
            ],
        ];

        $this->db->table('barang')->insertBatch($data);
    }
}