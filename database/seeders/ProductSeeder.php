<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            
            Product::create([
                'name' => fake()->name(),
                'slug' => Str::slug(fake()->name()),
                'deskripsi' => $this->generateProductDescription('halo'),
                'harga_jual' => rand(50000, 5000000),
                'stok_minimum' => rand(5, 20),
                'stok' => rand(5, 20),
                'image' => $this->generateProductImages($i),
                'is_available' => rand(0, 1) ? 'Available' : 'Unavailable',
                'is_active' => true,
                'is_stock_real' => true,
                'is_modal_real' => true,
                'estimasi_modal' => 0,
                'category_id' => Category::inRandomOrder()->first()->id,
                'unit_id' => Unit::inRandomOrder()->first()->id,
            ]);
        }
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