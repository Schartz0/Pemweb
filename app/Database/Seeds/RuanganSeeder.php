<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RuanganSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_ruangan' => 'Lab Komputer 1'],
            ['nama_ruangan' => 'Lab Komputer 2'],
            ['nama_ruangan' => 'Ruang Kelas 1'],
            ['nama_ruangan' => 'Ruang Kelas 2'],
            ['nama_ruangan' => 'Ruang Kelas 3'],
            ['nama_ruangan' => 'Ruang Kelas 4'],
            ['nama_ruangan' => 'Ruang Kelas 5'],
            ['nama_ruangan' => 'Ruang Seminar'],
            ['nama_ruangan' => 'Auditorium'],
        ];

        $this->db->table('ruangan')->insertBatch($data);
    }
}
