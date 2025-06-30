<?php

namespace App\Controllers;

use App\Models\GambarModel;
use App\Models\AboutModel;
use App\Models\ServiceModel;
use App\Models\ClientModel;
use Dompdf\Dompdf;
use Dompdf\Options;

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

    // Ambil ID dari URL (GET) untuk modal edit
    $id = $this->request->getGet('id');
    $selected_about = null;
    if ($id) {
        $selected_about = $modelAbout->find($id);
    }

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
    echo view('content/about', [
        'data_about' => $data_about,
        'selected_about' => $selected_about // <- Tambahkan ini
    ]);
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

    // Tambah About
public function tambahAbout()
{
    $model = new AboutModel();
    $model->save([
        'title' => $this->request->getPost('title'),
        'content' => $this->request->getPost('content')
    ]);

    return redirect()->to('/admin#about')->with('success', 'Data About berhasil ditambahkan.');
}

// Edit About
public function editAbout()
{
    $model = new AboutModel();

    $id = $this->request->getPost('id');
    $model->update($id, [
        'title' => $this->request->getPost('title'),
        'content' => $this->request->getPost('content')
    ]);

    return redirect()->to('/admin#about')->with('success', 'Data About berhasil diedit.');
}

// Hapus About
public function hapusAbout()
{
    $id = $this->request->getPost('id');
    $model = new AboutModel();

    if ($model->delete($id)) {
        return redirect()->back()->with('success', 'Data berhasil dihapus')->to('/admin#about');
    } else {
        return redirect()->back()->with('error', 'Gagal menghapus data')->to('/admin#about');
    }
}

// Tambah Client
public function tambahClient()
{
    $clientModel = new ClientModel();

    $data = [
        'judul'     => $this->request->getPost('judul'),
        'deskripsi' => $this->request->getPost('deskripsi')
    ];

    $file = $this->request->getFile('gambar');
    if ($file && $file->isValid()) {
        $fileName = $file->getRandomName();
        $file->move('img/', $fileName);
        $data['gambar'] = $fileName;
    }

    $clientModel->save($data);
    return redirect()->to('/admin#client')->with('success', 'Client berhasil ditambahkan.');
}

// Edit Client
public function editClient()
{
    $clientModel = new ClientModel();
    $id = $this->request->getPost('id');

    $data = [
        'judul'     => $this->request->getPost('judul'),
        'deskripsi' => $this->request->getPost('deskripsi')
    ];

    $file = $this->request->getFile('gambar');
    if ($file && $file->isValid()) {
        $fileName = $file->getRandomName();
        $file->move('img/', $fileName);
        $data['gambar'] = $fileName;
    }

    $clientModel->update($id, $data);
    return redirect()->to('/admin#client')->with('success', 'Client berhasil diedit.');
}

// Hapus Client
public function hapusClient()
{
    $clientModel = new ClientModel();
    $id = $this->request->getPost('id');

    if ($clientModel->delete($id)) {
        return redirect()->to('/admin')->with('success', 'Client berhasil dihapus.')->to('/admin#client');
    } else {
        return redirect()->to('/admin')->with('error', 'Gagal menghapus client.')->to('/admin#client');
    }
}

public function tambahgallery(){

}
public function editgallery(){

}
public function hapusgallery(){

}


}
