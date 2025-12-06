<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\DosenModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();

        if (! $session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $role = $session->get('role');
        $kodePeran = $session->get('kode_peran');
        $namaLengkap = $session->get('nama_user');

        if ($role === 'mahasiswa') {
            $mahasiswa = (new MahasiswaModel())->find($kodePeran);
            if ($mahasiswa) {
                $namaLengkap = $mahasiswa['nama'];
            }
        } elseif ($role === 'dosen') {
            $dosen = (new DosenModel())->find($kodePeran);
            if ($dosen) {
                $namaLengkap = $dosen['nama'];
            }
        }

        $links = [
            'admin' => [
                ['label' => 'Kelola User', 'url' => base_url('admin/users')],
                ['label' => 'Kelola Mata Kuliah', 'url' => base_url('admin/mata-kuliah')],
                ['label' => 'Kelola Ruangan', 'url' => base_url('admin/ruangan')],
                ['label' => 'Kelola Jadwal', 'url' => base_url('admin/jadwal')],
            ],
            'mahasiswa' => [
                ['label' => 'Rencana Studi', 'url' => base_url('mahasiswa/rencana-studi')],
                ['label' => 'Hasil Studi', 'url' => base_url('mahasiswa/hasil-studi')],
            ],
            'dosen' => [
                ['label' => 'Jadwal Mengajar', 'url' => base_url('dosen/jadwal')],
            ],
        ];

        return view('dashboard/index', [
            'title' => 'Dashboard',
            'role'  => $role,
            'links' => $links[$role] ?? [],
            'namaLengkap' => $namaLengkap,
            'kodePeran' => $kodePeran,
        ]);
    }
}

