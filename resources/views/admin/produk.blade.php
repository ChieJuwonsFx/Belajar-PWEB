<x-admin>
    <div class="text-primary p-6 gap-4 grid grid-cols-2">
        @foreach ($products as $product)
            <div class="w-full max-w-6xl mx-auto">
                <div class="bg-white rounded-lg shadow p-4 mb-2 flex justify-between items-center cursor-pointer" onclick="openModal({{ $product->id }})">
                    <div class="flex items-center gap-4">
                        @if (!empty($product->image) && isset($product->image[0]['path']))
                            <img src="{{ Str::startsWith($product->image[0]['path'], 'http') ? $product->image[0]['path'] : asset('storage/'.$product->image[0]['path']) }}" class="h-16 object-cover rounded" alt="">
                        @endif
                        <div>
                            <h2 class="text-lg font-bold mb-1">{{ $product->name }}</h2>
                            <p class="text-sm text-gray-400">{{ $product->category->name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold text-terti mb-2">Rp{{ $product->harga }}</p>
                        <span class="bg-green-600 text-white font-medium px-2 py-1 rounded text-xs">Stok: {{ $product->stok }}</span>
                    </div>
                </div>
            </div>

            <div id="modal-{{ $product->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full p-6 relative">
                    <button onclick="closeModal({{ $product->id }})" class="absolute top-3 right-3 text-gray-600 hover:text-red-600 text-xl font-bold">&times;</button>
                    
                    <div class="flex grid-cols-3 gap-3 mb-4">
                        @foreach ($product->image as $img)
                            <img src="{{ Str::startsWith($img['path'], 'http') ? $img['path'] : asset('storage/' . $img['path']) }}" class="h-36 border border-secondary rounded-lg object-cover" alt="{{ $img['filename'] }}">
                        @endforeach
                    </div>

                    <h2 class="text-xl font-bold text-primary mb-2">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-700 mb-2">{{ $product->deskripsi }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-2 h-20 gap-4 text-sm mb-4">
                        <div><strong>Komposisi:</strong> {{ $product->komposisi }}</div>
                        <div><strong>Rasa:</strong> {{ $product->rasa }}</div>
                        <div><strong>Berat:</strong> {{ $product->berat }} gr</div>
                        <div><strong>Harga:</strong> Rp{{ $product->harga }}</div>
                        <div><strong>Stok:</strong> {{ $product->stok }}</div>
                    </div>

                    <div class="flex gap-3">
                        <button class="hover:bg-greeny hover:text-green-700 border border-green-600 text-white bg-green-600 font-medium px-5 py-1 rounded-md">Edit</button>
                        <button class="hover:bg-bluey hover:text-blue-700 border border-blue-500 text-white bg-blue-500 font-medium px-5 py-1 rounded-md">Preview</button>
                        <button class="hover:bg-redy hover:text-red-800 border border-red-700 text-white bg-red-700 font-medium px-5 py-1 rounded-md">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function openModal(id) {
            document.getElementById(`modal-${id}`).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(`modal-${id}`).classList.add('hidden');
        }
    </script>
</x-admin>
