<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'firstname' => 'Admin',
            'lastname' => 'InfoHilang',
            'username' => 'infohilang',
            'email' => 'admin@infohilang.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        \App\Models\OrangHilang::factory(10)->create([
            'user_id' => $admin->id,
        ]);

        $this->call([
            BarangHilangSeeder::class,
            HewanHilangSeeder::class,
        ]);
    }
}
