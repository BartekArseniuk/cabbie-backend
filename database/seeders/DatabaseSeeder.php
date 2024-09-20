<?php

namespace Database\Seeders;

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
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Password@123'),
            'role' => 'admin',
        ]);

        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(10)->create();
        */
    }
}
