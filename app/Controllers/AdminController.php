<?php

namespace App\Controllers;

use App\Models\GambarModel;
use App\Models\AboutModel;
use App\Models\ServiceModel;
use App\Models\ClientModel;
use App\Models\SocialMediaModel;

class AdminController extends BaseController
{
    protected $gambarModel;

    public function __construct()
    {
        $this->gambarModel = new GambarModel();
    }

    public function index()
    {
      $model = new GambarModel();
        $data_gallery = $model->findAll();

        $modelAbout = new AboutModel();
        $data_about = $modelAbout->findAll();

        $id = $this->request->getGet('id');
        $selected_about = $id ? $modelAbout->find($id) : null;

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

        $socialModel = new SocialMediaModel();
        $social = $socialModel->first();

        if ($service_id && in_array($service_id, ['1', '2', '3', '4', '5'])) {
            echo view('layout/header');
            echo view('content/nav');
            echo view('content/home');
            echo view('content/about', ['data_about' => $data_about]);
            echo view("content/Services/Service{$service_id}");
            echo view('content/profile');
            echo view('content/gallery', ['galeri' => $data_gallery]);
            echo view('content/client', ['groupedClient' => $groupedClient]);
            echo view('content/contact');
            echo view('layout/footer', ['data_services' => $data_services, 'social' => $social]);
            return;
        }

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
        echo view('layout/footer', ['data_services' => $data_services, 'social' => $social]);
    }

    // Tambahkan semua fungsi CRUD: tambah/edit/hapus Service, Client, Gallery, About, dan updateSocialMedia di sini
     public function createService()
    {
        return view('service_form');
    }

public function tambahService()
{
    $model = new ServiceModel();
    $file = $this->request->getFile('title');
    $fileName = '';

    if ($file && $file->isValid()) {
        $jumlahService = $model->countAll();
        $nextNumber = $jumlahService + 1;

        $ext = $file->getClientExtension();
        $fileName = "service_{$nextNumber}." . $ext;
        $file->move('img', $fileName);
    }

    $model->save([
        'title' => $fileName,
        'content' => $this->request->getPost('content')
    ]);

    return redirect()->to('/admin#service');
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
        $oldService = $model->find($id);

        if (!empty($oldService['title'])) {
            $oldPath = FCPATH . 'img/' . $oldService['title'];
            if (file_exists($oldPath)) {
                if (unlink($oldPath)) {
                    session()->setFlashdata('alert', 'Gambar lama berhasil dihapus.');
                } else {
                    session()->setFlashdata('alert', 'Gagal menghapus gambar lama.');
                }
            } else {
                session()->setFlashdata('alert', 'File lama tidak ditemukan.');
            }
        }

        $ext = $file->getClientExtension();
        $fileName = "service_{$id}." . $ext;
        $file->move('img/', $fileName, true);
        $data['title'] = $fileName;
    }

    $model->update($id, $data);
    return redirect()->to('/admin#service')->with('success', 'Service berhasil diedit.');
}



public function hapusService()
{
    $id = $this->request->getPost('id');
    $model = new ServiceModel();

    $service = $model->find($id); // Ambil data sebelum dihapus

    if ($model->delete($id)) {
        // Coba hapus file gambarnya kalau ada
        if (!empty($service['title'])) {
            $filePath = FCPATH . 'img/' . $service['title'];
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    session()->setFlashdata('alert', 'Service dan file gambar berhasil dihapus.');
                } else {
                    session()->setFlashdata('alert', 'Service dihapus, tapi file gambar gagal dihapus.');
                }
            } else {
                session()->setFlashdata('alert', 'Service dihapus, tapi file gambar tidak ditemukan.');
            }
        } else {
            session()->setFlashdata('alert', 'Service berhasil dihapus (tanpa file gambar).');
        }

        return redirect()->to('/admin#service')->with('success', 'Service berhasil dihapus.');
    } else {
        return redirect()->to('/admin#service')->with('error', 'Gagal menghapus service.');
    }
}

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
        $jumlahClient = $clientModel->countAll();
        $nextNumber = $jumlahClient + 1;

        $ext = $file->getClientExtension();
        $fileName = "client_{$nextNumber}." . $ext;

        $file->move('img/', $fileName);
        $data['gambar'] = $fileName;
    }

    $clientModel->save($data);
    session()->setFlashdata('alert', 'Client berhasil ditambahkan.');
    return redirect()->to('/admin#client');
}

