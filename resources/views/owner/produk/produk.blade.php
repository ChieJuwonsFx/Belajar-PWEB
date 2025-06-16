<x-owner>
    <div class="p-4 w-full">
        <div class="flex flex-col lg:flex-row items-center justify-between w-full gap-4 mb-6">
            <form method="GET" id="filter-form" action="{{ route('owner.produk') }}" class="w-full">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative w-full sm:w-56">
                        <label for="category" class="sr-only">Kategori</label>
                        <div class="relative">
                            <select id="category" name="category"
                                class="appearance-none w-full py-2.5 pl-4 pr-10 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg hover:border-primary focus:ring-0 focus:border-primary">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
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
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
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
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md duration-300 overflow-hidden border border-gray-100 hover:border-blue-100 cursor-pointer product-card"
                    data-product-id="{{ $product->id }}"
                    data-product="{{ json_encode([
                        'id' => $product->id,
                        'name' => $product->name,
                        'category' => ['name' => $product->category->name],
                        'category_id' => $product->category_id,
                        'deskripsi' => $product->deskripsi,
                        'is_available' => $product->is_available,
                        'stok' => $product->stok,
                        'stok_minimum' => $product->stok_minimum,
                        'harga_jual' => $product->harga_jual,
                        'estimasi_modal' => $product->estimasi_modal,
                        'is_stock_real' => $product->is_stock_real,
                        'is_modal_real' => $product->is_modal_real,
                        'harga_modal_real' => $product->is_modal_real
                            ? $product->stocks()->latest()->first()->harga_modal ?? 0
                            : $product->estimasi_modal,
                        'unit' => ['name' => $product->unit->name],
                        'unit_id' => $product->unit_id,
                        'image' => $product->image,
                        'barcode' => $product->barcode,
                    ]) }}">
                    <div class="relative h-40 overflow-hidden">
                        @php
                            $images = [];
                            if (is_string($product->image)) {
                                $decoded = json_decode($product->image, true);
                                $images =
                                    json_last_error() === JSON_ERROR_NONE ? $decoded : [['path' => $product->image]];
                            } elseif (is_array($product->image)) {
                                $images = $product->image;
                            }

                            $images = array_map(function ($img) {
                                $path = is_array($img) ? $img['path'] ?? ($img['url'] ?? null) : $img;

                                if ($path) {
                                    if (Str::startsWith($path, ['http://', 'https://'])) {
                                        return ['path' => $path];
                                    }
                                    if (!Str::contains($path, 'storage/')) {
                                        return ['path' => asset('storage/product/' . $path)];
                                    }

                                    return ['path' => asset(ltrim($path, '/'))];
                                }

                                return ['path' => null];
                            }, $images);
                        @endphp

                        @if (count($images) > 0 && !empty($images[0]['path']))
                            <div class="relative w-full h-full">
                                <img src="{{ $images[0]['path'] }}" alt="{{ $product->name }}" loading="lazy"
                                    class="w-full h-full object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                <div class="w-full h-full bg-gray-100 flex items-center justify-center"
                                    style="display: none;">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>

                                @if (count($images) > 1)
                                    <div
                                        class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">
                                        1/{{ count($images) }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->is_available == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
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
                                <span
                                    class="py-1 px-3 rounded-lg font-semibold {{ $product->stok > $product->stok_minimum ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    Stok: {{ $product->stok }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($products->isEmpty())
            <div class="flex flex-col items-center justify-center py-12">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada produk ditemukan</h3>
                <p class="text-sm text-gray-500">Coba gunakan filter yang berbeda atau tambahkan produk baru</p>
            </div>
        @endif

        @include('owner.produk.detailModal')
        @include('owner.produk.createProduk')

        @if ($products->hasPages())
            <div class="mx-auto my-6 w-full">
                {{ $products->links() }}
            </div>
        @endif

        <div class="fixed bottom-6 right-6">
            <button onclick="openModal('add-produk')"
                class="p-5 bg-primary text-white border border-primary hover:bg-white hover:text-primary rounded-full shadow-lg flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="sr-only">Tambah Produk</span>
            </button>
        </div>
    </div>

    <script>
        document.getElementById('category').addEventListener('change', function() {
            document.getElementById('search-dropdown').value = '';
            document.getElementById('filter-form').submit();
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.formatNumber = function(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            };

            window.parseImageData = function(imageData) {
                if (!imageData) return [];

                let images = [];

                try {
                    if (typeof imageData === 'string') {
                        let parsed = JSON.parse(imageData);
                        images = Array.isArray(parsed) ? parsed : [parsed];
                    } else if (Array.isArray(imageData)) {
                        images = imageData;
                    } else {
                        images = [imageData];
                    }
                } catch (e) {
                    console.error('Error parsing image data:', e);
                    images = [{
                        path: imageData
                    }];
                }

                return images.map(img => {
                    let path = (typeof img === 'string') ? img : (img.path || img.url || img.src ||
                        null);

                    if (!path) return {
                        path: null
                    };

                    if (path.startsWith('http://') || path.startsWith('https://')) {
                        return {
                            ...img,
                            path
                        };
                    }

                    if (path.includes('/storage/storage/')) {
                        path = path.replace('/storage/storage/', '/storage/');
                    }

                    if (!path.startsWith('storage/') && !path.startsWith('/storage/')) {
                        path = 'storage/product/' + path;
                    }

                    if (!path.startsWith('http')) {
                        path = asset(path.startsWith('/') ? path : '/' + path);
                    }

                    return {
                        ...(typeof img === 'object' ? img : {}),
                        path: path
                    };
                });
            };

            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function() {
                    const productData = JSON.parse(this.dataset.product);
                    openDetailModal(productData);
                });
            });

            document.getElementById('btn-restok')?.addEventListener('click', () => {
                if (currentProduct) openRestockModal(currentProduct);
            });

            document.getElementById('btn-edit')?.addEventListener('click', () => {
                if (currentProduct) openEditModal(currentProduct);
            });

            document.getElementById('btn-delete')?.addEventListener('click', () => {
                if (currentProduct) openDeleteModal(currentProduct.id, currentProduct.name);
            });
        });

        let currentProduct = null;

        function openDetailModal(productData) {
            currentProduct = productData;

            document.getElementById('product-name').textContent = productData.name;
            document.getElementById('product-category').textContent = productData.category.name;
            document.getElementById('product-category-detail').textContent = productData.category.name;
            document.getElementById('product-description').textContent = productData.deskripsi || '-';

            const statusElement = document.getElementById('product-status');
            statusElement.textContent = productData.is_available;
            statusElement.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
            productData.is_available == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
        }`;

            const stockElement = document.getElementById('product-stock');
            stockElement.textContent = `${productData.stok} ${productData.unit.name}`;

            const stockTypeBadge = document.getElementById('stock-type-badge');
            stockTypeBadge.textContent = productData.is_stock_real ? 'Real' : 'Tidak Real';
            stockTypeBadge.className = `text-xs px-2 py-0.5 rounded-full ${
            productData.is_stock_real ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
        }`;

            document.getElementById('product-min-stock').textContent =
                `${productData.stok_minimum} ${productData.unit.name}`;

            document.getElementById('product-sell-price').textContent =
                `Rp${formatNumber(productData.harga_jual)}`;

            const costPriceElement = document.getElementById('product-cost-price');
            costPriceElement.textContent = `Rp${formatNumber(productData.harga_modal_real)}`;

            const costTypeBadge = document.getElementById('cost-type-badge');
            costTypeBadge.textContent = productData.is_modal_real ? 'Real' : 'Estimasi';
            costTypeBadge.className = `text-xs px-2 py-0.5 rounded-full ${
            productData.is_modal_real ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
        }`;

            const barcodeImg = document.getElementById('product-barcode');
            barcodeImg.src = `/products/barcode/${productData.id}`;
            barcodeImg.alt = `Barcode ${productData.name}`;

            const barcodeDownload = document.getElementById('product-barcode-download');
            barcodeDownload.href = `/products/barcode/${productData.id}/download`;

            const imagesContainer = document.getElementById('product-images');
            imagesContainer.innerHTML = '';

            const images = parseImageData(productData.image).filter(img => img.path);

            if (images.length > 0) {
                images.forEach((img, index) => {
                    const imageElement = document.createElement('div');
                    imageElement.className =
                        'relative group overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-all duration-300';

                    const aspectContainer = document.createElement('div');
                    aspectContainer.className = 'aspect-[4/3] w-full overflow-hidden';

                    const imgElement = document.createElement('img');
                    imgElement.src = img.path;
                    imgElement.alt = `${productData.name} image ${index + 1}`;
                    imgElement.className =
                        'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110';
                    imgElement.onerror = function() {
                        this.parentNode.replaceChild(createImagePlaceholder(), this.parentNode);
                    };

                    aspectContainer.appendChild(imgElement);
                    imageElement.appendChild(aspectContainer);

                    if (images.length > 1) {
                        const counterElement = document.createElement('div');
                        counterElement.className =
                            'absolute bottom-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm';
                        counterElement.textContent = `${index + 1}/${images.length}`;
                        imageElement.appendChild(counterElement);
                    }

                    imagesContainer.appendChild(imageElement);
                });
            } else {
                imagesContainer.appendChild(createImagePlaceholder());
            }

            document.getElementById('detail-product-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function createImagePlaceholder() {
            const placeholder = document.createElement('div');
            placeholder.className = 'aspect-[4/3] rounded-lg bg-gray-100 flex items-center justify-center';

            const icon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            icon.setAttribute('class', 'w-12 h-12 text-gray-400');
            icon.setAttribute('fill', 'none');
            icon.setAttribute('viewBox', '0 0 24 24');
            icon.setAttribute('stroke', 'currentColor');

            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('stroke-linecap', 'round');
            path.setAttribute('stroke-linejoin', 'round');
            path.setAttribute('stroke-width', '2');
            path.setAttribute('d',
                'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'
            );

            icon.appendChild(path);
            placeholder.appendChild(icon);

            return placeholder;
        }

        function closeDetailModal() {
            document.getElementById('detail-product-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function openRestockModal(product) {
            document.getElementById('restock-product-name').value = product.name;
            document.getElementById('restock-product-id').value = product.id;
            document.getElementById('restok-produk').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function openEditModal(product) {
            resetEditForm();

            document.getElementById('edit-product-id').value = product.id;
            document.getElementById('edit-product-name').value = product.name || '';
            document.getElementById('edit-product-description').value = product.deskripsi || '';
            document.getElementById('edit-product-price').value = product.harga_jual || '';
            document.getElementById('edit-product-min-stock').value = product.stok_minimum || '';
            document.getElementById('edit-product-barcode').value = product.barcode || '';
            document.getElementById('edit-product-category').value = product.category_id || '';
            document.getElementById('edit-product-unit').value = product.unit_id || '';
            document.getElementById('edit-product-status').value = product.is_available || '';

            const existingImages = parseImageData(product.image);
            currentEditImageData = {
                existing: existingImages.map((img, index) => ({
                    id: img.id || index,
                    path: img.path
                })),
                new: [],
                deleted: []
            };

            document.getElementById('edit-product-form').action = `/owner/produk/update/${product.id}`;
            renderEditImages();
            setupEditImageHandlers();

            document.getElementById('edit-produk').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-produk').classList.add('hidden');
            resetEditForm();
        }

        function openDeleteModal(productId, productName) {
            const modal = document.getElementById('delete-konfirmasi');

            const messageElement = modal.querySelector('.text-gray-700');
            messageElement.innerHTML =
                `Apakah kamu yakin ingin menghapus produk <span class='font-semibold'>${productName}</span> ini? Tindakan ini tidak dapat dibatalkan.`;

            const form = document.getElementById('delete-form');
            form.action = `/owner/produk/delete/${productId}`;

            const confirmButton = modal.querySelector('.bg-danger');
            confirmButton.onclick = function() {
                form.submit();
            };

            modal.classList.remove('hidden');
        }

        function asset(path) {
            return window.location.origin + '/' + path.replace(/^\//, '');
        }
    </script>
</x-owner>
