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
        $image = [
            [
                'filename' => 'produk1.jpg',
                'path' => 'https://m.media-amazon.com/images/I/41WpqIvJWRL._AC_UY436_QL65_.jpg'
            ],
            [
                'filename' => 'produk2.jpg',
                'path' => 'https://m.media-amazon.com/images/I/61ghDjhS8vL._AC_UY436_QL65_.jpg'
            ]
        ];
        
        Product::create([
            'name' => 'Es Teh Manis',
            'slug' => Str::slug('Es Teh Manis'),
            'stok' => 50,
            'harga' => 5000,
            'deskripsi' => 'Es teh manis segar dengan gula asli.',
            'komposisi' => 'Air, Gula, Teh',
            'rasa' => 'Manis',
            'berat' => '200',
            'image' => $image,
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
            'image' => $image,
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
            'image' => $image,
            'status' => 'Inactive',
            'category_id' => 3
        ]);
        Product::create([
            'name' => 'Keripik Kentang',
            'slug' => Str::slug('Keripik Kentang4'),
            'stok' => 40,
            'harga' => 7000,
            'deskripsi' => 'Keripik kentang renyah dan gurih.',
            'komposisi' => 'Kentang, Minyak, Garam',
            'rasa' => 'Asin',
            'berat' => '200',
            'image' => $image,
            'status' => 'Inactive',
            'category_id' => 3
        ]);
        Product::create([
            'name' => 'Keripik Kentang',
            'slug' => Str::slug('Keripik Kentang3'),
            'stok' => 40,
            'harga' => 7000,
            'deskripsi' => 'Keripik kentang renyah dan gurih.',
            'komposisi' => 'Kentang, Minyak, Garam',
            'rasa' => 'Asin',
            'berat' => '200',
            'image' => $image,
            'status' => 'Inactive',
            'category_id' => 3
        ]);
        Product::create([
            'name' => 'Keripik Kentang',
            'slug' => Str::slug('Keripik Kentang1'),
            'stok' => 40,
            'harga' => 7000,
            'deskripsi' => 'Keripik kentang renyah dan gurih.',
            'komposisi' => 'Kentang, Minyak, Garam',
            'rasa' => 'Asin',
            'berat' => '200',
            'image' => $image,
            'status' => 'Inactive',
            'category_id' => 3
        ]);
        Product::create([
            'name' => 'Keripik Kentang',
            'slug' => Str::slug('Keripik Kentang2'),
            'stok' => 40,
            'harga' => 7000,
            'deskripsi' => 'Keripik kentang renyah dan gurih.',
            'komposisi' => 'Kentang, Minyak, Garam',
            'rasa' => 'Asin',
            'berat' => '200',
            'image' => $image,
            'status' => 'Inactive',
            'category_id' => 3
        ]);
    }
}
