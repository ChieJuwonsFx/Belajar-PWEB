<x-admin>
    <div class="text-primary p-6 flex gap-4 grid-cols-2">
        @foreach ($products as $product)
            <div class="w-full max-w-6xl mx-auto">
                <div class="bg-white rounded-lg shadow p-4 mb-2 flex justify-between items-center cursor-pointer" onclick="toggleDropdown('{{ $product->id }}')">
                <div class="flex items-center gap-4">
                    <img src="https://via.placeholder.com/60" class="w-16 h-16 object-cover rounded" alt="iMac">
                    <div>
                    <h2 class="text-lg font-bold mb-1">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-400">{{ $product->category->name }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xl font-bold text-terti mb-2">Rp{{ $product->harga }}</p>
                    <span class="bg-green-600 text-white font-medium px-2 py-1 rounded text-xs">Stok : {{ $product->stok }}</span>
                </div>
                </div>

                <div id="{{ $product->id }}" class="hidden bg-white rounded-lg shadow p-4 mb-4">
                @foreach ($product->images as $image)
                    @if($image->url && Str::startsWith($image->url, 'http'))
                    <img src="{{ $image->url }}" class="w-16 h-16 object-cover rounded-full shadow" alt="">
                    @elseif($image->url)
                    <img src="{{ asset('storage/' . $image->url) }}" class="w-16 h-16 object-cover rounded-full shadow" alt="">
                    @endif
                @endforeach
                <p class="mb-2 text-sm text-primary">
                    {{ $product->deskripsi }}
                </p>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                    {{-- <div><strong>Product State:</strong> <span class="bg-blue-500 text-white font-medium px-2 py-1 rounded text-xs">New</span></div> --}}
                    {{-- <div><strong>Stok:</strong> {{ $product->stok }}</div> --}}
                    {{-- <div><strong>Colors:</strong> <span class="inline-block w-4 h-4 bg-purple-500 rounded-full"></span>
                    <span class="inline-block w-4 h-4 bg-blue-500 rounded-full"></span>
                    <span class="inline-block w-4 h-4 bg-pink-400 rounded-full"></span>
                    <span class="inline-block w-4 h-4 bg-green-400 rounded-full"></span>
                    </div> --}}
                    {{-- <div><strong>Brand:</strong> Apple</div>
                    <div><strong>Dimensions:</strong> 105 x 15 x 23 cm</div>
                    <div><strong>Item Weight:</strong> 12 kg</div>
                    <div><strong>Sold by:</strong> Flowbite</div>
                    <div><strong>Ships from:</strong> Flowbite</div> --}}
                </div>

                <div class="mt-4 flex gap-3">
                    <button class="hover:bg-[#E2F0DA] hover:text-primary text-white bg-green-600 font-medium px-4 py-1 rounded-lg">Edit</button>
                    <button class="hover:bg-[#DCECF5] hover:text-primary text-white bg-blue-500 font-medium px-4 py-1 rounded-lg">Preview</button>
                    <button class="hover:bg-[#FFD9D9] hover:text-primary text-white bg-red-700 font-medium px-4 py-1 rounded-lg">Delete</button>
                </div>
                </div>
            </div>
        @endforeach

    <script>
        function toggleDropdown(id) {
        const el = document.getElementById(id);
        el.classList.toggle('hidden');
        }
    </script>
    </div>      
</x-admin>
