<?php

namespace App\Controllers;
use App\Models\BarangModel;
use App\Models\GambarModel;
use App\Models\AboutModel;
use App\Models\ServiceModel;
use App\Models\ClientModel;
use App\Models\SocialMediaModel;
use App\Models\TestimoniModel;
use App\Models\KonsultasiModel;

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

        $barangModel = new BarangModel();
        $data_barang = $barangModel->findAll();

        $KonsultasiModel = new KonsultasiModel();
        $data_konsultasi = $KonsultasiModel->findAll();

        $testimoniModel = new TestimoniModel(); $data_testimoni = $testimoniModel->findAll();

        $clientModel = new ClientModel();
        $clients = $clientModel->findAll();

        $groupedClient = [];
        foreach ($clients as $client) {
            $judul = trim($client['judul']);
            $groupedClient[$judul][] = $client;
        }

        $socialModel = new SocialMediaModel();
        $social = $socialModel->first();

        echo view('layout/header');
        echo view('content/nav');
        echo view('content/home', ['data_services' => $data_services, 'social' => $social]);
        echo view('content/about', [
            'data_about' => $data_about,
            'selected_about' => $selected_about
        ]);
        echo view('content/services', ['data_services' => $data_services]);
        echo view('content/partner');
        echo view('content/testimoni', ['data_testimoni' => $data_testimoni]);
        echo view('content/barang', ['data_barang' => $data_barang, 'social' => $social]);
        echo view('content/konsultasi', ['data_konsultasi' => $data_konsultasi]);
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

    // ==== CRUD Barang (Dropship) ====

public function tambahBarang()
{
    $model = new BarangModel();
    $file = $this->request->getFile('gambar');
    $fileName = '';

    if ($file && $file->isValid()) {
        $jumlahBarang = $model->countAll();
        $nextNumber = $jumlahBarang + 1;

        $ext = $file->getClientExtension();
        $fileName = "barang_{$nextNumber}." . $ext;
        $file->move('img', $fileName);
    }

    $model->save([
        'nama'      => $this->request->getPost('nama'),
        'harga'     => $this->request->getPost('harga'),
        'stok'      => $this->request->getPost('stok'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'gambar'    => $fileName,
    ]);

    return redirect()->to('/admin#barang')->with('success', 'Barang berhasil ditambahkan.');
}

public function editBarang()
{
    $model = new BarangModel();
    $id = $this->request->getPost('id');

    $data = [
        'nama'      => $this->request->getPost('nama'),
        'harga'     => $this->request->getPost('harga'),
        'stok'      => $this->request->getPost('stok'),
        'deskripsi' => $this->request->getPost('deskripsi'),
    ];

    $file = $this->request->getFile('gambar');
    if ($file && $file->isValid()) {
        $oldBarang = $model->find($id);

        if (!empty($oldBarang['gambar'])) {
            $oldPath = FCPATH . 'img/' . $oldBarang['gambar'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $ext = $file->getClientExtension();
        $fileName = "barang_{$id}." . $ext;
        $file->move('img/', $fileName, true);
        $data['gambar'] = $fileName;
    }

    $model->update($id, $data);
    return redirect()->to('/admin#barang')->with('success', 'Barang berhasil diedit.');
}

    public function hapusBarang()
    {
        $id = $this->request->getPost('id');
        $model = new BarangModel();

        $barang = $model->find($id);

        if ($model->delete($id)) {
            if (!empty($barang['gambar'])) {
                $filePath = FCPATH . 'img/' . $barang['gambar'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            session()->setFlashdata('alert', 'Barang berhasil dihapus.');
        } else {
            session()->setFlashdata('alert', 'Gagal menghapus barang.');
        }

        return redirect()->to('/admin#barang');
    }

    //fungsi testimoni
    public function tambahTestimoni(){
        $model = new TestimoniModel();
        $file = $this->request->getFile('foto');
        $fileName = '';

        if ($file && $file->isValid()) {
            $jumlahTestimoni = $model->countAll();
            $nextNumber = $jumlahTestimoni + 1;

            $ext = $file->getClientExtension();
            $fileName = "testimoni_{$nextNumber}." . $ext;
            $file->move('img', $fileName);
        }

        $model->save([
            'nama' => $this->request->getPost('nama'),
            'ulasan' => $this->request->getPost('ulasan'),
            'rating' => $this->request->getPost('rating'),
            'foto' => $fileName,
        ]);

        return redirect()->to('/admin#testimoni')->with('success', 'Testimoni berhasil ditambahkan.');
    }
    public function editTestimoni(){
        $model = new TestimoniModel();
        $id = $this->request->getPost('id');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'ulasan' => $this->request->getPost('ulasan'),
            'rating' => $this->request->getPost('rating'),
        ];

        $file = $this->request->getFile('foto');
        if ($file && $file->isValid()) {
            $oldTestimoni = $model->find($id);

            if (!empty($oldTestimoni['foto'])) {
                $oldPath = FCPATH . 'img/' . $oldTestimoni['foto'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $ext = $file->getClientExtension();
            $fileName = "testimoni_{$id}." . $ext;
            $file->move('img/', $fileName, true);
            $data['foto'] = $fileName;
        }

        $model->update($id, $data);
        return redirect()->to('/admin#testimoni')->with('success', 'Testimoni berhasil diedit.');
    }

    public function hapusTestimoni(){
        $id = $this->request->getPost('id');
        $model = new TestimoniModel();

        $testimoni = $model->find($id);

        if ($model->delete($id)) {
            if (!empty($testimoni['foto'])) {
                $filePath = FCPATH . 'img/' . $testimoni['foto'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            session()->setFlashdata('alert', 'Testimoni berhasil dihapus.');
        } else {
            session()->setFlashdata('alert', 'Gagal menghapus testimoni.');
        }

        return redirect()->to('/admin#testimoni');
    }

    //konsultasi CRUD
    public function tambahKonsultasi()
    {
        $model = new KonsultasiModel();
        $model->save([
            'nama_paket' => $this->request->getPost('nama_paket'),
            'harga'      => $this->request->getPost('harga'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ]);

        return redirect()->to('/admin#konsultasi')->with('success', 'Paket konsultasi berhasil ditambahkan.');
    }

    public function editKonsultasi()
    {
        $model = new KonsultasiModel();
        $id = $this->request->getPost('id');

        $data = [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'harga'      => $this->request->getPost('harga'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
        ];

        $model->update($id, $data);

        return redirect()->to('/admin#konsultasi')->with('success', 'Paket konsultasi berhasil diedit.');
    }

    public function hapusKonsultasi()
    {
        $id = $this->request->getPost('id');
        $model = new KonsultasiModel();

        if ($model->delete($id)) {
            session()->setFlashdata('alert', 'Konsultasi berhasil dihapus.');
        } else {
            session()->setFlashdata('alert', 'Gagal menghapus konsultasi.');
        }

        return redirect()->to('/admin#konsultasi');
    }
}