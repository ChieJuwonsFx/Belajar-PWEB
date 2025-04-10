<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            
            Product::create([
                'name' => Str::random(12),
                'deskripsi' => $this->generateProductDescription('halo'),
                'harga_jual' => rand(50000, 5000000),
                'stok_minimum' => rand(5, 15),
                'image' => $this->generateProductImages($i),
                'is_available' => rand(0, 1) ? 'Active' : 'Inactive',
                'category_id' => 1,
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }
    }

    protected function generateProductName(int $categoryId): string
    {
        $names = [
            1 => ['Smartphone', 'Laptop', 'Headphone', 'Smart TV', 'Kamera Digital'],
            2 => ['Kemeja', 'Celana Jeans', 'Jaket', 'Gaun', 'Sepatu'],
            3 => ['Snack', 'Minuman', 'Makanan Ringan', 'Makanan Kaleng', 'Bahan Pokok'],
            4 => ['Panci', 'Blender', 'Vacuum Cleaner', 'Lampu', 'Kursi'],
            5 => ['Sepatu Lari', 'Treadmill', 'Dumbell', 'Yoga Mat', 'Bola Basket'],
        ];

        return $names[$categoryId][array_rand($names[$categoryId])];
    }

    protected function generateProductDescription(string $productName): string
    {
        $descriptions = [
            "Produk {$productName} berkualitas tinggi dengan bahan terbaik.",
            "{$productName} original dengan garansi resmi 1 tahun.",
            "Temukan pengalaman baru dengan {$productName} versi terbaru kami.",
            "{$productName} dengan desain modern dan fitur lengkap.",
            "Produk {$productName} yang nyaman dan tahan lama.",
        ];

        return $descriptions[array_rand($descriptions)];
    }

    protected function generateProductImages(int $index): string
    {
        $imageCount = rand(1, 4); 
        $images = [];

        for ($j = 0; $j < $imageCount; $j++) {
            $width = rand(800, 1200);
            $height = rand(600, 900);
            $imageId = $index * 10 + $j; 

            $images[] = [
                'path' => "https://picsum.photos/id/{$imageId}/{$width}/{$height}",
                'filename' => "product-{$index}-{$j}.jpg",
                'is_primary' => $j === 0
            ];
        }

        return json_encode($images);
    }
}