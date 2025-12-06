<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_mata_kuliah' => 'TI101',
                'nama_mata_kuliah' => 'Pemrograman Web',
                'sks' => 3,
            ],
            [
                'kode_mata_kuliah' => 'TI102',
                'nama_mata_kuliah' => 'Basis Data',
                'sks' => 3,
            ],
        ];

        $this->db->table('mata_kuliah')->insertBatch($data);
    }
}
