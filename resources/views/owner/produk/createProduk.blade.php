<div id="add-produk" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal('add-produk')"></div>
    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Tambah Produk Baru</h2>
                    <p class="text-primary-100">Isi Semua Form di Bawah Ini</p>
                </div>
                <button type="button"  class="text-white hover:text-primary-100 transition-colors" onclick="closeModal('add-produk')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form id="add-produk-form" action="{{ route('owner.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="name" id="name" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                            placeholder="Sanyo" required>
                    </div>
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-700">Kategori</label>
                        <select id="category" name="category" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="stok" class="block mb-2 text-sm font-medium text-gray-700">Stok Awal</label>
                        <input type="number" name="stok" id="stok" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                            placeholder="20" required>
                    </div>
                    <div>
                        <label for="stok_minimum" class="block mb-2 text-sm font-medium text-gray-700">Stok Minimum</label>
                        <input type="number" name="stok_minimum" id="stok_minimum" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                            placeholder="20" required>
                    </div>
                    <div>
                        <label for="is_available" class="block mb-1 text-sm font-medium text-gray-700">Satuan Produk</label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih produk dijual dalam satuan apa.</p>
                        <select id="unit" name="unit" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Pilih Satuan</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" {{ request('unit') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="is_available" class="block mb-1 text-sm font-medium text-gray-700">Status Ketersediaan</label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih apakah produk bisa dipesan atau tidak oleh pelanggan.</p>
                        <select name="is_available" id="is_available" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                            <option value="" disabled selected>Pilih ketersediaan</option>
                            <option value="Available">Dijual</option>
                            <option value="Unavailable">Tidak Dijual</option>
                        </select>
                    </div>             
                    <div>
                        <label for="harga_modal" class="block mb-2 text-sm font-medium text-gray-700">Harga Modal</label>
                        <input type="number" name="harga_modal" id="harga_modal"  
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                            placeholder="20000" required>
                    </div>
                    <div>
                        <label for="harga_jual" class="block mb-2 text-sm font-medium text-gray-700">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                            placeholder="20000" required>
                    </div>
                    <div>
                        <label for="is_stock_real" class="block mb-1 text-sm font-medium text-gray-700">Status Stok</label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih apakah stok awal sudah sesuai dengan kondisi nyata.</p>
                        <select name="is_stock_real" id="is_stock_real" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                            <option value="" disabled selected>Pilih ketersediaan</option>
                            <option value=true>Sesuai</option>
                            <option value=false>Tidak Sesuai</option>
                        </select>
                    </div>
                    <div>
                        <label for="is_modal_real" class="block mb-1 text-sm font-medium text-gray-700">Status Harga Modal</label>
                        <p class="block mb-2 text-xs text-gray-700">Pilih apakah harga modal sudah sesuai dengan kondisi nyata.</p>
                        <select name="is_modal_real" id="is_modal_real" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                            <option value="" disabled selected>Pilih ketersediaan</option>
                            <option value=true>Sesuai</option>
                            <option value=false>Tidak Sesuai</option>
                        </select>
                    </div>
                </div>
                <div class="my-4">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi Produk</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                        placeholder="Mampu menarik air hingga mengalir sampai jauh..." required></textarea>
                </div>
                
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Foto Produk</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="previewContainer">
                        <label for="imageInput"
                            class="flex items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <div class="text-center">
                                <div class="text-3xl text-primary">+</div>
                                <p class="text-sm text-gray-500 mt-1">Tambah Gambar</p>
                            </div>
                        </label>
                        
                    </div>
                    <p class="mt-2 text-xs text-gray-500">PNG, JPG, or JPEG (Max 2MB)</p>

                    <input type="file" id="imageInput" accept="image/png, image/jpeg, image/jpg, image/webp" class="hidden">
                    <input type="hidden" name="images_json" id="imagesJsonInput">
                </div>

                <div class="flex justify-end">
                    <button id="submitBtn" type="submit"
                        class="text-white bg-primary border border-primary hover:bg-white hover:text-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                        <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Tambah Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');
        const imagesJsonInput = document.getElementById('imagesJsonInput');
    
        let imageList = [];
    
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
    
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert("File harus berupa gambar (jpg, jpeg, png, webp)");
                return;
            }
    
            if (file.size > 2 * 1024 * 1024) {
                alert("Ukuran maksimal 2MB");
                return;
            }
    
            const reader = new FileReader();
            reader.onload = function (e) {
                const base64 = e.target.result;
    
                imageList.push(base64);
                imagesJsonInput.value = JSON.stringify(imageList);
    
                const card = document.createElement('div');
                card.className = "relative rounded-lg overflow-hidden shadow-md group";
    
                card.innerHTML = `
                    <img src="${base64}" class="w-full h-40 object-cover">
                    <button type="button" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition"
                            onclick="removeImage(this)">
                        &times;
                    </button>
                `;
    
                previewContainer.prepend(card);
            };
            reader.readAsDataURL(file);
    
            this.value = '';
        });
    
        function removeImage(button) {
            const card = button.parentElement;
            const imgSrc = card.querySelector('img').src;
    
            imageList = imageList.filter(src => src !== imgSrc);
            imagesJsonInput.value = JSON.stringify(imageList);
    
            card.remove();
        }
    </script>
    </div>