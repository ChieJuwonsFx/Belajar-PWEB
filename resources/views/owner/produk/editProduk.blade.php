<div id="edit-produk-{{ $product->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
        onclick="closeModal('edit-produk-{{ $product->id }}')"></div>
    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Edit Produk</h2>
                    <p class="text-primary-100">Perbarui semua informasi produk di bawah ini</p>
                </div>
                <button type="button" class="text-white hover:text-primary-100 transition-colors"
                    onclick="closeModal('edit-produk-{{ $product->id }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('owner.produk.update', $product->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ $product->name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-700">Kategori</label>
                        <select id="category" name="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="harga_jual" class="block mb-2 text-sm font-medium text-gray-700">Harga Jual <span
                                class="text-xs font-normal text-gray-700">(Isi harga jual produk untuk setiap
                                unitnya.)</span></label>

                        <input type="number" name="harga_jual" id="harga_jual" value="{{ $product->harga_jual }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="stok_minimum" class="block mb-2 text-sm font-medium text-gray-700">Stok
                            Minimum</label>
                        <input type="number" name="stok_minimum" id="stok_minimum" value="{{ $product->stok_minimum }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="unit" class="block mb-1 text-sm font-medium text-gray-700">Satuan Produk</label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih produk dijual dalam satuan apa.</p>
                        <select id="unit" name="unit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Pilih Satuan</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ $product->unit_id == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="is_available" class="block mb-1 text-sm font-medium text-gray-700">Status
                            Ketersediaan</label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih apakah produk bisa dipesan atau tidak oleh
                            pelanggan.</p>
                        <select name="is_available" id="is_available"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            required>
                            <option value="" disabled>Pilih ketersediaan</option>
                            <option value="Available" {{ $product->is_available == 'Available' ? 'selected' : '' }}>
                                Dijual</option>
                            <option value="Unavailable"
                                {{ $product->is_available == 'Unavailable' ? 'selected' : '' }}>Tidak Dijual</option>
                        </select>
                    </div>
                </div>
                <div class="my-4">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi Produk</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                        required>{{ $product->deskripsi }}</textarea>
                </div>

                <div class="md:col-span-2 mb-6">
                    <label for="barcode" class="block mb-2 text-sm font-medium text-gray-700">Barcode Produk
                        (Opsional)</label>
                    <p class="block mb-2 text-xs text-gray-700">Pastikan barcode yang diinputkan sudah benar!</p>
                    <div class="flex gap-2">
                        <input type="text" name="barcode" id="barcode" value="{{ $product->barcode }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Masukkan barcode">
                            <button type="button" onclick="openModal('scanner-edit-{{ $product->id }}')"
                            class="text-white bg-primary border border-primary hover:text-primary hover:bg-white font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                            <span class="ml-2">Scan</span>
                        </button>
                        <x-scanner id="scanner-edit-{{ $product->id }}"/>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Foto Produk</label>
                    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4" id="previewContainer-{{ $product->id }}">
                        @foreach ($images as $index => $img)
                            <div class="relative rounded-lg overflow-hidden shadow-md group aspect-[4/3]">
                                <img src="{{ is_array($img) ? $img['path'] : $img }}" 
                                     class="w-full h-full object-cover">
                                <button type="button"
                                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition"
                                    onclick="removeImageEdit(this, '{{ $product->id }}', {{ $index }})">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                
                        <label for="imageInput-{{ $product->id }}"
                            class="flex items-center justify-center aspect-[4/3] w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <div class="text-center">
                                <div class="text-3xl text-primary">+</div>
                                <p class="text-sm text-gray-500 mt-1">Tambah Gambar</p>
                            </div>
                        </label>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">PNG, JPG, or JPEG (Max 2MB)</p>
                
                    <input type="file" id="imageInput-{{ $product->id }}"
                        accept="image/png, image/jpeg, image/jpg, image/webp" class="hidden" multiple>
                    <input type="hidden" name="image" id="imagesJsonInput-{{ $product->id }}"
                        value='{{ json_encode($images) }}'>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="text-white bg-primary border border-primary hover:bg-white hover:text-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                        <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setupImageManagement(productId) {
        const imageInput = document.getElementById(`imageInput-${productId}`);
        const previewContainer = document.getElementById(`previewContainer-${productId}`);
        const imagesJsonInput = document.getElementById(`imagesJsonInput-${productId}`);

        let imageList = JSON.parse(imagesJsonInput.value || '[]');
        if (!Array.isArray(imageList)) {
            imageList = [];
        }

        function renderExistingImages() {
            imageList.forEach((img, index) => {
                if (typeof img === 'object' && img.path) {
                    addImageCard(img.path, index);
                } else if (typeof img === 'string') {
                    addImageCard(img, index);
                }
            });
        }

        function addImageCard(imgSrc, imgIndex) {
            const card = document.createElement('div');
            card.className = "relative rounded-lg overflow-hidden shadow-md group aspect-[4/3]";
            card.innerHTML = `
                <img src="${imgSrc}" class="w-full h-full object-cover">
                <button type="button" 
                        class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition"
                        onclick="removeImageEdit(this, '${productId}', ${imgIndex})">
                    &times;
                </button>
            `;
            
            const addLabel = previewContainer.querySelector(`label[for="imageInput-${productId}"]`);
            previewContainer.insertBefore(card, addLabel);
        }

        imageInput.addEventListener('change', function() {
            const files = this.files;
            if (!files || files.length === 0) return;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert("Hanya file gambar (jpg, jpeg, png, webp) yang diperbolehkan");
                    continue;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert("Ukuran file maksimal 2MB");
                    continue;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const newImage = {
                        path: e.target.result,
                        filename: file.name,
                        is_primary: imageList.length === 0
                    };
                    
                    imageList.push(newImage);
                    updateImagesInput();
                    addImageCard(newImage.path, imageList.length - 1);
                };
                reader.readAsDataURL(file);
            }

            this.value = '';
        });

        function updateImagesInput() {
            imagesJsonInput.value = JSON.stringify(imageList);
        }

        renderExistingImages();
    }

    function removeImageEdit(button, productId, imgIndex) {
        const imagesJsonInput = document.getElementById(`imagesJsonInput-${productId}`);
        let imageList = JSON.parse(imagesJsonInput.value || '[]');
        
        imageList.splice(imgIndex, 1);
        imagesJsonInput.value = JSON.stringify(imageList);
        
        button.parentElement.remove();
    }
</script>
