<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nim' => '2301020101',
            'nama' => 'Rivandi'
        ];

        $this->db->table('mahasiswa')->insert($data);
    }
}
