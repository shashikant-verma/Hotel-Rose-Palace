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
        // Delete existing admin users to avoid duplicates
        User::where('email', 'admin@hotelrose.com')->delete();
        User::where('email', 'manager@hotelrose.com')->delete();

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hotelrose.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create manager user
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@hotelrose.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'is_active' => true,
        ]);
    }
}
