<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nim' => $this->faker->unique()->numerify('20#########'), // 11 digits, 20+9 random, adjust as needed
            'nama' => $this->faker->name(),
            'semester' => $this->faker->numberBetween(1, 14),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'no_hp' => $this->faker->unique()->numerify('08##########'),
            'jurusan' => $this->faker->randomElement([
                'Teknik Informatika',
                'Sistem Informasi',
                'Teknik Elektro',
                'Teknik Mesin',
                'Manajemen',
                'Akuntansi',
                'Hukum'
            ]),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
