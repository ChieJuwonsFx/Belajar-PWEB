<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    
    public function run(): void
    {
        // User::factory(10)->create();
        
        // $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        // $this->call(ImageSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
