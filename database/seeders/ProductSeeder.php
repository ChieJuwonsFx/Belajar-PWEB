<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Es Teh Manis',
            'stok' => 50,
            'harga' => 5000,
            'deskripsi' => 'Es teh manis segar dengan gula asli.',
            'status' => 'Active',
            'image' => 'https://example.com/teh.jpg',
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'Nasi Goreng',
            'stok' => 30,
            'harga' => 15000,
            'deskripsi' => 'Nasi goreng enak dengan bumbu khas.',
            'status' => 'Active',
            'image' => 'https://example.com/nasgor.jpg',
            'category_id' => 2
        ]);

        Product::create([
            'name' => 'Keripik Kentang',
            'stok' => 40,
            'harga' => 7000,
            'deskripsi' => 'Keripik kentang renyah dan gurih.',
            'status' => 'Inactive',
            'image' => 'https://example.com/keripik.jpg',
            'category_id' => 3
        ]);
    }
}
