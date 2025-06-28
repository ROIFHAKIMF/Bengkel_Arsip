<?php

namespace App\Controllers;

use App\Models\GambarModel;
use App\Models\AboutModel;
class DashboardController extends BaseController
{
    // Halaman Utama (Home) - untuk pengunjung (belum login)
    public function index()
    {
        $session = session();

        // Jika sudah login dan role admin, redirect ke /admin
        if ($session->get('isLoggedIn') && $session->get('role') === 'admin') {
            return redirect()->to('/admin');
        }

        $model = new GambarModel();
        $data_gallery = $model->findAll();
        
        $modelAbout = new AboutModel();
        $data_about = $modelAbout->findAll();

        $data_services = [
            ['title' => 'sv-1.jpg', 'content' => 'DIGITALISASI ARSIP MENJADI BENTUK DIGITAL'],
            ['title' => 'sv-2.jpg', 'content' => 'RESTORASI ARSIP BERHARGA YANG RUSAK'],
            ['title' => 'sv-3.jpg', 'content' => 'PENGOLAHAN DAN PENATAAN ARSIP DAN RUANG ARSIP'],
            ['title' => 'sv-4.png', 'content' => 'PELATIHAN DAN KONSULTASI KEARSIPAN'],
            ['title' => 'sv-5.png', 'content' => 'PENGADAAN SARANA DAN PRASARANA KEARSIPAN.']
        ];

        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home');
        echo view('content/about', ['data_about' => $data_about]);
        echo view('content/services', ['data_services' => $data_services]);
        echo view('content/profile');
        echo view('content/gallery', ['galeri' => $data_gallery]);
        echo view('content/client');
        echo view('content/contact');
        echo view('layout/footer');
    }

    // Admin Dashboard - hanya bisa diakses oleh admin yang sudah login
    public function admin()
    {
        $model = new GambarModel();
        $data_gallery = $model->findAll();

        $modelAbout = new AboutModel();
        $data_about = $modelAbout->findAll();


        $data_services = [
            ['title' => 'sv-1.jpg', 'content' => 'DIGITALISASI ARSIP MENJADI BENTUK DIGITAL'],
            ['title' => 'sv-2.jpg', 'content' => 'RESTORASI ARSIP BERHARGA YANG RUSAK'],
            ['title' => 'sv-3.jpg', 'content' => 'PENGOLAHAN DAN PENATAAN ARSIP DAN RUANG ARSIP'],
            ['title' => 'sv-4.png', 'content' => 'PELATIHAN DAN KONSULTASI KEARSIPAN'],
            ['title' => 'sv-5.png', 'content' => 'PENGADAAN SARANA DAN PRASARANA KEARSIPAN.']
        ];


        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home');
        echo view('content/about', ['data_about' => $data_about]);
        echo view('content/services', ['data_services' => $data_services]);
        echo view('content/profile');
        echo view('content/gallery', ['galeri' => $data_gallery]);
        echo view('content/client');
        echo view('content/contact');
        echo view('layout/footer');
    }
}
