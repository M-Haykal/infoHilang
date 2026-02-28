<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('username', 'citra493')->first() ?? User::first();

        if (!$user) {
            return;
        }

        Blog::create([
            'title' => '5 Langkah Pertama Saat Kehilangan Hewan Peliharaan',
            'slug' => Str::slug('5 Langkah Pertama Saat Kehilangan Hewan'),
            'content' => '<p>Kehilangan hewan peliharaan tentu membuat panik. Langkah pertama adalah tetap tenang dan segera menyisir radius 500 meter dari lokasi terakhir. Jangan lupa untuk mengunggah foto terbaru di platform InfoHilang agar komunitas sekitar bisa segera memantau.</p>',
            'image' => 'blog/tips-hewan.jpg',
            'user_id' => $user->id,
            'created_at' => now()->subDays(1),
        ]);

        Blog::create([
            'title' => 'Pentingnya Keamanan Data dalam Melaporkan Penemuan',
            'slug' => Str::slug('Pentingnya Keamanan Data dalam Melaporkan Penemuan'),
            'content' => '<p>Bagi para penemu, pastikan hanya memberikan informasi kontak melalui jalur resmi platform. Hindari memberikan alamat rumah secara langsung kepada orang yang belum terverifikasi. Keamanan bersama adalah prioritas utama kami di InfoHilang.</p>',
            'image' => 'blog/keamanan-data.jpg',
            'user_id' => $user->id,
            'created_at' => now(),
        ]);

        Blog::create([
            'title' => 'Strategi Mencari Dompet yang Hilang di Tempat Umum',
            'slug' => Str::slug('Strategi Mencari Dompet yang Hilang di Tempat Umum'),
            'content' => '
                <p>Kehilangan dompet di tempat umum seperti mal atau stasiun seringkali memicu kepanikan luar biasa. Namun, <strong>metode pencarian terstruktur</strong> dapat meningkatkan peluang penemuan hingga 70%.</p>
                <blockquote>"Kunci utama bukan pada seberapa cepat kita mencari, tapi seberapa teliti kita menelusuri kembali jejak langkah sendiri."</blockquote>
                <p>Berikut adalah langkah-langkah yang harus segera Anda lakukan:</p>
                <ul>
                    <li><strong>Hubungi Customer Service:</strong> Segera laporkan ke pusat informasi tempat tersebut.</li>
                    <li><strong>Blokir Kartu Penting:</strong> Jangan menunggu, amankan akses perbankan Anda melalui m-banking.</li>
                    <li><strong>Cek Area Tersembunyi:</strong> Seringkali dompet terselip di sela-sela kursi atau toilet yang Anda kunjungi.</li>
                </ul>
                <p><em>InfoHilang</em> menyarankan Anda untuk selalu menyimpan foto isi dompet sebagai data pendukung saat verifikasi kepemilikan nanti.</p>',
            'image' => 'blog/tips-dompet.jpg',
            'user_id' => $user->id,
            'created_at' => now()->subDays(2),
        ]);

        Blog::create([
            'title' => 'Cerita Haru Pertemuan Kembali Kakek Arifin Setelah 3 Hari',
            'slug' => Str::slug('Cerita Haru Pertemuan Kembali Kakek Arifin Setelah 3 Hari'),
            'content' => '
                <p>Kisah ini bermula saat Kakek Arifin (72th) meninggalkan rumah di Depok tanpa pamit. Keluarga yang cemas segera menyebarkan informasi melalui berbagai platform digital.</p>
                <p>Berkat laporan dari salah satu pengguna <strong>InfoHilang</strong> yang melihat beliau duduk sendirian di halte pasar, tim relawan langsung bergerak cepat. Pertemuan ini membuktikan bahwa:</p>
                <ol>
                    <li>Kekuatan komunitas digital sangat nyata dalam membantu pencarian orang.</li>
                    <li>Detail foto pakaian terakhir sangat membantu proses identifikasi di lapangan.</li>
                </ol>
                <p>Kami mengajak Anda semua untuk tetap <u>peka terhadap lingkungan sekitar</u>. Mungkin saja orang yang Anda temui di jalan adalah sosok yang sedang dicari oleh keluarganya.</p>',
            'image' => 'blog/cerita-kakek.jpg',
            'user_id' => $user->id,
            'created_at' => now()->subDays(3),
        ]);

        Blog::create([
            'title' => 'Mengapa Menghindari "Reward" Berlebihan itu Penting?',
            'slug' => Str::slug('Mengapa Menghindari Reward Berlebihan itu Penting'),
            'content' => '
                <p>Berniat memberikan imbalan besar sebagai rasa terima kasih adalah hal yang manusiawi. Namun, di dunia digital, hal ini bisa mengundang <strong>risiko penipuan</strong> (<em>scamming</em>).</p>
                <p>Beberapa alasan mengapa Anda harus bijak menentukan imbalan:</p>
                <ul>
                    <li><strong>Memicu Eksploitasi:</strong> Imbalan terlalu tinggi bisa menarik perhatian oknum yang sengaja mencari keuntungan.</li>
                    <li><strong>Potensi Penipuan:</strong> Penipu sering menghubungi pelapor dan mengaku menemukan barang hanya untuk meminta transfer uang muka.</li>
                </ul>
                <p>Di <strong>InfoHilang</strong>, kami mendorong budaya gotong royong yang tulus. Jika ingin memberikan imbalan, lakukanlah saat verifikasi fisik barang atau pertemuan orang sudah benar-benar terjadi dan di tempat yang aman.</p>',
            'image' => 'blog/tips-reward.jpg',
            'user_id' => $user->id,
            'created_at' => now()->subDays(4),
        ]);

        Blog::create([
            'title' => 'Menjadi Mata dan Telinga: Bagaimana Relawan Membantu Pencarian',
            'slug' => Str::slug('Menjadi Mata dan Telinga Bagaimana Relawan Membantu Pencarian'),
            'content' => '
                <p>Pernahkah Anda melihat poster orang hilang di tiang listrik dan merasa tidak bisa berbuat apa-apa? Di era digital, <strong>siapa pun bisa menjadi pahlawan</strong> tanpa harus meninggalkan aktivitas harian mereka.</p>
                <p>Menjadi relawan digital di <em>InfoHilang</em> sangatlah sederhana namun berdampak besar:</p>
                <ul>
                    <li><strong>Validasi Informasi:</strong> Membantu mengecek kebenaran informasi penemuan di area sekitar Anda tinggal.</li>
                    <li><strong>Penyebaran Berantai:</strong> Membagikan laporan aktif ke grup komunitas lokal (WhatsApp/Facebook) untuk mempercepat jangkauan.</li>
                    <li><strong>Dukungan Moral:</strong> Memberikan semangat kepada pelapor agar tidak merasa berjuang sendirian.</li>
                </ul>
                <blockquote>"Solidaritas adalah senjata terkuat kita saat teknologi dan metode pencarian biasa menemui jalan buntu."</blockquote>
                <p>Mari kita ingat kembali, bahwa setiap detik yang kita gunakan untuk memperhatikan lingkungan sekitar, bisa jadi merupakan detik-detik berharga bagi seseorang untuk bisa kembali ke pelukan keluarganya.</p>
                <p><em>Jadilah bagian dari perubahan. Jadilah mata dan telinga bagi mereka yang sedang mencari.</em></p>',
            'image' => 'blog/relawan-komunitas.jpg',
            'user_id' => $user->id,
            'created_at' => now()->subHours(5),
        ]);
    }
}
