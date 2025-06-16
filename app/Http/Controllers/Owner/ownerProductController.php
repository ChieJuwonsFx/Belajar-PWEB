<?php

namespace App\Http\Controllers\Owner;

use App\Models\Unit;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ownerProductController extends Controller
{
    public function index(Request $request)
    {
        try {

            $categories = Category::select(['id', 'name'])->get();
            $units = Unit::select(['id', 'name'])->get();

            $query = Product::with(['category:id,name', 'unit:id,name'])
                ->where('is_active', true)
                ->leftJoin(
                    DB::raw('(
                                SELECT 
                                    product_id, 
                                    SUM(remaining_quantity) AS total_stock 
                                FROM stocks 
                                WHERE remaining_quantity > 0 
                                GROUP BY product_id
                            ) AS stock_summary'),
                    'products.id',
                    '=',
                    'stock_summary.product_id'
                )
                ->select('products.*', DB::raw('COALESCE(stock_summary.total_stock, 0) AS stok'));

            // if ($request->filled('search')) {
            //     $search = $request->search;
            //     $query->where(function ($q) use ($search) {
            //         $q->where('products.name', 'like', "%{$search}%")
            //             ->orWhereHas('category', function ($q) use ($search) {
            //                 $q->where('name', 'like', "%{$search}%");
            //             });
            //     });
            // }

            // if ($request->filled('category')) {
            //     $query->where('category_id', $request->category);
            // }
            if ($request->has('category') && $request->category != '') {
                $query->where('category_id', $request->category);

                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    });
                }
            }

            $products = $query->orderBy('is_available')->paginate(16);

            $data = compact('products', 'categories', 'units');

            return view('owner.produk.produk', $data);
        } catch (\Exception $e) {
            return redirect()->route('owner.produk')
                ->with('alert_failed', 'Terjadi kesalahan saat memuat data produk: ' . $e->getMessage());
        }
    }

    // try{
    //         $categories = Category::all();
    
    //         $query = Product::with('category', 'unit')
    //             ->withSum('stocks as stok', 'remaining_quantity')
    //             ->where([['is_active', true], ['is_available', 'Available']]);
    
    //         if ($request->has('category') && $request->category != '') {
    //             $query->where('category_id', $request->category);

    //             if ($request->has('search') && $request->search != '') {
    //                 $search = $request->search;
    //                 $query->where(function ($q) use ($search) {
    //                     $q->where('name', 'like', "%$search%");
    //                 });
    //             }
    //         }
    //         $products = $query->orderBy('is_available', 'asc')->get();
    
    //         return view('kasir.transaksi', compact('products', 'categories'));    
    //     } catch (\Exception $e) {
    //         return redirect()->route('kasir.transaksi')->with('alert_failed', 'Terjadi kesalahan saat melakukan load data produk: ' . $e->getMessage());
    //     }

    // public function store(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'name' => 'required|string|max:255',
    //             'barcode' => 'nullable|string|max:255',
    //             'deskripsi' => 'required|string',
    //             'harga_jual' => 'required|numeric|min:0',
    //             'harga_modal' => 'nullable|numeric|min:0',
    //             'stok' => 'nullable|integer|min:0',
    //             'stok_minimum' => 'required|integer|min:0',
    //             'is_available' => 'required|in:Available,Unavailable',
    //             'is_stock_real' => 'required|in:true,false',
    //             'is_modal_real' => 'required|in:true,false',
    //             'category' => 'required|exists:categories,id',
    //             'unit' => 'required|exists:units,id',
    //             'images_json' => 'nullable|json',
    //         ]);

    //         $isStockReal = filter_var($validated['is_stock_real'], FILTER_VALIDATE_BOOLEAN);
    //         $isModalReal = filter_var($validated['is_modal_real'], FILTER_VALIDATE_BOOLEAN);

    //         $stokValue = $isStockReal ? ($validated['stok'] ?? 0) : 0;
    //         $hargaModalValue = $validated['harga_modal'] ?? 0;

    //         $finalImageData = [];

    //         if (!empty($validated['images_json'])) {
    //             $images = json_decode($validated['images_json'], true) ?? [];

    //             foreach ($images as $base64Image) {
    //                 if (strpos($base64Image, 'data:image/') === 0) {
    //                     $imageDataParts = explode(',', $base64Image);
    //                     if (count($imageDataParts) === 2) {
    //                         $imageData64 = $imageDataParts[1];
    //                         $mimeTypePart = $imageDataParts[0];

    //                         preg_match('/data:image\/([a-zA-Z]+);/', $mimeTypePart, $matches);
    //                         $imageType = $matches[1] ?? 'jpg';

    //                         $decodedImage = base64_decode($imageData64);

    //                         if ($decodedImage !== false) {
    //                             $filename = uniqid() . '_' . time() . '.' . $imageType;
    //                             $filePath = 'product/' . $filename;

    //                             Storage::disk('public')->put($filePath, $decodedImage);

    //                             $finalImageData[] = [
    //                                 'path' => 'storage/' . $filePath,
    //                                 'filename' => $filename
    //                             ];
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         if ($isStockReal && $isModalReal) {
    //             $product = Product::create([
    //                 'name' => $validated['name'],
    //                 'slug' => Str::slug($validated['name']),
    //                 'barcode' => $validated['barcode'],
    //                 'deskripsi' => $validated['deskripsi'],
    //                 'harga_jual' => $validated['harga_jual'],
    //                 'stok_minimum' => $validated['stok_minimum'],
    //                 'stok' => 0,
    //                 'image' => !empty($finalImageData) ? json_encode(array_values($finalImageData)) : null,
    //                 'is_available' => $validated['is_available'],
    //                 'is_active' => true,
    //                 'is_stock_real' => $isStockReal,
    //                 'is_modal_real' => $isModalReal,
    //                 'estimasi_modal' => $hargaModalValue,
    //                 'category_id' => $validated['category'],
    //                 'unit_id' => $validated['unit'],
    //             ]);

    //             if ($stokValue > 0) {
    //                 Stock::create([
    //                     'quantity' => $stokValue,
    //                     'remaining_quantity' => $stokValue,
    //                     'harga_modal' => $hargaModalValue,
    //                     'product_id' => $product->id
    //                 ]);

    //                 $product->update(['stok' => $stokValue]);
    //             }
    //         } elseif ($isStockReal && !$isModalReal) {
    //             $product = Product::create([
    //                 'name' => $validated['name'],
    //                 'slug' => Str::slug($validated['name']),
    //                 'barcode' => $validated['barcode'],
    //                 'deskripsi' => $validated['deskripsi'],
    //                 'harga_jual' => $validated['harga_jual'],
    //                 'stok_minimum' => $validated['stok_minimum'],
    //                 'stok' => $stokValue,
    //                 'image' => !empty($finalImageData) ? json_encode(array_values($finalImageData)) : null,
    //                 'is_available' => $validated['is_available'],
    //                 'is_active' => true,
    //                 'is_stock_real' => $isStockReal,
    //                 'is_modal_real' => $isModalReal,
    //                 'estimasi_modal' => $hargaModalValue,
    //                 'category_id' => $validated['category'],
    //                 'unit_id' => $validated['unit'],
    //             ]);
    //         } else {
    //             $product = Product::create([
    //                 'name' => $validated['name'],
    //                 'slug' => Str::slug($validated['name']),
    //                 'barcode' => $validated['barcode'],
    //                 'deskripsi' => $validated['deskripsi'],
    //                 'harga_jual' => $validated['harga_jual'],
    //                 'stok' => 0,
    //                 'stok_minimum' => $validated['stok_minimum'],
    //                 'image' => !empty($finalImageData) ? json_encode(array_values($finalImageData)) : null,
    //                 'is_available' => $validated['is_available'],
    //                 'is_active' => true,
    //                 'is_stock_real' => $isStockReal,
    //                 'is_modal_real' => $isModalReal,
    //                 'estimasi_modal' => $hargaModalValue,
    //                 'category_id' => $validated['category'],
    //                 'unit_id' => $validated['unit'],
    //             ]);
    //         }

    //         return redirect()->route('owner.produk')
    //             ->with('alert_success', 'Produk berhasil ditambahkan');
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return redirect()->back()
    //             ->withInput()
    //             ->withErrors($e->validator);
    //     } catch (\Exception $e) {
    //         return redirect()->back()
    //             ->withInput()
    //             ->with('alert_failed', 'Terjadi kesalahan saat menambahkan produk: ' . $e->getMessage());
    //     }
    // }

    public function update(Request $request, $id)
    {
        try {
            $produk = Product::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'barcode' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'harga_jual' => 'required|numeric|min:0',
                'stok_minimum' => 'required|integer|min:0',
                'is_available' => 'required|in:Available,Unavailable',
                'category' => 'required|exists:categories,id',
                'unit' => 'required|exists:units,id',
                'image_data' => 'nullable|json',
            ]);

            $imageData = json_decode($request->input('image_data'), true);

            if (!is_array($imageData)) {
                $imageData = ['existing' => [], 'new' => [], 'deleted' => []];
            } else {
                $imageData['existing'] = $imageData['existing'] ?? [];
                $imageData['new'] = $imageData['new'] ?? [];
                $imageData['deleted'] = $imageData['deleted'] ?? [];
            }

            $finalImageData = [];

            foreach ($imageData['existing'] as $existingImg) {
                $imageId = $existingImg['id'] ?? null;

                if (!in_array($imageId, $imageData['deleted'])) {
                    $finalImageData[] = [
                        'path' => $existingImg['path'],
                        'filename' => $existingImg['filename'] ?? 'existing_image_' . $imageId . '.jpg'
                    ];
                }
            }

            foreach ($imageData['new'] as $newImg) {
                if (isset($newImg['path']) && strpos($newImg['path'], 'data:image/') === 0) {
                    $imageBase64 = $newImg['path'];
                    $imageData64 = explode(',', $imageBase64)[1];
                    $imageType = explode(';', explode('/', $imageBase64)[1])[0];

                    $filename = uniqid() . '_' . time() . '.' . $imageType;
                    $filePath = 'product/' . $filename;

                    $decodedImage = base64_decode($imageData64);

                    Storage::disk('public')->put($filePath, $decodedImage);

                    $finalImageData[] = [
                        'path' => 'storage/' . $filePath,
                        'filename' => $newImg['filename'] ?? $filename
                    ];
                }
            }

            if (!empty($imageData['deleted']) && !empty($produk->image)) {
                $currentImages = json_decode($produk->image, true);
                if (is_array($currentImages)) {
                    foreach ($currentImages as $index => $currentImg) {
                        if (in_array($index, $imageData['deleted'])) {
                            if (isset($currentImg['path']) && strpos($currentImg['path'], 'storage/') === 0) {
                                $filePath = str_replace('storage/', '', $currentImg['path']);
                                if (Storage::disk('public')->exists($filePath)) {
                                    Storage::disk('public')->delete($filePath);
                                }
                            }
                        }
                    }
                }
            }

            $produk->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'barcode' => $validated['barcode'],
                'deskripsi' => $validated['deskripsi'],
                'harga_jual' => $validated['harga_jual'],
                'stok_minimum' => $validated['stok_minimum'],
                'image' => !empty($finalImageData) ? json_encode(array_values($finalImageData)) : null,
                'is_available' => $validated['is_available'],
                'category_id' => $validated['category'],
                'unit_id' => $validated['unit'],
            ]);

            return redirect()->route('owner.produk')
                ->with('success', 'Produk berhasil diperbaharui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('alert_failed', 'Terjadi kesalahan saat memperbaharui produk: ' . $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            $messages = [
                'name.required' => 'Nama produk wajib diisi.',
                'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
                'barcode.max' => 'Barcode tidak boleh lebih dari 255 karakter.',
                'deskripsi.required' => 'Deskripsi produk wajib diisi.',
                'harga_jual.required' => 'Harga jual wajib diisi.',
                'harga_jual.numeric' => 'Harga jual harus berupa angka.',
                'harga_jual.min' => 'Harga jual tidak boleh kurang dari 0.',
                'harga_modal.numeric' => 'Harga modal harus berupa angka.',
                'harga_modal.min' => 'Harga modal tidak boleh kurang dari 0.',
                'stok.integer' => 'Stok harus berupa bilangan bulat.',
                'stok.min' => 'Stok tidak boleh kurang dari 0.',
                'stok_minimum.required' => 'Stok minimum wajib diisi.',
                'stok_minimum.integer' => 'Stok minimum harus berupa bilangan bulat.',
                'stok_minimum.min' => 'Stok minimum tidak boleh kurang dari 0.',
                'is_available.required' => 'Status ketersediaan wajib dipilih.',
                'is_available.in' => 'Status ketersediaan tidak valid.',
                'is_stock_real.required' => 'Status stok real wajib dipilih.',
                'is_stock_real.in' => 'Status stok real tidak valid.',
                'is_modal_real.required' => 'Status modal real wajib dipilih.',
                'is_modal_real.in' => 'Status modal real tidak valid.',
                'category.required' => 'Kategori wajib dipilih.',
                'category.exists' => 'Kategori yang dipilih tidak valid.',
                'unit.required' => 'Satuan wajib dipilih.',
                'unit.exists' => 'Satuan yang dipilih tidak valid.',
                'images_json.json' => 'Format gambar tidak valid.',
            ];

            $rules = [
                'name' => 'required|string|max:255',
                'barcode' => 'nullable|string|max:255',
                'deskripsi' => 'required|string',
                'harga_jual' => 'required|numeric|min:0',
                'harga_modal' => 'nullable|numeric|min:0',
                'stok' => 'nullable|integer|min:0',
                'stok_minimum' => 'required|integer|min:0',
                'is_available' => 'required|in:Available,Unavailable',
                'is_stock_real' => 'required|in:true,false',
                'is_modal_real' => 'required|in:true,false',
                'category' => 'required|exists:categories,id',
                'unit' => 'required|exists:units,id',
                'images_json' => 'nullable|json',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            $validator->sometimes('harga_modal', 'required|numeric|min:0', function ($input) {
                return filter_var($input->is_modal_real, FILTER_VALIDATE_BOOLEAN);
            });

            $validator->after(function ($validator) use ($request) {
                $isModalReal = filter_var($request->is_modal_real, FILTER_VALIDATE_BOOLEAN);
                $hargaModal = $request->harga_modal;
                $hargaJual = $request->harga_jual;

                if ($isModalReal && $hargaModal !== null && $hargaJual < $hargaModal) {
                    $validator->errors()->add('harga_jual', 'Harga jual tidak boleh lebih murah dari harga modal.');
                }
            });

            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            $validated = $validator->validated();

            $isStockReal = filter_var($validated['is_stock_real'], FILTER_VALIDATE_BOOLEAN);
            $isModalReal = filter_var($validated['is_modal_real'], FILTER_VALIDATE_BOOLEAN);

            $stokValue = $isStockReal ? ($validated['stok'] ?? 0) : 0;
            $hargaModalValue = $validated['harga_modal'] ?? 0;

            $finalImageData = [];

            if (!empty($validated['images_json'])) {
                $images = json_decode($validated['images_json'], true) ?? [];

                foreach ($images as $base64Image) {
                    if (strpos($base64Image, 'data:image/') === 0) {
                        $imageDataParts = explode(',', $base64Image);
                        if (count($imageDataParts) === 2) {
                            $imageData64 = $imageDataParts[1];
                            $mimeTypePart = $imageDataParts[0];

                            preg_match('/data:image\/([a-zA-Z]+);/', $mimeTypePart, $matches);
                            $imageType = $matches[1] ?? 'jpg';

                            $decodedImage = base64_decode($imageData64);

                            if ($decodedImage !== false) {
                                $filename = uniqid() . '_' . time() . '.' . $imageType;
                                $filePath = 'product/' . $filename;

                                Storage::disk('public')->put($filePath, $decodedImage);

                                $finalImageData[] = [
                                    'path' => 'storage/' . $filePath,
                                    'filename' => $filename
                                ];
                            }
                        }
                    }
                }
            }

            if ($isStockReal && $isModalReal) {
                $product = Product::create([
                    'name' => $validated['name'],
                    'slug' => Str::slug($validated['name']),
                    'barcode' => $validated['barcode'],
                    'deskripsi' => $validated['deskripsi'],
                    'harga_jual' => $validated['harga_jual'],
                    'stok_minimum' => $validated['stok_minimum'],
                    'stok' => 0,
                    'image' => !empty($finalImageData) ? json_encode(array_values($finalImageData)) : null,
                    'is_available' => $validated['is_available'],
                    'is_active' => true,
                    'is_stock_real' => $isStockReal,
                    'is_modal_real' => $isModalReal,
                    'estimasi_modal' => $hargaModalValue,
                    'category_id' => $validated['category'],
                    'unit_id' => $validated['unit'],
                ]);

                if ($stokValue > 0) {
                    Stock::create([
                        'quantity' => $stokValue,
                        'remaining_quantity' => $stokValue,
                        'harga_modal' => $hargaModalValue,
                        'product_id' => $product->id
                    ]);

                    $product->update(['stok' => $stokValue]);
                }
            } elseif ($isStockReal && !$isModalReal) {
                $product = Product::create([
                    'name' => $validated['name'],
                    'slug' => Str::slug($validated['name']),
                    'barcode' => $validated['barcode'],
                    'deskripsi' => $validated['deskripsi'],
                    'harga_jual' => $validated['harga_jual'],
                    'stok_minimum' => $validated['stok_minimum'],
                    'stok' => $stokValue,
                    'image' => !empty($finalImageData) ? json_encode(array_values($finalImageData)) : null,
                    'is_available' => $validated['is_available'],
                    'is_active' => true,
                    'is_stock_real' => $isStockReal,
                    'is_modal_real' => $isModalReal,
                    'estimasi_modal' => $hargaModalValue,
                    'category_id' => $validated['category'],
                    'unit_id' => $validated['unit'],
                ]);
            } else {
                $product = Product::create([
                    'name' => $validated['name'],
                    'slug' => Str::slug($validated['name']),
                    'barcode' => $validated['barcode'],
                    'deskripsi' => $validated['deskripsi'],
                    'harga_jual' => $validated['harga_jual'],
                    'stok' => 0,
                    'stok_minimum' => $validated['stok_minimum'],
                    'image' => !empty($finalImageData) ? json_encode(array_values($finalImageData)) : null,
                    'is_available' => $validated['is_available'],
                    'is_active' => true,
                    'is_stock_real' => $isStockReal,
                    'is_modal_real' => $isModalReal,
                    'estimasi_modal' => $hargaModalValue,
                    'category_id' => $validated['category'],
                    'unit_id' => $validated['unit'],
                ]);
            }

            return redirect()->route('owner.produk')
                ->with('alert_success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('alert_failed', 'Terjadi kesalahan saat menambahkan produk: ' . $e->getMessage());
        }
    }

    // public function update(Request $request, $id)
    // {
    //     try {
    //         $produk = Product::findOrFail($id);

    //         $messages = [
    //             'name.required' => 'Nama produk wajib diisi.',
    //             'name.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
    //             'barcode.max' => 'Barcode tidak boleh lebih dari 255 karakter.',
    //             'harga_jual.required' => 'Harga jual wajib diisi.',
    //             'harga_jual.numeric' => 'Harga jual harus berupa angka.',
    //             'harga_jual.min' => 'Harga jual tidak boleh kurang dari 0.',
    //             'stok_minimum.required' => 'Stok minimum wajib diisi.',
    //             'stok_minimum.integer' => 'Stok minimum harus berupa bilangan bulat.',
    //             'stok_minimum.min' => 'Stok minimum tidak boleh kurang dari 0.',
    //             'is_available.required' => 'Status ketersediaan wajib dipilih.',
    //             'is_available.in' => 'Status ketersediaan tidak valid.',
    //             'category.required' => 'Kategori wajib dipilih.',
    //             'category.exists' => 'Kategori yang dipilih tidak valid.',
    //             'unit.required' => 'Satuan wajib dipilih.',
    //             'unit.exists' => 'Satuan yang dipilih tidak valid.',
    //             'image_data.json' => 'Format gambar tidak valid.',
    //         ];

    //         $rules = [
    //             'name' => 'required|string|max:255',
    //             'barcode' => 'nullable|string|max:255',
    //             'deskripsi' => 'nullable|string',
    //             'harga_jual' => 'required|numeric|min:0',
    //             'stok_minimum' => 'required|integer|min:0',
    //             'is_available' => 'required|in:Available,Unavailable',
    //             'category' => 'required|exists:categories,id',
    //             'unit' => 'required|exists:units,id',
    //             'image_data' => 'nullable|json',
    //         ];

    //         $validator = Validator::make($request->all(), $rules, $messages);

    //         $validator->after(function ($validator) use ($request, $produk) {
    //             $hargaJual = $request->harga_jual;

    //             if ($produk->is_modal_real && $produk->estimasi_modal !== null && $hargaJual < $produk->estimasi_modal) {
    //                 $validator->errors()->add('harga_jual', 'Harga jual tidak boleh lebih murah dari harga modal.');
    //             }
    //         });

    //         if ($validator->fails()) {
    //             return redirect()->back()
    //                 ->withInput()
    //                 ->withErrors($validator);
    //         }

    //         $validated = $validator->validated();

    //         $imageData = json_decode($request->input('image_data'), true);

    //         if (!is_array($imageData)) {
    //             $imageData = ['existing' => [], 'new' => [], 'deleted' => []];
    //         } else {
    //             $imageData['existing'] = $imageData['existing'] ?? [];
    //             $imageData['new'] = $imageData['new'] ?? [];
    //             $imageData['deleted'] = $imageData['deleted'] ?? [];
    //         }

    //         $finalImageData = [];

    //         foreach ($imageData['existing'] as $existingImg) {
    //             $imageId = $existingImg['id'] ?? null;

    //             if (!in_array($imageId, $imageData['deleted'])) {
    //                 $finalImageData[] = [
    //                     'path' => $existingImg['path'],
    //                     'filename' => $existingImg['filename'] ?? 'existing_image_' . $imageId . '.jpg'
    //                 ];
    //             }
    //         }

    //         foreach ($imageData['new'] as $newImg) {
    //             if (isset($newImg['path']) && strpos($newImg['path'], 'data:image/') === 0) {
    //                 $imageBase64 = $newImg['path'];
    //                 $imageData64 = explode(',', $imageBase64)[1];
    //                 $imageType = explode(';', explode('/', $imageBase64)[1])[0];

    //                 $filename = uniqid() . '_' . time() . '.' . $imageType;
    //                 $filePath = 'product/' . $filename;

    //                 $decodedImage = base64_decode($imageData64);

    //                 Storage::disk('public')->put($filePath, $decodedImage);

    //                 $finalImageData[] = [
    //                     'path' => 'storage/' . $filePath,
    //                     'filename' => $newImg['filename'] ?? $filename
    //                 ];
    //             }
    //         }

    //         if (!empty($imageData['deleted']) && !empty($produk->image)) {
    //             $currentImages = json_decode($produk->image, true);
    //             if (is_array($currentImages)) {
    //                 foreach ($currentImages as $index => $currentImg) {
    //                     if (in_array($index, $imageData['deleted'])) {
    //                         if (isset($currentImg['path']) && strpos($currentImg['path'], 'storage/') === 0) {
    //                             $filePath = str_replace('storage/', '', $currentImg['path']);
    //                             if (Storage::disk('public')->exists($filePath)) {
    //                                 Storage::disk('public')->delete($filePath);
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         $produk->update([
    //             'name' => $validated['name'],
    //             'slug' => Str::slug($validated['name']),
    //             'barcode' => $validated['barcode'],
    //             'deskripsi' => $validated['deskripsi'],
    //             'harga_jual' => $validated['harga_jual'],
    //             'stok_minimum' => $validated['stok_minimum'],
    //             'image' => !empty($finalImageData) ? json_encode(array_values($finalImageData)) : null,
    //             'is_available' => $validated['is_available'],
    //             'category_id' => $validated['category'],
    //             'unit_id' => $validated['unit'],
    //         ]);

    //         return redirect()->route('owner.produk')
    //             ->with('success', 'Produk berhasil diperbaharui');
    //     } catch (\Exception $e) {
    //         return redirect()->back()
    //             ->withInput()
    //             ->with('alert_failed', 'Terjadi kesalahan saat memperbaharui produk: ' . $e->getMessage());
    //     }
    // }


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

        return Cache::remember($cacheKey, now()->addWeek(), function () use ($kode) {
            $barcode = new DNS1D();
            $barcode->setStorPath(storage_path('framework/barcodes/'));

            return response($barcode->getBarcodeSVG($kode, 'C128', 1.5, 40), 200)
                ->header('Content-Type', 'image/svg+xml');
        });
    }


    public function downloadBarcode($kode)
    {
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
            'Content-Disposition' => 'attachment; filename="barcode-' . $kode . '.png"',
        ]);
    }
}
