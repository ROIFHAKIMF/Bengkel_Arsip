<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController {
    public function login()
    {
        // Jika sudah login, langsung ke dashboard berdasarkan role
        if (session()->get('isLoggedIn')) {
            $role = session()->get('role');
            if ($role == 'admin') {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/user');
            }
        }

        // Tampilkan halaman login jika belum login
        echo view('layout/header');
        echo view('content/login');
    }

    public function processLogin()
    {
        // Proses login dengan username dan password
        if ($this->request->getPost()) {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            // Data pengguna untuk login, username dan password
            $dataUsers = [
                'Roif_Hakim' => [
                    'username' => 'Roif_Hakim',
                    'password' => 'admin123', // password tanpa MD5
                    'role' => 'admin'
                ],
                'Nafiah' => [
                    'username' => 'Nafiah',
                    'password' => 'user123', // password tanpa MD5
                    'role' => 'user'
                ]
            ];

            // Cek apakah username ada dalam dataUsers
            if (isset($dataUsers[$username])) {
                if ($dataUsers[$username]['password'] == $password) {
                    session()->set([
                        'username' => $dataUsers[$username]['username'],
                        'role' => $dataUsers[$username]['role'],
                        'isLoggedIn' => TRUE
                    ]);

                    // Redirect sesuai role setelah login
                    if ($dataUsers[$username]['role'] == 'admin') {
                        return redirect()->to('/admin');
                    } else {
                        return redirect()->to('/user');
                    }
                } else {
                    // Jika password salah, beri alert
                    session()->setFlashdata('failed', 'Password salah');
                    return redirect()->to('/login');
                }
            } else {
                // Jika username tidak ditemukan, beri alert
                session()->setFlashdata('failed', 'Username tidak ditemukan');
                return redirect()->to('/login');
            }
        }
    }

    // Fungsi logout
    public function logout()
    {
        session()->destroy(); // Hapus session
        return redirect()->to('/login'); // Kembali ke halaman login
    }
}
