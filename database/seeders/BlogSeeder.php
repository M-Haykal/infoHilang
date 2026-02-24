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
    }
}
