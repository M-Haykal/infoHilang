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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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
    }
}
