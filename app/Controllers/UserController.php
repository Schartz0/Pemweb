<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $mahasiswaModel;
    protected $dosenModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        $selectedRole = $this->request->getGet('role');
        $validRoles = ['admin', 'mahasiswa', 'dosen'];

        $query = $this->userModel->orderBy('role', 'ASC');
        if ($selectedRole && in_array($selectedRole, $validRoles, true)) {
            $query = $query->where('role', $selectedRole);
        }

        $users = $query->findAll();
        $users = array_map(function ($user) {
            $user['nama_peran'] = $this->getNamaPeran($user);
            return $user;
        }, $users);

        return view('admin/users/index', [
            'title' => 'Manajemen User',
            'users' => $users,
            'selectedRole' => $selectedRole,
        ]);
    }

    public function create()
    {
        return view('admin/users/form', [
            'title' => 'Tambah User',
            'user'  => null,
            'nama_peran' => old('nama_peran', ''),
        ]);
    }

    public function store()
    {
        $rules = [
            'nama_user' => 'required',
            'password'  => 'required|min_length[4]',
            'role'      => 'required|in_list[admin,mahasiswa,dosen]',
            'kode_peran'=> 'required',
            'nama_peran'=> 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'password'  => $this->request->getPost('password'),
            'role'      => $this->request->getPost('role'),
            'kode_peran'=> $this->request->getPost('kode_peran'),
        ];
        $namaPeran = $this->request->getPost('nama_peran');

        $this->userModel->insert($data);
        $this->syncPeranData($data['role'], $data['kode_peran'], $namaPeran);

        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $namaPeran = $this->getNamaPeran($user);

        return view('admin/users/form', [
            'title' => 'Edit User',
            'user'  => $user,
            'nama_peran' => $namaPeran,
        ]);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'nama_user' => 'required',
            'role'      => 'required|in_list[admin,mahasiswa,dosen]',
            'kode_peran'=> 'required',
            'nama_peran'=> 'required',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[4]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_user'   => $id,
            'nama_user' => $this->request->getPost('nama_user'),
            'role'      => $this->request->getPost('role'),
            'kode_peran'=> $this->request->getPost('kode_peran'),
        ];

        if ($password = $this->request->getPost('password')) {
            $data['password'] = $password;
        }

        $namaPeran = $this->request->getPost('nama_peran');

        $this->userModel->save($data);
        $this->syncPeranData($data['role'], $data['kode_peran'], $namaPeran);

        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);
        $this->deletePeranData($user['role'], $user['kode_peran']);

        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil dihapus.');
    }

    protected function syncPeranData(string $role, string $kodePeran, string $namaPeran): void
    {
        if ($role === 'mahasiswa') {
            $this->mahasiswaModel->save([
                'nim'  => $kodePeran,
                'nama' => $namaPeran,
            ]);
        } elseif ($role === 'dosen') {
            $this->dosenModel->save([
                'nidn' => $kodePeran,
                'nama' => $namaPeran,
            ]);
        }
    }

    protected function deletePeranData(string $role, string $kodePeran): void
    {
        if ($role === 'mahasiswa') {
            $this->mahasiswaModel->delete($kodePeran);
        } elseif ($role === 'dosen') {
            $this->dosenModel->delete($kodePeran);
        }
    }

    protected function getNamaPeran(array $user): ?string
    {
        if ($user['role'] === 'mahasiswa') {
            $data = $this->mahasiswaModel->find($user['kode_peran']);
            return $data['nama'] ?? null;
        }

        if ($user['role'] === 'dosen') {
            $data = $this->dosenModel->find($user['kode_peran']);
            return $data['nama'] ?? null;
        }

        return null;
    }
}
