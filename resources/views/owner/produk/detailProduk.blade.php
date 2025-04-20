<div id="product-detail-{{ $product->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" 
         onclick="closeModal('product-detail-{{ $product->id }}')"></div>

    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center">
                        <div class="mr-4 bg-white/20 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ $product->name }}</h2>
                            <div class="flex items-center mt-1">
                                <span class="text-blue-100">{{ $product->category->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" 
                        class="text-white hover:text-blue-200 transition-colors"
                        onclick="closeModal('product-detail-{{ $product->id }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach (json_decode($product->image, true) as $index => $img)
                        <div class="relative group overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                            <div class="aspect-[4/3] w-full overflow-hidden">
                                <img src="{{ $img }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    alt="Product Image {{ $index + 1 }}">
                            </div>
                            <div class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                                {{ $index + 1 }}/{{ count(json_decode($product->image, true)) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-6 mb-6 border border-gray-100 shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 p-2 rounded-lg mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Detail Produk</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-40 flex-shrink-0 text-sm font-medium text-gray-500 flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            Deskripsi
                        </div>
                        <div class="flex-1 text-gray-700">{{ $product->deskripsi }}</div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start">
                            <div class="w-40 flex-shrink-0 text-sm font-medium text-gray-500 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Kategori
                            </div>
                            <div class="flex-1 text-gray-700">{{ $product->category->name }}</div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-40 flex-shrink-0 text-sm font-medium text-gray-500 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Status
                            </div>
                            <div class="flex-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $product->is_available == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_available }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-40 flex-shrink-0 text-sm font-medium text-gray-500 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Stok Tersedia
                            </div>
                            <div class="flex-1 text-gray-700">{{ $product->stok }} {{ $product->unit->name }}</div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-40 flex-shrink-0 text-sm font-medium text-gray-500 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                                Stok Minimum
                            </div>
                            <div class="flex-1 text-gray-700">{{ $product->stok_minimum }} {{ $product->unit->name }}</div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-40 flex-shrink-0 text-sm font-medium text-gray-500 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Harga Jual
                            </div>
                            <div class="flex-1 font-semibold text-primary">
                                Rp{{ number_format($product->harga_jual, 0, ',', '.') }}
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-40 flex-shrink-0 text-sm font-medium text-gray-500 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Harga Modal
                            </div>
                            <div class="flex-1 font-semibold text-primary">
                                @if ($product->status_harga_modal)
                                    Rp{{ number_format($product->stocks()->latest()->first()->harga_modal ?? 0, 0, ',', '.') }}
                                @else
                                    Rp{{ number_format($product->estimasi_modal, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-40 flex-shrink-0 text-sm font-medium text-gray-500 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Status Stok
                            </div>
                            <div class="flex-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $product->is_stock_real ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $product->is_stock_real ? 'Sudah real' : 'Estimasi' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-40 flex-shrink-0 text-sm font-medium text-gray-500 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Status Modal
                            </div>
                            <div class="flex-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $product->is_modal_real ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $product->is_modal_real ? 'Sudah real' : 'Estimasi' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:w-[500px] grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 gap-4 mb-4 ">
                <button type="button"
                    onclick="openModal('restok-produk-{{ $product->id }}')"
                    class="px-4 py-2 bg-white text-primary border border-primary flex items-center hover:text-white hover:bg-primary rounded-lg whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Restok Produk
                </button>
                <button type="button"
                        onclick="openModal('edit-produk-{{ $product->id }}')"
                        class="px-4 py-2.5 bg-primary text-white border border-primary hover:bg-white hover:text-primary rounded-lg transition-all flex items-center shadow-sm hover:shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    <i class="fas fa-edit mr-2"></i> Edit Produk
                </button>
                <button onclick="openModal('delete-konfirmasi-{{ $product->id }}')" 
                        class="px-4 py-2 bg-danger text-white border border-danger flex items-center hover:text-danger hover:bg-white rounded-lg whitespace-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    Hapus Produk
                </button>
                <x-danger-modal
                    id="delete-konfirmasi-{{ $product->id }}"
                    title="Peringatan!"
                    message="Apakah kamu yakin ingin menghapus produk :name ini? Tindakan ini tidak dapat dibatalkan."
                    :route="route('owner.produk.delete', $product->id)"
                    name="{{ $product->name }}"
                    buttonText="Ya, Hapus"
                    cancelText="Batal"
                />
            </div>

            
            @include('owner.produk.restokProduk', ['product' => $product])
            @include('owner.produk.editProduk', ['product' => $product])
        </div>
    </div>
</div>