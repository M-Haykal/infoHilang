<?php

namespace Database\Seeders;

use App\Models\BarangHilang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BarangHilangSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $gambarBarang = ['laporan/dompet.jpg', 'laporan/tas.jpg'];

        for ($i = 0; $i < 5; $i++) {
            $nama = $faker->randomElement(['Dompet Kulit', 'Tas Ransel', 'Kunci Motor', 'Handphone']);
            BarangHilang::create([
                'nama_barang' => $nama,
                'jenis_barang' => $faker->randomElement(['Elektronik', 'Aksesoris', 'Dokumen']),
                'merk_barang' => $faker->company,
                'warna_barang' => $faker->safeColorName,
                'deskripsi_barang' => $faker->sentence(15),
                'lokasi_terakhir_dilihat' => $faker->address,
                'latitude' => $faker->latitude(-6.3, -6.1),
                'longitude' => $faker->longitude(106.7, 106.9),
                'tanggal_terakhir_dilihat' => $faker->date(),
                'ciri_ciri' => $faker->words(5, true),
                'kontak' => $faker->phoneNumber,
                'foto' => [$faker->randomElement($gambarBarang)], // ambil dari public/laporan
                'status' => $faker->randomElement(['Hilang', 'Ditemukan']),
                'user_id' => 2,
                'slug' => Str::slug($nama) . '-' . Str::random(5),
            ]);
        }
    }
}
