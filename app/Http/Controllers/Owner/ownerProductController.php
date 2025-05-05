<?php

namespace App\Http\Controllers\Owner;

use App\Models\Unit;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class ownerProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cacheKey = 'products.' . md5(json_encode($request->all()));
            
            $data = Cache::remember($cacheKey, now()->addMinutes(30), function() use ($request) {
                $categories = Category::all();
                $units = Unit::all();
                
                $query = Product::with(['category:id,name', 'unit:id,name'])
                    ->withSum(['stocks as stok' => function($q) {
                        $q->where('remaining_quantity', '>', 0);
                    }], 'remaining_quantity')
                    ->where('is_active', true)
                    ->select([
                        'id', 'name', 'barcode', 'harga_jual', 'stok_minimum', 
                        'image', 'is_available', 'category_id', 'unit_id'
                    ]);
    
                if ($request->filled('search')) {
                    $query->where(function($q) use ($request) {
                        $q->where('name', 'like', "%{$request->search}%")
                          ->orWhereHas('category', function($q) use ($request) {
                              $q->where('name', 'like', "%{$request->search}%");
                          });
                    });
                }
                
                if ($request->filled('category')) {
                    $query->where('category_id', $request->category);
                }
              
                $products = $query->orderBy('is_available')->paginate(16);
                
                return compact('products', 'categories', 'units');
            });
            
            return view('owner.produk.produk', $data);
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')
                ->with('alert_failed', 'Terjadi kesalahan saat melakukan load data produk: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $isStockReal = filter_var($request->is_stock_real, FILTER_VALIDATE_BOOLEAN);
            $isModalReal = filter_var($request->is_modal_real, FILTER_VALIDATE_BOOLEAN);
    
    
            if($isStockReal && $isModalReal){
                $product = Product::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'barcode' => $request->barcode,
                    'deskripsi' => $request->deskripsi,
                    'harga_jual' => $request->harga_jual,
                    'stok_minimum' => $request->stok_minimum,
                    'stok' => 0,
                    'image' => $request->images_json,
                    'is_available' => $request->is_available,
                    'is_active' => true,
                    'is_stock_real' => $request->is_stock_real,
                    'is_modal_real' => $request->is_modal_real,
                    'estimasi_modal'=> 1,
                    'category_id' => $request->category,
                    'unit_id' => $request->unit,
                ]);
                Stock::create([
                    'quantity' => $request->stok,
                    'remaining_quantity' => $request->stok,
                    'harga_modal' => $request->harga_modal,
                    'product_id' => $product->id
                ]);
            }
            elseif($isStockReal){
                $product = Product::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'barcode' => $request->barcode,
                    'deskripsi' => $request->deskripsi,
                    'harga_jual' => $request->harga_jual,
                    'stok_minimum' => $request->stok_minimum,
                    'stok' => $request->stok,
                    'image' => $request->images_json,
                    'is_available' => $request->is_available,
                    'is_active' => true,
                    'is_stock_real' => $request->is_stock_real,
                    'is_modal_real' => $request->is_modal_real,
                    'estimasi_modal'=> 1,
                    'category_id' => $request->category,
                    'unit_id' => $request->unit,
                ]);
            }
            else{
                Product::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'barcode' => $request->barcode,
                    'deskripsi' => $request->deskripsi,
                    'harga_jual' => $request->harga_jual,
                    'stok' => 0,
                    'stok_minimum' => $request->stok_minimum,
                    'image' => $request->images_json,
                    'is_available' => $request->is_available,
                    'is_active' => true,
                    'is_stock_real' => $request->is_stock_real,
                    'is_modal_real' => $request->is_modal_real,
                    'estimasi_modal'=> $request->harga_modal,
                    'category_id' => $request->category,
                    'unit_id' => $request->unit,
                ]);
            }

            Cache::flush(); 
            
            return redirect()->route('owner.produk')
                ->with('alert_success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')
                ->with('alert_failed', 'Terjadi kesalahan saat menambahkan produk: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $produk = Product::findOrFail($id);
            
            $produk->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'barcode' => $request->barcode,
                'deskripsi' => $request->deskripsi,
                'harga_jual' => $request->harga_jual,
                'stok_minimum' => $request->stok_minimum,
                'image' => $request->filled('image') ? $request->image : '[]',
                'is_available' => $request->is_available,
                'category_id' => $request->category,
                'unit_id' => $request->unit,
            ]);
            
            Cache::flush();
    
            return redirect()->route('owner.produk')
                ->with('alert_success', 'Produk berhasil diperbaharui');
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')
                ->with('alert_failed', 'Terjadi kesalahan saat memperbaharui produk: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $produk = Product::findOrFail($id);
            $produk->update(['is_active' => false]);
            
            Cache::flush();
    
            return redirect()->route('owner.produk')
                ->with('alert_success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')
                ->with('alert_failed', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }

    public function showBarcode($id)
    {
        $product = Product::findOrFail($id);
        $kode = $product->id;
        
        $cacheKey = "barcode.svg.{$kode}";
        
        return Cache::remember($cacheKey, now()->addWeek(), function() use ($kode) {
            $barcode = new DNS1D();
            $barcode->setStorPath(storage_path('framework/barcodes/'));
            
            return response($barcode->getBarcodeSVG($kode, 'C128', 1.5, 40), 200)
                ->header('Content-Type', 'image/svg+xml');
        });
    }
    

    public function downloadBarcode($kode)
    {
        $cacheKey = "barcode.png.{$kode}";
        
        return Cache::remember($cacheKey, now()->addWeek(), function() use ($kode) {
            $barcode = new DNS1D();
            $barcode->setStorPath(storage_path('framework/barcodes/'));
        
            $pngBase64 = $barcode->getBarcodePNG($kode, 'C128');
            $barcodeData = base64_decode($pngBase64);
            $barcodeImage = imagecreatefromstring($barcodeData);
        
            if (!$barcodeImage) {
                abort(500, 'Gagal membuat gambar barcode.');
            }
        
            $originalWidth = imagesx($barcodeImage);
            $originalHeight = imagesy($barcodeImage);
        
            $desiredHeight = 100;
            $resizedBarcode = imagecreatetruecolor($originalWidth, $desiredHeight);
            imagefill($resizedBarcode, 0, 0, imagecolorallocate($resizedBarcode, 255, 255, 255)); 
            imagecopyresampled($resizedBarcode, $barcodeImage, 0, 0, 0, 0, $originalWidth, $desiredHeight, $originalWidth, $originalHeight);
        
            $padding = 20;
            $textHeight = 15;
            $finalWidth = $originalWidth + $padding * 2;
            $finalHeight = $desiredHeight + $padding * 2 + $textHeight;
        
            $finalImage = imagecreatetruecolor($finalWidth, $finalHeight);
            $white = imagecolorallocate($finalImage, 255, 255, 255);
            imagefill($finalImage, 0, 0, $white);
        
            imagecopy($finalImage, $resizedBarcode, $padding, $padding, 0, 0, $originalWidth, $desiredHeight);
        
            $fontSize = 5;
            $textColor = imagecolorallocate($finalImage, 0, 0, 0);
            $textWidth = imagefontwidth($fontSize) * strlen($kode);
            $textX = ($finalWidth - $textWidth) / 2;
            $textY = $desiredHeight + $padding + 5;
            imagestring($finalImage, $fontSize, $textX, $textY, $kode, $textColor);
        
            ob_start();
            imagepng($finalImage);
            $imageData = ob_get_clean();
        
            imagedestroy($barcodeImage);
            imagedestroy($resizedBarcode);
            imagedestroy($finalImage);
        
            return Response::make($imageData, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="barcode-'.$kode.'.png"',
            ]);
        });
    }
}