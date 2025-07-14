<?php

namespace App\Controllers;

use App\Models\GambarModel;
use App\Models\AboutModel;
use App\Models\ServiceModel;
use App\Models\ClientModel;
use App\Models\SocialMediaModel;

class GuestController extends BaseController
{
    public function index()
    {
        $gambarModel = new GambarModel();
        $aboutModel = new AboutModel();
        $serviceModel = new ServiceModel();
        $clientModel = new ClientModel();
        $socialModel = new SocialMediaModel();

        $data_gallery = $gambarModel->findAll();
        $data_about = $aboutModel->findAll();
        $data_services = $serviceModel->findAll();
        $service_id = $this->request->getGet('service');
        $selected_service = $service_id ? $serviceModel->find($service_id) : null;

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

        if ($service_id && in_array($service_id, ['1','2','3','4','5'])) {
            echo view("content/Services/Service{$service_id}");
        } else {
            echo view('content/services', ['data_services' => $data_services]);
        }

        echo view('content/profile');
        echo view('content/gallery', ['galeri' => $data_gallery]);
        echo view('content/client', ['groupedClient' => $groupedClient]);
        echo view('content/contact');
        echo view('layout/footer', ['data_services' => $data_services, 'social' => $social]);
        
    }
}