public function editClient()
{
    $clientModel = new ClientModel();
    $id = $this->request->getPost('id');
    $client = $clientModel->find($id);

    $data = [
        'judul'     => $this->request->getPost('judul'),
        'deskripsi' => $this->request->getPost('deskripsi')
    ];

    $file = $this->request->getFile('gambar');
    if ($file && $file->isValid()) {
        // Hapus gambar lama kalau ada
        if (!empty($client['gambar'])) {
            $oldPath = FCPATH . 'img/' . $client['gambar'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $ext = $file->getClientExtension();
        $fileName = 'client_' . $id . '.' . $ext;

        $file->move('img/', $fileName, true);
        $data['gambar'] = $fileName;
    }

    $clientModel->update($id, $data);
    session()->setFlashdata('alert', 'Client berhasil diedit.');
    return redirect()->to('/admin#client');
}

public function hapusClient()
{
    $clientModel = new ClientModel();
    $id = $this->request->getPost('id');
    $client = $clientModel->find($id);

    if ($clientModel->delete($id)) {
        if (!empty($client['gambar'])) {
            $filePath = FCPATH . 'img/' . $client['gambar'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        session()->setFlashdata('alert', 'Client berhasil dihapus.');
    } else {
        session()->setFlashdata('alert', 'Gagal menghapus client.');
    }

    return redirect()->to('/admin#client');
}


    public function tambahAbout()
    {
        $model = new AboutModel();
        $model->save([
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content')
        ]);

        return redirect()->to('/admin#about')->with('success', 'Data About berhasil ditambahkan.');
    }

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

public function tambahgallery()
{
    $gambar = $this->request->getFile('gambar');
    
    if ($gambar && $gambar->isValid()) {
        $jumlah = $this->gambarModel->countAll();
        $nextNumber = $jumlah + 1;

        $ext = $gambar->getClientExtension();
        $gambarName = "gallery_{$nextNumber}." . $ext;

        $gambar->move('img', $gambarName);
    }

    $this->gambarModel->save([
        'gambar'     => $gambarName ?? null,
        'deskripsi'  => $this->request->getPost('deskripsi'),
        'judul'      => $this->request->getPost('judul'),
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
        $ext = $gambar->getClientExtension();
        $gambarName = "gallery_{$id}." . $ext;

        $gambar->move('img', $gambarName, true);
        $data['gambar'] = $gambarName;
    }

    $this->gambarModel->update($id, $data);

    return redirect()->back()->with('success', 'Galeri berhasil diupdate!')->to('/admin#gallery');
}


public function hapusgallery()
{
    $id = $this->request->getPost('id');
    $galeri = $this->gambarModel->find($id);

    if ($this->gambarModel->delete($id)) {
        if (!empty($galeri['gambar'])) {
            $path = FCPATH . 'img/' . $galeri['gambar'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return redirect()->back()->with('success', 'Galeri berhasil dihapus!')->to('/admin#gallery');
    }

    return redirect()->back()->with('error', 'Gagal menghapus galeri!')->to('/admin#gallery');
}


    public function updateSocialMedia()
    {
        $model = new SocialMediaModel();
        $id = $this->request->getPost('id');

        // Ambil data lama dari database
        $oldData = $model->find($id);

        if (!$oldData) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // Ambil data dari POST tapi hanya isi kolom yang dikirim
        $newData = [];

        if ($this->request->getPost('wa_number') !== null) {
            $newData['wa_number'] = $this->request->getPost('wa_number');
        } else {
            $newData['wa_number'] = $oldData['wa_number'];
        }

        if ($this->request->getPost('instagram') !== null) {
            $newData['instagram'] = $this->request->getPost('instagram');
        } else {
            $newData['instagram'] = $oldData['instagram'];
        }

        if ($this->request->getPost('facebook') !== null) {
            $newData['facebook'] = $this->request->getPost('facebook');
        } else {
            $newData['facebook'] = $oldData['facebook'];
        }

        if ($this->request->getPost('youtube') !== null) {
            $newData['youtube'] = $this->request->getPost('youtube');
        } else {
            $newData['youtube'] = $oldData['youtube'];
        }

        if ($this->request->getPost('email') !== null) {
            $newData['email'] = $this->request->getPost('email');
        } else {
            $newData['email'] = $oldData['email'];
        }

        $model->update($id, $newData);

        return redirect()->back()->with('success', 'Data media sosial berhasil diperbarui!');
    }

}
