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
            'username' => 'Admin InfoHilang',
            'email' => 'InfoHilang@gmail.com', 
            'password' => Hash::make('adminInfoHilang'),
            'role' => 'admin',
            'provinsi' => 'Jawa Barat',
            'kota' => 'Bandung',
            'kecamatan' => 'Bandung Kota',
            'kelurahan' => 'Bojongloa',
            'alamat' => 'Bojongloa Kidul, Bandung Kota, Jawa Barat',
            'no_hp' => '081234567890',
        ]);
    }
}
