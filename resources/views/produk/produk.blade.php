<x-admin>
    <div class="p-6 w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition-all duration-300 overflow-hidden cursor-pointer" 
                     onclick="openModal('product-detail-{{ $product->id }}')">
                    <div class="p-4 flex items-start gap-4">
                        @if($image = json_decode($product->image, true)[0]['path'] ?? null)
                            <img src="{{ Str::startsWith($image, 'http') ? $image : asset('storage/'.$image) }}" 
                                 class="flex-shrink-0 h-16 w-16 object-cover rounded-lg">
                        @endif
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-bold truncate">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 truncate">{{ $product->category->name }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-lg font-bold text-primary">
                                    Rp{{ number_format($product->harga_jual, 0, ',', '.') }}
                                </span>
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                      {{ $product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    Stok: {{ $product->stok }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @foreach ($products as $product)
            @include('produk.detailProduk', ['product' => $product])
            @include('produk.editProduk', ['product' => $product])
            @include('produk.deleteProduk', ['product' => $product])
        @endforeach
    </div>

    <div class="fixed bottom-6 right-6">
        <button onclick="openModal('add-product')" 
                class="p-4 bg-primary text-white rounded-full shadow-lg hover:bg-primary-dark transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </button>
    </div>

    @include('produk.createProduk')

    <script>
        function openModal(id) {
            document.getElementById(id)?.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            document.getElementById(id)?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[id^="product-detail-"], [id^="edit-product-"], [id^="delete-product-"]').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeModal(this.id);
                    }
                });
            });
        });
    </script>
</x-admin>
