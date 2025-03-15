<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'user'
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'Owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'owner'
        ]);
        User::factory()->create([
            'name' => 'Kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'kasir'
        ]);
    }
}
