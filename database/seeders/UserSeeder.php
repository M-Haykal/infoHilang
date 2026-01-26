<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'InfoHilang',
            'username' => 'infoHilang',
            'email' => 'infoHilang@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Bandung Kota',
            'kelurahan' => 'Bojongloa',
            'alamat' => 'Bojongloa Kidul, Bandung Kota, Jawa Barat',
            'no_hp' => '081234567890',
        ]);

        User::create([
            'firstname' => 'Kusuma',
            'lastname' => 'Wecitra',
            'username' => 'citra493',
            'email' => 'citranotes@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Depok',
            'kecamatan' => 'Cimanggis',
            'kelurahan' => 'Mekarsari',
            'alamat' => 'RT. 005/001',
            'no_hp' => '081234567890',
        ]);
    }
}
