<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductApiController extends Controller
{
   public function search(Request $request)
    {
        $query = Product::with('category')
            ->withSum('stocks as stok', 'remaining_quantity')
            ->where('is_active', true)
            ->where('is_available', 'Available');

        if ($request->filled('query')) {
            $searchKeyword = $request->query('query');
            $query->where('name', 'like', '%' . $searchKeyword . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $products = $query->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'harga_jual' => $product->harga_jual,
                'harga_modal' => $product->estimasi_modal ?? 0,
                'stok' => $product->stok ?? 0,
                'stok_minimum' => $product->stok_minimum,
                'barcode' => $product->barcode,
                'is_modal_real' => $product->is_modal_real,
                'image' => $product->image,
                'category' => [
                    'id' => $product->category->id ?? null,
                    'name' => $product->category->name ?? null,
                ],
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ]);
    }
}