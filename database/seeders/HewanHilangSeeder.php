<?php

namespace Database\Seeders;

use App\Models\HewanHilang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HewanHilangSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $gambarHewan = ['laporan/semut.jpg', 'laporan/burung.jpg'];

        for ($i = 0; $i < 12; $i++) {
            $nama = $faker->firstName;
            HewanHilang::create([
                'nama_hewan' => $nama,
                'jenis_hewan' => $faker->randomElement(['Kucing', 'Anjing', 'Burung']),
                'ras' => $faker->word,
                'jenis_kelamin' => $faker->randomElement(['Jantan', 'Betina']),
                'umur' => $faker->numberBetween(1, 5),
                'warna' => $faker->safeColorName,
                'ciri_ciri' => 'Memakai kalung nama, bulu lebat',
                'deskripsi_hewan' => $faker->sentence(12),
                'foto' => [$faker->randomElement($gambarHewan)],
                'kontak' => $faker->phoneNumber,
                'lokasi_terakhir_dilihat' => $faker->address,
                'latitude' => $faker->latitude(-6.3, -6.1),
                'longitude' => $faker->longitude(106.7, 106.9),
                'tanggal_terakhir_dilihat' => $faker->date(),
                'status' => $faker->randomElement(['Hilang', 'Ditemukan']),
                'user_id' => 2,
                'slug' => Str::slug($nama) . '-' . Str::random(5),
            ]);
        }
    }
}
