<?php

namespace App\Http\Controllers\Owner;

use DB;
use App\Models\Unit;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ownerProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cache = 'products.' . md5(json_encode($request->all()));
            $cacheDurasi = now()->addMinutes(30);

            if (Cache::has($cache)) {
                $data = Cache::get($cache);
            } else {
                $categories = Category::select(['id', 'name'])->get();
                $units = Unit::select(['id', 'name'])->get();
                
                $query = Product::with(['category:id,name', 'unit:id,name'])
                    ->where('is_active', true)
                    ->select([
                        'id', 'name', 'barcode', 'harga_jual', 'stok_minimum', 
                        'image', 'is_available', 'category_id', 'unit_id'
                    ]);
                
                $query->leftJoin(\DB::raw('(SELECT 
                        product_id, 
                        SUM(remaining_quantity) as total_stock 
                    FROM stocks 
                    WHERE remaining_quantity > 0 
                    GROUP BY product_id) as stock_summary'), 
                    'products.id', '=', 'stock_summary.product_id')
                    ->select('products.*', \DB::raw('COALESCE(stock_summary.total_stock, 0) as stok'));

                if ($request->filled('search')) {
                    $search = $request->search;
                    $query->where(function($q) use ($search) {
                        $q->where('products.name', 'like', "%{$search}%")
                          ->orWhereHas('category', function($q) use ($search) {
                              $q->where('name', 'like', "%{$search}%");
                          });
                    });
                }
                
                if ($request->filled('category')) {
                    $query->where('category_id', $request->category);
                }
              
                $products = $query->orderBy('is_available')->paginate(16);
                
                $data = compact('products', 'categories', 'units');
                
                Cache::put($cache, $data, $cacheDurasi);
            }
            
            foreach ($data['products'] as $product) {
                $product->barcode_url = $this->getBarcodeUrl($product->id);
            }

            return view('owner.produk.produk', $data);
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')
                ->with('alert_failed', 'Terjadi kesalahan saat melakukan load data produk: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_jual' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'stok' => 'nullable|integer|min:0',
            'images_json' => 'nullable|json',
            'is_available' => 'required|boolean',
            'is_stock_real' => 'required|boolean',
            'is_modal_real' => 'required|boolean',
            'harga_modal' => 'nullable|numeric|min:0',
            'category' => 'required|exists:categories,id',
            'unit' => 'required|exists:units,id',
        ], [
            'name.required' => 'Nama produk harus diisi.',
            'name.string' => 'Nama produk harus berupa teks.',
            'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
            'barcode.string' => 'Barcode produk harus berupa teks.',
            'barcode.max' => 'Barcode produk tidak boleh lebih dari 255 karakter.',
            'deskripsi.string' => 'Deskripsi produk harus berupa teks.',
            'harga_jual.required' => 'Harga jual produk harus diisi.',
            'harga_jual.numeric' => 'Harga jual produk harus berupa angka.',
            'harga_jual.min' => 'Harga jual produk harus lebih besar atau sama dengan 0.',
            'stok_minimum.required' => 'Stok minimum produk harus diisi.',
            'stok_minimum.integer' => 'Stok minimum produk harus berupa angka.',
            'stok_minimum.min' => 'Stok minimum produk harus lebih besar atau sama dengan 0.',
            'stok.integer' => 'Stok produk harus berupa angka.',
            'stok.min' => 'Stok produk harus lebih besar atau sama dengan 0.',
            'images_json.json' => 'Format gambar tidak valid.',
            'is_available.required' => 'Status ketersediaan produk harus diisi.',
            'is_available.boolean' => 'Status ketersediaan produk harus berupa boolean.',
            'is_stock_real.required' => 'Status stok nyata harus diisi.',
            'is_stock_real.boolean' => 'Status stok nyata harus berupa boolean.',
            'is_modal_real.required' => 'Status modal nyata harus diisi.',
            'is_modal_real.boolean' => 'Status modal nyata harus berupa boolean.',
            'harga_modal.numeric' => 'Harga modal produk harus berupa angka.',
            'harga_modal.min' => 'Harga modal produk harus lebih besar atau sama dengan 0.',
            'category.required' => 'Kategori produk harus dipilih.',
            'category.exists' => 'Kategori produk yang dipilih tidak valid.',
            'unit.required' => 'Satuan produk harus dipilih.',
            'unit.exists' => 'Satuan produk yang dipilih tidak valid.',
        ]);
    
        if ($request->ajax()) {
            return response()->json([
                'valid' => !$validator->fails(),
                'errors' => $validator->errors(),
                'success' => !$validator->fails() ? true : false
            ]);
        }
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            $validated = $validator->validated();
            
            $isStockReal = filter_var($validated['is_stock_real'], FILTER_VALIDATE_BOOLEAN);
            $isModalReal = filter_var($validated['is_modal_real'], FILTER_VALIDATE_BOOLEAN);
    
            DB::beginTransaction();
    
            $product = Product::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'barcode' => $validated['barcode'],
                'deskripsi' => $validated['deskripsi'],
                'harga_jual' => $validated['harga_jual'],
                'stok_minimum' => $validated['stok_minimum'],
                'stok' => $isStockReal && !$isModalReal ? $validated['stok'] : 0,
                'image' => $validated['images_json'] ?? '[]',
                'is_available' => $validated['is_available'],
                'is_active' => true,
                'is_stock_real' => $validated['is_stock_real'],
                'is_modal_real' => $validated['is_modal_real'],
                'estimasi_modal' => $isModalReal ? 1 : $validated['harga_modal'],
                'category_id' => $validated['category'],
                'unit_id' => $validated['unit'],
            ]);
            
            if ($isStockReal && $isModalReal && isset($validated['stok'])) {
                Stock::create([
                    'quantity' => $validated['stok'],
                    'remaining_quantity' => $validated['stok'],
                    'harga_modal' => $validated['harga_modal'],
                    'product_id' => $product->id
                ]);
            }
    
            DB::commit();
            
            Cache::tags(['products'])->flush();
            
            return redirect()->route('owner.produk')
                ->with('alert_success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
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

    private function getBarcodeUrl($productId)
    {
        $storagePath = 'barcodes/' . $productId . '.svg';
        
        if (!Storage::exists($storagePath)) {
            $barcode = new DNS1D();
            $barcode->setStorPath(storage_path('framework/barcodes/'));
            $barcodeData = $barcode->getBarcodeSVG($productId, 'C128', 1.5, 40);
            
            Storage::put($storagePath, $barcodeData);
        }
        
        return Storage::url($storagePath);
    }

    public function showBarcode($id)
    {
        try {
            $storagePath = 'barcodes/' . $id . '.svg';
            
            if (!Storage::exists($storagePath)) {
                $barcode = new DNS1D();
                $barcode->setStorPath(storage_path('framework/barcodes/'));
                $barcodeData = $barcode->getBarcodeSVG($id, 'C128', 1.5, 40);
                
                Storage::put($storagePath, $barcodeData);
            }
            
            return response(Storage::get($storagePath), 200)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Cache-Control', 'public, max-age=604800'); 
        } catch (\Exception $e) {
            return response('Error generating barcode', 500);
        }
    }

    public function downloadBarcode($kode)
    {
        try {
            $pngPath = 'barcodes/png/' . $kode . '.png';
            
            if (!Storage::exists($pngPath)) {
                $barcode = new DNS1D();
                $barcode->setStorPath(storage_path('framework/barcodes/'));
                $pngBase64 = $barcode->getBarcodePNG($kode, 'C128');
                $barcodeData = base64_decode($pngBase64);
                
                $barcodeImage = imagecreatefromstring($barcodeData);
                
                $finalImage = $this->formatBarcodeImage($barcodeImage, $kode);
                
                ob_start();
                imagepng($finalImage);
                $imageData = ob_get_clean();
                
                Storage::put($pngPath, $imageData);
                
                imagedestroy($barcodeImage);
                imagedestroy($finalImage);
            }
            
            return response(Storage::get($pngPath), 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="barcode-'.$kode.'.png"',
                'Cache-Control' => 'public, max-age=604800'
            ]);
        } catch (\Exception $e) {
            return response('Error generating barcode', 500);
        }
    }
    
    private function formatBarcodeImage($barcodeImage, $kode)
    {
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
        
        imagedestroy($resizedBarcode);
        
        return $finalImage;
    }
}