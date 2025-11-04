<?php

namespace Database\Seeders;

use App\Models\mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 50 data mahasiswa menggunakan factory
        mahasiswa::factory(50)->create();
        
        // Atau buat data spesifik
        // mahasiswa::factory()->create([
        //     'nim' => '20101234567',
        //     'nama' => 'John Doe',
        //     'semester' => 5,
        //     'jenis_kelamin' => 'Laki-laki',
        //     'no_hp' => '081234567890',
        //     'jurusan' => 'Teknik Informatika',
        // ]);
    }
}
