<?php

namespace App\Controllers;

class DashboardController extends BaseController
{    // Halaman Utama (Home) - untuk pengunjung (belum login)
    public function index()
    {
        $session = session();

    // ✅ Jika sudah login dan role admin, redirect ke /admin
    if ($session->get('isLoggedIn') && $session->get('role') === 'admin') {
        return redirect()->to('/admin');
    }
        // Cek jika sudah login, maka redirect ke halaman sesuai role

        $data_about = [
            ['title' => 'Apa itu bengkel arsip?',
            'content' => 'Bengkel Arsip adalah sebuah usaha dalam bidang Layanan Jasa Manajemen Kearsipan yang Profesional dan Terpercaya'],
            ['title' => 'Kapan sih bengkel arsip di dirikan?',
            'content' => 'Bengkel Arsip didirikan pada tahun 2016 di Kota Semarang'],
            ['title' => 'Siapa saja customer dari bengkel arsip?',
            'content' => 'Customer Bengkel Arsip adalah semua organisasi dan perseorangan yang dalam kegiatannya menghasilkan arsip baik itu lembaga pemerintahan Pusat maupun Daerah, Organisasi Politik , Organisasi Kemasyarakatan, Perusahaan Milik Negara maupun Swasta serta Perseorangan.'],
            ['title' => 'Berapa lama sih proses pengerjaannya?',
            'content' => 'Proses pekerjaan tergantung kwantitas atau banyaknya arsip serta tingkat kesulitannya baik pengolahan dan penataan arsip, Digitalisasi arsip maupun Restorasi arsip.'],
            ['title' => 'Mengapa sih harus memilih bengkel arsip?',
            'content' => 'Ini Bengkel Arsip adalah Jasa Layanan Kearsipan yang Modern, Professional dan terpercaya'],
            ['title' => ' Bagaimana bengkel arsip memproses sebuah arsip?',
            'content' => 'Pemrosesan suatu arsip tergantung jenis layanan kearsipan antara lain Pengolahan dan Penataan arsip, Digitalisasi arsip maupun Restorasi arsip. Setiap kegiatan layanan membutuhkan proses khusus jadi tergantung jenis layanan kearsipan yang dibutuhkan'],
        ];
        // Tampilkan halaman yang bisa diakses oleh pengunjung yang belum login
        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home'); // Halaman home biasa
        echo view('content/about', ['data_about' => $data_about]);
        echo view('layout/footer');
    }

    // Admin Dashboard - hanya bisa diakses oleh admin yang sudah login
    public function admin()
    {

        
        $data_services = [
            ['title' => 'sv-1.jpg',
            'content' => 'DIGITALISASI ARSIP MENJADI BENTUK DIGITAL'],
            ['title' => 'sv-2.jpg',
            'content' => 'RESTORASI ARSIP BERHARGA YANG RUSAK'],
            ['title' => 'sv-3.jpg',
            'content' => 'PENGOLAHAN DAN PENATAAN ARSIP DAN RUANG ARSIP'],
            ['title' => 'sv-4.png',
            'content' => 'PELATIHAN DAN KONSULTASI KEARSIPAN'],
            ['title' => 'sv-5.png',
            'content' => 'PENGADAAN SARANA DAN PRASARANA KEARSIPAN.']];

        $data_about = [
            ['title' => 'Apa itu bengkel arsip?',
            'content' => 'Bengkel Arsip adalah sebuah usaha dalam bidang Layanan Jasa Manajemen Kearsipan yang Profesional dan Terpercaya'],
            ['title' => 'Kapan sih bengkel arsip di dirikan?',
            'content' => 'Bengkel Arsip didirikan pada tahun 2016 di Kota Semarang'],
            ['title' => 'Siapa saja customer dari bengkel arsip?',
            'content' => 'Customer Bengkel Arsip adalah semua organisasi dan perseorangan yang dalam kegiatannya menghasilkan arsip baik itu lembaga pemerintahan Pusat maupun Daerah, Organisasi Politik , Organisasi Kemasyarakatan, Perusahaan Milik Negara maupun Swasta serta Perseorangan.'],
            ['title' => 'Berapa lama sih proses pengerjaannya?',
            'content' => 'Proses pekerjaan tergantung kwantitas atau banyaknya arsip serta tingkat kesulitannya baik pengolahan dan penataan arsip, Digitalisasi arsip maupun Restorasi arsip.'],
            ['title' => 'Mengapa sih harus memilih bengkel arsip?',
            'content' => 'Ini Bengkel Arsip adalah Jasa Layanan Kearsipan yang Modern, Professional dan terpercaya'],
            ['title' => ' Bagaimana bengkel arsip memproses sebuah arsip?',
            'content' => 'Pemrosesan suatu arsip tergantung jenis layanan kearsipan antara lain Pengolahan dan Penataan arsip, Digitalisasi arsip maupun Restorasi arsip. Setiap kegiatan layanan membutuhkan proses khusus jadi tergantung jenis layanan kearsipan yang dibutuhkan'],
        ];

        // Tampilkan halaman admin dashboard
        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home'); // Halaman home biasa
        echo view('content/about', ['data_about' => $data_about]);
        echo view('content/services', ['data_services' => $data_services]);
        echo view('content/profile');
        echo view('content/gallery');
        echo view('content/client');
        echo view('content/contact');
        echo view('layout/footer');
    }
}
