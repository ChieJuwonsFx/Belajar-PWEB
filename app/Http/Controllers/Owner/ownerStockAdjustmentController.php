<?php

namespace App\Http\Controllers\Owner;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\StockAdjustment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ownerStockAdjustmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::with(['product.category', 'stockAdjustments.user', 'stockAdjustments.stock']);
    
        if ($request->category_id) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }
    
        if ($request->product_name) {
            $productName = strtolower($request->product_name);
            $query->whereHas('product', function ($q) use ($productName) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$productName}%"]);
            });
        }
    
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ]);
        }
    
        $stocks = $query->latest()->get();
        $categories = Category::all();
    
        return view('owner.produk.stockAdjustment', compact('stocks', 'categories'));
    }

    public function store(Request $request, $id){
        $stock = Stock::findOrFail($id);
        StockAdjustment::create([
            'quantity' => $request->quantity,
            'alasan' => $request->alasan,
            'note' => $request->note,
            'stock_id' => $id,
            'created_by' => Auth::id()
        ]);
        $stock->update([
            'remaining_quantity' => $stock->remaining_quantity - $request->quantity,
        ]);
        

    }
}
