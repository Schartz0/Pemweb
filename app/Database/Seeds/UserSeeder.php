<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_user' => 'Admin Sistem',
                'password' => password_hash('123', PASSWORD_BCRYPT),
                'role' => 'admin',
                'kode_peran' => 'ADM001'
            ],
            [
                'nama_user' => 'Dosen User',
                'password' => password_hash('123', PASSWORD_BCRYPT),
                'role' => 'dosen',
                'kode_peran' => 'DOS001'
            ],
            [
                'nama_user' => 'Mahasiswa User',
                'password' => password_hash('123', PASSWORD_BCRYPT),
                'role' => 'mahasiswa',
                'kode_peran' => 'MHS001'
            ]
        ];

        $this->db->table('user')->insertBatch($data);
    }
}
