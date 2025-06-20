<?php

namespace App\Controllers;

class DashboardController extends BaseController
{    // Halaman Utama (Home) - untuk pengunjung (belum login)
    public function index()
    {
        // Cek jika sudah login, maka redirect ke halaman sesuai role

        $data_about = [
            
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
            ];

        $data_about = [
            
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

    // User Dashboard - hanya bisa diakses oleh user yang sudah login
    public function user()
    {


        $data_about = [
            
        ];

        $data_services = [
            ];

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
