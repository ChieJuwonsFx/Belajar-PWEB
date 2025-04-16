<x-owner>
    <div class="p-6 w-full">     
        <form method="GET" action="{{ route('owner.produk') }}" class="max-w-full mb-4">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
                <div class="relative w-full sm:w-auto">
                    <label for="category" class="sr-only">Category</label>
                    <select id="category" name="category" 
                        class="appearance-none w-full sm:w-48 py-2.5 px-4 text-sm font-medium text-gray-900 bg-white border border-primary rounded-lg hover:bg-white focus:ring-1 focus:border-primary focus:ring-gray-100">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="relative w-full">
                    <input type="search" name="search" id="search-dropdown"
                        class="block w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-primary rounded-lg focus:ring-1 focus:outline-none focus:border-primary focus:ring-gray-100 pr-12"
                        placeholder="Cari produk..." value="{{ request('search') }}" />
                    <button type="submit" class="absolute top-1/2 right-2 -translate-y-1/2 p-2 text-white bg-primary rounded-lg border border-primary hover:text-primary hover:bg-white focus:ring-1 focus:outline-none focus:border-primary focus:ring-gray-100 ">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
        </form>
        
                
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition-all duration-300 overflow-hidden cursor-pointer" 
                     onclick="openModal('product-detail-{{ $product->id }}')">
                    <div class="p-4 flex items-start gap-4">
                        <div class="grid grid-rows-[auto_auto] gap-1 items-center">                            
                            @if($image = json_decode($product->image, true)[0]['path'] ?? null)
                                <div class="flex justify-center">
                                    <img src="{{ Str::startsWith($image, 'http') ? $image : asset('storage/'.$image) }}" class="h-16 w-16 object-cover rounded-lg border border-gray-200" alt="{{ $product->name }}" loading="lazy">
                                </div>
                            @endif
                            <div class="h-6 w-20 flex items-center justify-center">
                                <div class="py-1 rounded-lg text-xs font-medium text-center w-full  {{ $product->is_available == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_available }}
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="mt-2 flex justify-between items-center">
                                <h3 class="text-lg font-bold truncate">{{ $product->name }}</h3>
                            </div>
                            <p class="text-sm text-gray-500 truncate">{{ $product->category->name }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <div class="text-lg font-bold text-primary">
                                    Rp{{ number_format($product->harga_jual, 0, ',', '.') }}
                                </div>
                                <div class="h-6 w-20 flex items-center justify-center">
                                    <div class="py-1 rounded-lg text-xs font-medium text-center w-full  {{ $product->total_stok > $product->stok_minimum ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        Stok: {{ $product->total_stok }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @foreach ($products as $product)
            @include('owner.produk.detailProduk', ['product' => $product])
            @include('owner.produk.deleteProduk', ['product' => $product])
        @endforeach
    </div>

    <div class="fixed bottom-6 right-6">
        <button onclick="openModal('add-produk')" 
                class="p-4 bg-primary text-white border border-primary hover:bg-white hover:text-primary  rounded-full shadow-lg hover:bg-primary-dark transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </button>
    </div>

    @include('owner.produk.createProduk')    
</x-owner>
