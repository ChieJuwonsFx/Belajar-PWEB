<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
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
            'slug' => Str::slug('Es Teh Manis'),
            'stok' => 50,
            'harga' => 5000,
            'deskripsi' => 'Es teh manis segar dengan gula asli.',
            'komposisi' => 'Air, Gula, Teh',
            'rasa' => 'Manis',
            'berat' => '200',
            'status' => 'Active',
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'Nasi Goreng',
            'slug' => Str::slug('Nasi Goreng'),
            'stok' => 30,
            'harga' => 15000,
            'deskripsi' => 'Nasi goreng enak dengan bumbu khas.',
            'komposisi' => 'Nasi, Bumbu, Telur, Kecap',
            'rasa' => 'Gurih',
            'berat' => '200',
            'status' => 'Active',
            'category_id' => 2
        ]);

        Product::create([
            'name' => 'Keripik Kentang',
            'slug' => Str::slug('Keripik Kentang'),
            'stok' => 40,
            'harga' => 7000,
            'deskripsi' => 'Keripik kentang renyah dan gurih.',
            'komposisi' => 'Kentang, Minyak, Garam',
            'rasa' => 'Asin',
            'berat' => '200',
            'status' => 'Inactive',
            'category_id' => 3
        ]);
    }
}
