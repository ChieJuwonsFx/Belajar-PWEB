<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiKasirApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'unit')
            ->withSum('stocks as stok', 'remaining_quantity')
            ->where('is_active', true)
            ->where('is_available', 'Available');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->orderBy('is_available', 'asc')->get());
    }
}