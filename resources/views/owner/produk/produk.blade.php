 <x-owner>
    <div class="p-4 sm:p-6 w-full">
        <div class="flex flex-col lg:flex-row items-center justify-between w-full gap-4 mb-6">
            <form method="GET" action="{{ route('owner.produk') }}" class="w-full">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative w-full sm:w-56">
                        <label for="category" class="sr-only">Kategori</label>
                        <div class="relative">
                            <select id="category" name="category"
                                class="appearance-none w-full py-2.5 pl-4 pr-10 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg hover:border-primary focus:ring-0 focus:border-primary">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="relative w-full">
                        <div class="relative">
                            <input type="search" name="search" id="search-dropdown"
                                class="block w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg  focus:ring-0 focus:border-primary hover:border-primary pr-12"
                                placeholder="Cari produk..." value="{{ request('search') }}" />
                            <button type="submit"
                                class="absolute top-1/2 right-2 -translate-y-1/2 p-2 text-white bg-primary rounded-lg border border-primary hover:bg-white hover:text-primary">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                                <span class="sr-only">Cari</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md duration-300 overflow-hidden border border-gray-100 hover:border-blue-100 cursor-pointer group"
                     onclick="openModal('product-detail-{{ $product->id }}')">
                    <div class="relative h-40 overflow-hidden">
                        @if($image = json_decode($product->image, true)[0] ?? null)
                            <img src="{{ $image }}"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                 alt="{{ $product->name }}"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->is_available == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_available }}
                            </span>
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
                                <span class="py-1 px-3 rounded-lg font-semibold {{ $product->total_stok > $product->stok_minimum ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    Stok: {{ $product->stok }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($products->isEmpty())
        <div class="flex flex-col items-center justify-center py-12">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada produk ditemukan</h3>
            <p class="text-sm text-gray-500">Coba gunakan filter yang berbeda atau tambahkan produk baru</p>
        </div>
        @endif

        @foreach ($products as $product)
            @include('owner.produk.detailProduk', ['product' => $product])
        @endforeach
    </div>

    <div class="fixed bottom-6 right-6">
        <button onclick="openModal('add-produk')"
            class="p-5 bg-primary text-white border border-primary hover:bg-white hover:text-primary rounded-full shadow-lg flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span class="sr-only">Tambah Produk</span>
        </button>
    </div>

    @include('owner.produk.createProduk')
</x-owner>
