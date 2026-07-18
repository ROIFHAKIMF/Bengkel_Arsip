<?php

namespace App\Controllers;

use App\Models\GambarModel;
use App\Models\AboutModel;
use App\Models\ServiceModel;
use App\Models\ClientModel;
use App\Models\SocialMediaModel;
use App\Models\BarangModel;

class GuestController extends BaseController
{
    public function index()
    {
        $gambarModel = new GambarModel();
        $aboutModel = new AboutModel();
        $serviceModel = new ServiceModel();
        $clientModel = new ClientModel();
        $socialModel = new SocialMediaModel();
        $barangModel = new BarangModel();

        $data_gallery = $gambarModel->findAll();
        $data_about = $aboutModel->findAll();
        $data_services = $serviceModel->findAll();
        $data_barang = $barangModel->findAll();
        $clients = $clientModel->findAll();
        $groupedClient = [];
        foreach ($clients as $client) {
            $judul = trim($client['judul']);
            $groupedClient[$judul][] = $client;
        }

        $social = $socialModel->first();

        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home', ['data_services' => $data_services, 'social' => $social]);

        echo view('content/about', ['data_about' => $data_about]);

        echo view('content/services', ['data_services' => $data_services]);

        echo view('content/partner');
        echo view('content/barang', ['data_barang' => $data_barang, 'social' => $social]);
        
        echo view('content/profile');
        echo view('content/gallery', ['galeri' => $data_gallery]);
        echo view('content/client', ['groupedClient' => $groupedClient]);
        echo view('content/contact');
        echo view('layout/footer', ['data_services' => $data_services, 'social' => $social]);
        
    }
}