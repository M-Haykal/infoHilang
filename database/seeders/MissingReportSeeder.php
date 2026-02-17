<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\OrangHilang;
use App\Models\HewanHilang;
use App\Models\LaporanDitemukan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MissingReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'fullname' => 'Citra Developer',
            'username' => 'citra_dev',
            'email' => 'citra@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'no_hp' => '081234567890',
        ]);

        $orang = OrangHilang::create([
            'nama_orang' => 'Budi Santoso',
            'deskripsi_orang' => 'Terakhir terlihat memakai kaos biru di sekitar taman.',
            'umur' => 65,
            'jenis_kelamin' => 'Laki-laki',
            'ciri_ciri' => ['Rambut' => 'Beruban', 'Tinggi' => '165cm', 'Kacamata' => 'Ya'],
            'foto' => ['orang1.jpg'],
            'kontak' => ['Nomor WhatsApp' => '081299998888'],
            'lokasi_terakhir_dilihat' => 'Taman Ganesha, Bandung',
            'latitude' => -6.89148,
            'longitude' => 107.61065,
            'tanggal_terakhir_dilihat' => now()->subDays(2),
            'status' => 'Hilang',
            'user_id' => $user->id,
            'slug' => Str::slug('Budi Santoso ' . Str::random(5)),
        ]);

        $hewan = HewanHilang::create([
            'nama_hewan' => 'Mochi',
            'jenis_hewan' => 'Kucing',
            'ras' => 'Persia',
            'jenis_kelamin' => 'Betina',
            'umur' => 2,
            'warna' => 'Putih Abu',
            'ciri_ciri' => ['Kalung' => 'Warna Merah', 'Ekor' => 'Pendek/Bundel'],
            'deskripsi_hewan' => 'Kucing jinak, takut dengan suara petir.',
            'foto' => ['kucing1.jpg'],
            'kontak' => ['Nomor WhatsApp' => '081299998888'],
            'lokasi_terakhir_dilihat' => 'Jl. Dago No. 10',
            'status' => 'Hilang',
            'user_id' => $user->id,
            'slug' => Str::slug('Mochi ' . Str::random(5)),
        ]);

        LaporanDitemukan::create([
            'nama_penemu' => 'Rizky Amalia',
            'kontak_penemu' => '085566778899',
            'keterangan' => 'Saya melihat bapak ini duduk sendirian di halte.',
            'lokasi_ditemukan' => 'Halte Simpang Dago',
            'bukti_ditemukan' => 'bukti1.jpg',
            'foundable_type' => OrangHilang::class,
            'foundable_id' => $orang->id,
            'user_id' => null,
            'is_confirmed' => 1,
        ]);

        LaporanDitemukan::create([
            'nama_penemu' => 'Anonim',
            'kontak_penemu' => '087711223344',
            'keterangan' => 'Ada kucing mirip Mochi di depan minimarket.',
            'lokasi_ditemukan' => 'Indomaret Dago',
            'bukti_ditemukan' => 'bukti2.jpg',
            'foundable_type' => HewanHilang::class,
            'foundable_id' => $hewan->id,
            'user_id' => null,
            'is_confirmed' => 0,
        ]);
    }
}
