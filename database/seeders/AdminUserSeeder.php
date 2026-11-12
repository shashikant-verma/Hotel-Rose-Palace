<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hotelrosepalace.com',
            'password' => Hash::make('password123'), // Change this!
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create manager user
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@hotelrosepalace.com',
            'password' => Hash::make('password123'), // Change this!
            'role' => 'manager',
            'is_active' => true,
        ]);
    }
}
