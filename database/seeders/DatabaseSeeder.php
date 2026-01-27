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
        $this->call([
            UserSeeder::class,
        ]);

        $admin = \App\Models\User::where('username', 'citra493')->first();

        \App\Models\OrangHilang::factory(15)->create([
            'user_id' => $admin->id,
        ]);

        $this->call([
            UserSeeder::class,
            BarangHilangSeeder::class,
            HewanHilangSeeder::class,
        ]);
    }
}
