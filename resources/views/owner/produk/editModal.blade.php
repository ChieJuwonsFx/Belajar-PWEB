<div id="edit-produk" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Edit Produk</h2>
                    <p class="text-primary-100">Perbarui semua informasi produk di bawah ini</p>
                </div>
                <button type="button" class="text-white hover:text-primary-100 transition-colors"
                    onclick="closeEditModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form id="edit-product-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-product-id" name="id">

                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="edit-product-name" class="block mb-2 text-sm font-medium text-gray-700">Nama
                            Produk</label>
                        <input type="text" name="name" id="edit-product-name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="edit-product-category"
                            class="block mb-2 text-sm font-medium text-gray-700">Kategori</label>
                        <select id="edit-product-category" name="category"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit-product-price" class="block mb-2 text-sm font-medium text-gray-700">Harga
                            Jual</label>
                        <input type="number" name="harga_jual" id="edit-product-price"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="edit-product-min-stock" class="block mb-2 text-sm font-medium text-gray-700">Stok
                            Minimum</label>
                        <input type="number" name="stok_minimum" id="edit-product-min-stock"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="edit-product-unit" class="block mb-1 text-sm font-medium text-gray-700">Satuan
                            Produk</label>
                        <select id="edit-product-unit" name="unit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Pilih Satuan</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit-product-status" class="block mb-1 text-sm font-medium text-gray-700">Status
                            Ketersediaan</label>
                        <select name="is_available" id="edit-product-status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                            required>
                            <option value="" disabled>Pilih ketersediaan</option>
                            <option value="Available">Dijual</option>
                            <option value="Unavailable">Tidak Dijual</option>
                        </select>
                    </div>
                </div>
                <div class="my-4">
                    <label for="edit-product-description" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi
                        Produk</label>
                    <textarea name="deskripsi" id="edit-product-description" rows="3"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                        required></textarea>
                </div>

                <div class="md:col-span-2 mb-6">
                    <label for="edit-product-barcode" class="block mb-2 text-sm font-medium text-gray-700">Barcode
                        Produk (Opsional)</label>
                    <div class="flex gap-2">
                        <input type="text" name="barcode" id="edit-product-barcode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Masukkan barcode">
                        <button type="button" onclick="openScannerModal()"
                            class="text-white bg-primary border border-primary hover:text-primary hover:bg-white font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                            <span class="ml-2">Scan</span>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Foto Produk</label>
                    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-4" id="edit-product-preview-container">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">PNG, JPG, or JPEG (Max 2MB)</p>
                    <input type="file" id="edit-product-image-input" name="images[]"
                        accept="image/png, image/jpeg, image/jpg, image/webp" class="hidden" multiple>
                    <input type="hidden" name="image_data" id="edit-product-images-json">
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
    let currentEditImageData = {
        existing: [],
        new: [],
        deleted: []
    };

    function resetEditForm() {
        document.getElementById('edit-product-form').reset();
        currentEditImageData = {
            existing: [],
            new: [],
            deleted: []
        };

        const imageInput = document.getElementById('edit-product-image-input');
        const newImageInput = imageInput.cloneNode(true);
        imageInput.parentNode.replaceChild(newImageInput, imageInput);
    }

    function setupEditImageHandlers() {
        const imageInput = document.getElementById('edit-product-image-input');

        imageInput.removeEventListener('change', handleImageInputChange);
        imageInput.addEventListener('change', handleImageInputChange);
    }

    function handleImageInputChange(event) {
        const files = event.target.files;
        if (!files || files.length === 0) return;

        Array.from(files).forEach(file => {
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert("Hanya file gambar (jpg, jpeg, png, webp) yang diperbolehkan");
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert("Ukuran file maksimal 2MB");
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                currentEditImageData.new.push({
                    path: e.target.result,
                    filename: file.name
                });

                updateEditImagesInput();
                renderEditImages();
            };
            reader.readAsDataURL(file);
        });

        event.target.value = '';
    }

    function renderEditImages() {
        const previewContainer = document.getElementById('edit-product-preview-container');
        previewContainer.innerHTML = '';

        currentEditImageData.existing.forEach((img, index) => {
            if (currentEditImageData.deleted.includes(img.id)) return;

            const card = document.createElement('div');
            card.className = "relative rounded-lg overflow-hidden shadow-md group aspect-[4/3]";
            card.innerHTML = `
                <img src="${img.path}" class="w-full h-full object-cover" alt="Product Image">
                <button type="button" 
                        class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700 transition text-sm"
                        onclick="removeExistingImage(${img.id})">
                    ×
                </button>
            `;
            previewContainer.appendChild(card);
        });

        currentEditImageData.new.forEach((img, index) => {
            const card = document.createElement('div');
            card.className = "relative rounded-lg overflow-hidden shadow-md group aspect-[4/3]";
            card.innerHTML = `
                <img src="${img.path}" class="w-full h-full object-cover" alt="New Product Image">
                <button type="button" 
                        class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700 transition text-sm"
                        onclick="removeNewImage(${index})">
                    ×
                </button>
            `;
            previewContainer.appendChild(card);
        });

        const addLabel = document.createElement('label');
        addLabel.htmlFor = 'edit-product-image-input';
        addLabel.className =
            'flex items-center justify-center aspect-[4/3] w-full h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition';
        addLabel.innerHTML = `
            <div class="text-center">
                <div class="text-3xl text-primary">+</div>
                <p class="text-sm text-gray-500 mt-1">Tambah Gambar</p>
            </div>
        `;
        previewContainer.appendChild(addLabel);
    }

    function removeExistingImage(imageId) {
        if (!currentEditImageData.deleted.includes(imageId)) {
            currentEditImageData.deleted.push(imageId);
        }
        updateEditImagesInput();
        renderEditImages();
    }

    function removeNewImage(index) {
        currentEditImageData.new.splice(index, 1);
        updateEditImagesInput();
        renderEditImages();
    }

    function updateEditImagesInput() {
        const imagesJsonInput = document.getElementById('edit-product-images-json');
        imagesJsonInput.value = JSON.stringify(currentEditImageData);
    }

    function parseImageData(imageData) {
        if (!imageData) return [];
        try {
            if (typeof imageData === 'string') {
                return JSON.parse(imageData);
            }
            return imageData;
        } catch (e) {
            console.error('Error parsing image data:', e);
            return [];
        }
    }

    document.getElementById('edit-product-form').addEventListener('submit', function(e) {
        updateEditImagesInput();
        console.log('Submitting image data:', currentEditImageData);
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });
</script>