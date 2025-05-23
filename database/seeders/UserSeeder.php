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
            'no_hp' => '081234567893',
            'password' => Hash::make('123456789'),
            'role' => 'User',
            'is_active' => true,
            'alamat' => 'Jln. Jawa 3, Sumbersari, Sumbersari, Jember',

        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'no_hp' => '081234567892',
            'password' => Hash::make('123456789'),
            'role' => 'Admin',
            'is_active' => true,
            'alamat' => 'Jln. Jawa 1, Sumbersari, Sumbersari, Jember',

        ]);
        User::factory()->create([
            'name' => 'Owner',
            'email' => 'owner@gmail.com',
            'no_hp' => '081234567891',
            'password' => Hash::make('123456789'),
            'role' => 'Owner',
            'is_active' => true,
            'alamat' => 'Jln. Jawa 7, Sumbersari, Sumbersari, Jember',
        ]);
        User::factory()->create([
            'name' => 'Kasir',
            'email' => 'kasir@gmail.com',
            'no_hp' => '081234567890',
            'password' => Hash::make('123456789'),
            'role' => 'Kasir',
            'is_active' => true,
            'alamat' => 'Jln. Jawa 2, Sumbersari, Sumbersari, Jember',
        ]);
        User::factory()->create([
            'name' => 'Kasir1',
            'email' => 'kasir1@gmail.com',
            'no_hp' => '081234567890',
            'password' => Hash::make('123456789'),
            'role' => 'Kasir',
            'is_active' => true,
            'alamat' => 'Jln. Jawa 2, Sumbersari, Sumbersari, Jember',
        ]);
        User::factory()->create([
            'name' => 'Kasir2',
            'email' => 'kasir2@gmail.com',
            'no_hp' => '081234567890',
            'password' => Hash::make('123456789'),
            'role' => 'Kasir',
            'is_active' => true,
            'alamat' => 'Jln. Jawa 2, Sumbersari, Sumbersari, Jember',
        ]);
    }
}
