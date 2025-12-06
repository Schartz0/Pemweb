<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $userModel = new UserModel();

        $nama_user = $this->request->getPost('nama_user');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan nama_user (username)
        $user = $userModel->where('nama_user', $nama_user)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {

                $sessionData = [
                    'id_user'   => $user['id_user'],
                    'nama_user' => $user['nama_user'],
                    'role'      => $user['role'],
                    'kode_peran'=> $user['kode_peran'],
                    'logged_in' => true
                ];

                $session->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Password salah!');
            }
        } else {
            return redirect()->back()->with('error', 'User tidak ditemukan!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
