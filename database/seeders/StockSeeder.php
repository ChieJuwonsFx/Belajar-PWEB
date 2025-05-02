<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            Stock::create([
                'quantity' => rand(20, 100),
                'remaining_quantity' => rand(10, 90),
                'harga_modal' => rand(5000, 80000),
                'product_id' => Product::inRandomOrder()->first()->id,
                'expired_at' => now()->addMonths(rand(1, 6)),
            ]);
        }
    }
}
