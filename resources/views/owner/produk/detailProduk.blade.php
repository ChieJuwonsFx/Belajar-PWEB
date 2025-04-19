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
                            <div class="aspect-[4/3] w-full rounded-lg overflow-hidden shadow-md">
                                <img src="{{ $img }}"
                                    class="w-full h-full object-cover transition-transform group-hover:scale-105"
                                    alt="Product Image {{ $index + 1 }}">
                            </div>
                            <div class="absolute bottom-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded-full">
                                {{ $index + 1 }}/{{ count(json_decode($product->image, true)) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Detail Produk</h3>
            
                <div class="flex items-start text-sm mb-4">
                    <div class="w-36 font-medium text-gray-500">Deskripsi</div>
                    <div class="flex-1 text-gray-800">{{ $product->deskripsi }}</div>
                </div>
            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-start">
                        <div class="w-36 font-medium text-gray-500">Kategori</div>
                        <div class="flex-1 text-gray-800">{{ $product->category->name }}</div>
                    </div>
            
                    <div class="flex items-start">
                        <div class="w-36 font-medium text-gray-500">Status Ketersediaan</div>
                        <div class="flex-1">
                            <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $product->is_available == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_available }}
                            </div>
                        </div>
                    </div>
            
                    <div class="flex items-start">
                        <div class="w-36 font-medium text-gray-500">Stok Tersedia</div>
                        <div class="flex-1 text-gray-800">{{ $product->stok }} {{ $product->unit->name }}</div>
                    </div>
            
                    <div class="flex items-start">
                        <div class="w-36 font-medium text-gray-500">Stok Minimum</div>
                        <div class="flex-1 text-gray-800">{{ $product->stok_minimum }} {{ $product->unit->name }}</div>
                    </div>
            
                    <div class="flex items-start">
                        <div class="w-36 font-medium text-gray-500">Harga Jual</div>
                        <div class="flex-1 font-semibold text-primary">
                            Rp{{ number_format($product->harga_jual, 0, ',', '.') }}
                        </div>
                    </div>
            
                    <div class="flex items-start">
                        <div class="w-36 font-medium text-gray-500">Harga Modal</div>
                        <div class="flex-1 font-semibold text-primary">
                            @if ($product->status_harga_modal)
                                Rp{{ number_format($product->stocks()->latest()->first()->harga_modal ?? 0, 0, ',', '.') }}
                            @else
                            Rp{{ number_format($product->estimasi_modal, 0, ',', '.') }}
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-36 font-medium text-gray-500">Status Stok</div>
                        <div class="flex-1">
                            <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $product->is_stock_real ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $product->is_stock_real ? 'Sudah real' : 'Estimasi' }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-36 font-medium text-gray-500">Status Modal</div>
                        <div class="flex-1">
                            <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $product->is_modal_real ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $product->is_modal_real ? 'Sudah real' : 'Estimasi' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="md:w-[500px] grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 gap-4 mb-4 ">
                <button type="button"
                        onclick="openModal('restok-produk-{{ $product->id }}')"
                        class="px-4 py-2 bg-white text-primary border border-primary hover:text-white hover:bg-primary rounded-lg whitespace-nowrap">
                    <i class="fas fa-edit mr-2"></i> Restok Produk
                </button>
                <button type="button"
                        onclick="openModal('edit-produk-{{ $product->id }}')"
                        class="px-4 py-2 bg-primary text-white border border-primary hover:text-primary hover:bg-white rounded-lg whitespace-nowrap">
                    <i class="fas fa-edit mr-2"></i> Edit Produk
                </button>
                <button onclick="openModal('delete-konfirmasi-{{ $product->id }}')" 
                        class="px-4 py-2 bg-danger text-white border border-danger hover:text-danger hover:bg-white rounded-lg whitespace-nowrap">
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