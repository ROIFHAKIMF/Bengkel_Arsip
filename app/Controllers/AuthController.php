<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            if (session()->get('role') === 'admin') {
                return redirect()->to('/admin');
            }
        }

        echo view('layout/header');
        echo view('content/login');
    }

    public function processLogin()
    {
        $model = new UserModel();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                session()->set([
                    'id'         => $user['id'],
                    'username'   => $user['username'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true
                ]);
                return redirect()->to('/admin');
            } else {
                session()->setFlashdata('failed', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            session()->setFlashdata('failed', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
