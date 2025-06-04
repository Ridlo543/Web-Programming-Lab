<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ridlo',
            'email' => 'ridlo@example.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Salsa',
            'email' => 'salsa@example.com',
            'phone_number' => '089876543210',
            'password' => Hash::make('password'),
        ]);
    }
}
