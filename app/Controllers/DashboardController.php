<?php

namespace App\Controllers;

use App\Models\GambarModel;
use App\Models\AboutModel;
use App\Models\ServiceModel;
use App\Models\ClientModel;
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

       $modelService = new ServiceModel();
        $data_services = $modelService->findAll();

        $clientModel = new ClientModel();
        $clients = $clientModel->findAll();

        $groupedClient = [];
        foreach ($clients as $client) {
            $judul = trim($client['judul']);
            $groupedClient[$judul][] = $client;
        }

        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home');
        echo view('content/about', ['data_about' => $data_about]);
        echo view('content/services', ['data_services' => $data_services]);
        echo view('content/profile');
        echo view('content/gallery', ['galeri' => $data_gallery]);
        echo view('content/client', ['groupedClient' => $groupedClient]);
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
         
        
       $modelService = new ServiceModel();
       $data_services = $modelService->findAll();

        $clientModel = new ClientModel();
        $clients = $clientModel->findAll();

        $groupedClient = [];
        foreach ($clients as $client) {
            $judul = trim($client['judul']);
            $groupedClient[$judul][] = $client;
        }

        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home');
        echo view('content/about', ['data_about' => $data_about]);
        echo view('content/services', ['data_services' => $data_services]);
        echo view('content/profile');
        echo view('content/gallery', ['galeri' => $data_gallery]);
        echo view('content/client', ['groupedClient' => $groupedClient]);
        echo view('content/contact');
        echo view('layout/footer');  
    }

    // CRUD service
    public function createService()
    {
        return view('service_form');
    }

    public function storeService()
    {
        $model = new ServiceModel();
        $file = $this->request->getFile('title');
        
        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('img', $fileName);
        }

        $model->save([
            'title' => $fileName ?? '',
            'content' => $this->request->getPost('content')
        ]);

        return redirect()->to('/admin');
    }

    public function editService($id)
    {
        $model = new ServiceModel();
        $data['service'] = $model->find($id);
        return view('service_edit', $data);
    }

    public function updateService($id)
    {
        $model = new ServiceModel();

        $data = [
            'content' => $this->request->getPost('content')
        ];

        $file = $this->request->getFile('title');
        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('img', $fileName);
            $data['title'] = $fileName;
        }

        $model->update($id, $data);
        return redirect()->to('/admin');
    }

    public function deleteService($id)
    {
        $model = new ServiceModel();
        $model->delete($id);
        return redirect()->to('/admin');
    }

}
