@foreach ($products as $product)
    <div class="bg-white rounded-lg shadow-sm hover:shadow-md duration-300 overflow-hidden border border-gray-100 hover:border-blue-100 cursor-pointer product-card relative"
        data-id="{{ $product->id }}" data-barcode="{{ $product->barcode }}" data-name="{{ $product->name }}"
        data-price="{{ $product->harga_jual }}" data-cost="{{ $product->harga_modal }}"
        data-category="{{ $product->category->name }}" data-stock="{{ $product->stok }}"
        data-modal-real="{{ $product->is_modal_real }}">
        <!-- Isi product card sama seperti yang ada di transaksi.blade.php -->
        <div class="relative h-40 overflow-hidden">
            @php
                $images = is_string($product->image) ? json_decode($product->image, true) : $product->image;
            @endphp

            @if (is_array($images) && count($images) && isset($images[0]['path']))
                <img src="{{ $images[0]['path'] }}"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    alt="{{ $product->name }}" loading="lazy">
            @else
                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
            <div class="absolute top-2 right-2 flex items-center gap-1">
                <div
                    class="cart-indicator hidden bg-primary text-white rounded-full w-6 h-6 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="p-3">
            <div class="mb-1">
                <h3 class="text-base font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
            </div>

            <div class="flex flex-wrap justify-between items-center mt-2 gap-2">
                <div class="text-base font-bold text-primary">
                    Rp{{ number_format($product->harga_jual, 0, ',', '.') }}
                </div>
                <div class="flex items-center text-xs font-medium">
                    <span
                        class="py-1 px-3 rounded-lg font-semibold {{ $product->total_stok > $product->stok_minimum ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        Stok: {{ $product->stok }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endforeach

@if ($products->isEmpty())
    <div class="flex flex-col col-span-3 items-center justify-center py-12">
        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada produk ditemukan</h3>
        <p class="text-sm text-gray-500">Coba gunakan filter yang berbeda atau tambahkan produk baru</p>
    </div>
@endif