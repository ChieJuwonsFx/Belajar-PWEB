<div id="product-detail-{{ $product->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" 
         onclick="closeModal('product-detail-{{ $product->id }}')"></div>

    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">{{ $product->name }}</h2>
                    <p class="text-primary-100">{{ $product->category->name }}</p>
                </div>
                <button type="button" 
                        class="text-white hover:text-primary-100 transition-colors"
                        onclick="closeModal('product-detail-{{ $product->id }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <div class="mb-6 relative">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach (json_decode($product->image, true) as $index => $img)
                        <div class="relative group">
                            <img src="{{ $img }}" 
                                class="w-full h-48 md:h-56 object-cover rounded-lg shadow-md transition-transform group-hover:scale-105"
                                alt="Product Image {{ $index + 1 }}">
                            <div class="absolute bottom-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded-full">
                                {{ $index + 1 }}/{{ count(json_decode($product->image, true)) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Detail Produk</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="w-32 font-medium text-gray-500">Deskripsi</div>
                            <div class="flex-1 text-gray-800">{{ $product->deskripsi }}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-32 font-medium text-gray-500">Kategori</div>
                            <div class="flex-1 text-gray-800">{{ $product->category->name }}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-32 font-medium text-gray-500">Status</div>
                            <div class="flex-1">
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $product->is_available == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_available }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <div class="w-32 font-medium text-gray-500">Stok Tersedia</div>
                            <div class="flex-1 text-gray-800">{{ $product->total_stok }} {{ $product->unit->name }}</div>
                        </div>   
                        <div class="flex items-center">
                            <div class="w-32 font-medium text-gray-500">Stok Minimum</div>
                            <div class="flex-1 text-gray-800">{{ $product->stok_minimum }} {{ $product->unit->name }}</div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-32 font-medium text-gray-500">Harga Jual</div>
                            <div class="flex-1 font-semibold text-primary">
                                Rp{{ number_format($product->harga_jual, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('owner.produk.editProduk', ['product' => $product])
            
            <div class="bg-gray-50 px-6 py-4 border-t flex justify-end space-x-3">
                <button type="button"
                        onclick="event.stopPropagation(); closeModal('product-detail-{{ $product->id }}'); openModal('edit-product-{{ $product->id }}')"
                        class="px-5 py-2.5 bg-white border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <i class="fas fa-edit mr-2"></i> Edit Produk
                </button>
                <button type="button"
                        onclick="event.stopPropagation(); closeModal('product-detail-{{ $product->id }}'); openModal('delete-product-{{ $product->id }}')"
                        class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-300">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus Produk
                </button>
            </div>
        </div>
    </div>
</div>