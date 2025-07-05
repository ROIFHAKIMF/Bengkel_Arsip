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
    public function index(){
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

        $service_id = $this->request->getGet('service');
        $selected_service = $service_id ? $modelService->find($service_id) : null;

        $clientModel = new ClientModel();
        $clients = $clientModel->findAll();

        $groupedClient = [];
        foreach ($clients as $client) {
            $judul = trim($client['judul']);
            $groupedClient[$judul][] = $client;
        }

        // ⬇ Cek apakah ingin menampilkan detail service
        if ($service_id && in_array($service_id, ['1', '2', '3', '4', '5'])) {
            echo view('layout/header');
            echo view('content/nav');
            echo view('content/home');
            echo view('content/about', ['data_about' => $data_about]);
            echo view("content/Services/Service{$service_id}"); // Tampilkan detail Service
            echo view('content/profile');
            echo view('content/gallery', ['galeri' => $data_gallery]);
            echo view('content/client', ['groupedClient' => $groupedClient]);
            echo view('content/contact');
            echo view('layout/footer', ['data_services' => $data_services]);
            return;
        }

        // ⬇ Jika tidak klik tombol services, tampilkan normal
        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home');
        echo view('content/about', ['data_about' => $data_about]);
        echo view('content/services', ['data_services' => $data_services]);
        echo view('content/profile');
        echo view('content/gallery', ['galeri' => $data_gallery]);
        echo view('content/client', ['groupedClient' => $groupedClient]);
        echo view('content/contact');
        echo view('layout/footer', ['data_services' => $data_services]);
    }


    // Admin Dashboard - hanya bisa diakses oleh admin yang sudah login
   public function admin(){
    $model = new GambarModel();
    $data_gallery = $model->findAll();

        $modelAbout = new AboutModel();
        $data_about = $modelAbout->findAll();

        // Ambil ID untuk edit about
        $id = $this->request->getGet('id');
        $selected_about = null;
        if ($id) {
            $selected_about = $modelAbout->find($id);
        }

        // Ambil semua service
        $modelService = new ServiceModel();
        $data_services = $modelService->findAll();


        // Cek jika tombol service diklik
        $service_id = $this->request->getGet('service');
        $selected_service = null;
        if ($service_id) {
            $selected_service = $modelService->find($service_id);
        }

        // Client
        $clientModel = new ClientModel();
        $clients = $clientModel->findAll();

        $groupedClient = [];
        foreach ($clients as $client) {
            $judul = trim($client['judul']);
            $groupedClient[$judul][] = $client;
        }


        if ($service_id && in_array($service_id, ['1', '2', '3', '4', '5'])) {
            echo view('layout/header');
            echo view('content/nav');
            echo view('content/home');
            echo view('content/about', ['data_about' => $data_about]);
            echo view("content/Services/Service{$service_id}"); // Tampilkan detail Service
            echo view('content/profile');
            echo view('content/gallery', ['galeri' => $data_gallery]);
            echo view('content/client', ['groupedClient' => $groupedClient]);
            echo view('content/contact');
            echo view('layout/footer', ['data_services' => $data_services]);

            return;
        }
        // Render semua view
        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home');
        echo view('content/about', [
            'data_about' => $data_about,
            'selected_about' => $selected_about
        ]);
        echo view('content/services', [
            'data_services' => $data_services,
            'selected_service' => $selected_service 
        ]);
        echo view('content/profile');
        echo view('content/gallery', ['galeri' => $data_gallery]);
        echo view('content/client', ['groupedClient' => $groupedClient]);
        echo view('content/contact');
        echo view('layout/footer', ['data_services' => $data_services]);
    }



        // CRUD service
        public function createService()
        {
            return view('service_form');
        }

        public function tambahService()
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

        public function editService()
        {
            $model = new ServiceModel();
            $id = $this->request->getPost('id');

            $data = [
                'content' => $this->request->getPost('content')
            ];

            $file = $this->request->getFile('title');
            if ($file && $file->isValid()) {
                $fileName = $file->getRandomName();
                $file->move('img/', $fileName);
                $data['title'] = $fileName;
            }

            $model->update($id, $data);
            return redirect()->to('/admin#service')->with('success', 'Service berhasil diedit.');
        }

        public function hapusService()
        {
            $id = $this->request->getPost('id');
            $model = new ServiceModel();

            if ($model->delete($id)) {
                return redirect()->back()->with('success', 'Service berhasil dihapus.');
            } else {
                return redirect()->back()->with('error', 'Gagal menghapus service.');
            }
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

    $judul = $this->request->getPost('judul');
    $deskripsi = $this->request->getPost('deskripsi');

    $data = [
        'judul'     => $judul,
        'deskripsi' => $deskripsi
    ];

    $file = $this->request->getFile('gambar');
    if ($file && $file->isValid()) {
        // Hitung jumlah data client yang sudah ada
        $jumlahClient = $clientModel->countAll();
        $nextNumber = $jumlahClient + 1;

        $ext = $file->getClientExtension();
        $fileName = "client_{$nextNumber}." . $ext;

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
        $extension = $file->getClientExtension();
        $fileName = 'client_' . $id . '.' . $extension;

        $file->move('img/', $fileName, true); // overwrite = true
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

    // Ambil data client terlebih dahulu
    $client = $clientModel->find($id);

    // Hapus data dari database
    if ($clientModel->delete($id)) {
        // Jika ada gambar, hapus file-nya juga
        if (!empty($client->gambar)) {
            $filePath = FCPATH . 'img/' . $client->gambar;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return redirect()->to('/admin#client')->with('success', 'Client berhasil dihapus.');
    } else {
        return redirect()->to('/admin#client')->with('error', 'Gagal menghapus client.');
    }
}


        protected $gambarModel;

        public function __construct()
        {
            $this->gambarModel = new GambarModel();
        }

        public function tambahgallery()
        {
            $gambar = $this->request->getFile('gambar');
            $gambarName = $gambar->getRandomName();
            $gambar->move('img', $gambarName);

            $this->gambarModel->save([
                'gambar'     => $gambarName,
                'deskripsi'  => $this->request->getPost('deskripsi'),
                'judul'      => $this->request->getPost('judul'), // kalau tabel `gambar` punya kolom 'judul'
            ]);

            return redirect()->back()->with('success', 'Galeri berhasil ditambahkan!')->to('/admin#gallery');
        }

        public function editgallery()
        {
            $id = $this->request->getPost('id');
            $data = [
                'deskripsi' => $this->request->getPost('deskripsi'),
                'judul'     => $this->request->getPost('judul'),
            ];

            $gambar = $this->request->getFile('gambar');
            if ($gambar && $gambar->isValid()) {
                $gambarName = $gambar->getRandomName();
                $gambar->move('img', $gambarName);
                $data['gambar'] = $gambarName;
            }

            $this->gambarModel->update($id, $data);

            return redirect()->back()->with('success', 'Galeri berhasil diupdate!')->to('/admin#gallery');
        }

    public function hapusgallery()
    {
        $id = $this->request->getPost('id');
        $this->gambarModel->delete($id);
        return redirect()->back()->with('success', 'Galeri berhasil dihapus!')->to('/admin#gallery');
    }
}
