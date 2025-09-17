<?php
// File: database/seeders/AdminSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'first_name' => 'Mosaddek',
            'last_name' => 'Ali',
            'email' => 'shishirkuet63@gmail.com',
            'password' => Hash::make('Vitruvian09csg1.6textabs'),
            'phone' => '01324207402',
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create sample doctor user
        $doctorUser = User::create([
            'first_name' => 'Jubair',
            'last_name' => 'Husain',
            'email' => 'atifeenz@gmail.com',
            'password' => Hash::make('2107029'),
            'phone' => '01302460249',
            'role' => 'doctor',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create sample patient user
        User::create([
            'first_name' => 'Apu',
            'last_name' => 'Sharma',
            'email' => 'apusharma@gmail.com',
            'password' => Hash::make('2107005'),
            'phone' => '0160367389',
            'role' => 'patient',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}