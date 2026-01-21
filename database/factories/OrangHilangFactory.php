<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrangHilang>
 */
class OrangHilangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = $this->faker->name();
        return [
            'nama_orang' => $nama,
            'deskripsi_orang' => $this->faker->paragraph(3),
            'umur' => $this->faker->numberBetween(5, 70),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'ciri_ciri' => [
                'Tinggi' => $this->faker->numberBetween(100, 180) . ' cm',
                'Rambut' => $this->faker->randomElement(['Hitam lurus', 'Cokelat ikal', 'Botak']),
                'Pakaian' => 'Memakai baju warna ' . $this->faker->safeColorName(),
            ],
            'foto' => [
                'https://i.pravatar.cc/400?u=' . Str::random(10),
            ],
            'kontak' => [
                'WhatsApp' => $this->faker->phoneNumber(),
                'Telegram' => '@' . strtolower(Str::random(8)),
            ],
            'lokasi_terakhir_dilihat' => $this->faker->address(),
            'latitude' => $this->faker->latitude(-6.3, -6.1),
            'longitude' => $this->faker->longitude(106.7, 106.9),
            'tanggal_terakhir_dilihat' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => 'Hilang',
            'user_id' => \App\Models\User::factory(),
            'slug' => Str::slug($nama) . '-' . Str::random(5),
        ];
    }
}
