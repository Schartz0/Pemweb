<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nidn' => '123',
            'nama' => 'Radzi ratomi'
        ];

        $this->db->table('dosen')->insert($data);
    }
}
