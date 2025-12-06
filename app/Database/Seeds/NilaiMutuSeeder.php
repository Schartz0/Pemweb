<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NilaiMutuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nilai_huruf' => 'A', 'nilai_mutu' => 4.0],
            ['nilai_huruf' => 'A-', 'nilai_mutu' => 3.5],
            ['nilai_huruf' => 'B', 'nilai_mutu' => 3.0],
            ['nilai_huruf' => 'B-', 'nilai_mutu' => 2.5],
            ['nilai_huruf' => 'C', 'nilai_mutu' => 2.0],
            ['nilai_huruf' => 'E', 'nilai_mutu' => 0.0],
        ];

        $this->db->table('nilai_mutu')->insertBatch($data);
    }
}
