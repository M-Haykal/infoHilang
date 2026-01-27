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
        \App\Models\User::updateOrCreate(
            ['username' => 'infoHilang'],
            [
                'fullname' => 'Admin InfoHilang',
                'email' => 'infoHilang@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'kecamatan' => 'Bandung Kota',
                'kelurahan' => 'Bojongloa',
                'alamat' => 'Bojongloa Kidul, Bandung Kota, Jawa Barat',
                'no_hp' => '081234567890',
            ]
        );

        \App\Models\User::updateOrCreate(
            ['username' => 'citra493'],
            [
                'fullname' => 'Kusuma Wecitra',
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
            ]
        );
    }
}
