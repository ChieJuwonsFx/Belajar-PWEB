<x-kasir>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
        <div id="hidden-scanner" style="position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden;">
            <div id="interactive" class="viewport"></div>
        </div>
        <div class="bg-white p-4 sm:p-6">
            <div class="flex flex-col lg:flex-row items-center justify-between w-full gap-4 mb-6">
                <form class="w-full" id="filter-form">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative w-full sm:w-56">
                            <label for="category" class="sr-only">Kategori</label>
                            <div class="relative">
                                <select id="category" name="category"
                                    class="appearance-none w-full py-2.5 pl-4 pr-10 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg hover:border-primary focus:ring-0 focus:border-primary">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
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
                                    class="block w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-0 focus:border-primary hover:border-primary pr-12"
                                    placeholder="Cari produk..." value="{{ request('search') }}" />
                                <button type="submit" type="button" id="search-button"
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4 overflow-y-auto max-h-[80vh]"
                id="product-list">
                @include('kasir.product-list', ['products' => $products])
            </div>
        </div>
        <form id="transaksi-form" method="POST" action="{{ route('kasir.transaksi') }}">
            @csrf
            <input type="hidden" id="data-transaksi" name="data_transaksi">
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 sticky top-4 h-fit">
                <h2 class="text-lg font-bold mb-4">Walk-in Customer</h2>

                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Selected Product</h3>

                    <div id="selected-products" class="space-y-3 max-h-[210px] overflow-y-auto">
                        <div class="p-4 text-center text-gray-500 no-products">
                            Belum ada produk dipilih
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sub-Total:</span>
                            <span class="font-medium" id="subtotal">Rp0</span>
                        </div>

                        <div class="border-t border-gray-200 pt-2">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Diskon:</span>
                                <span class="font-medium" id="subtotal-discount">Rp0</span>
                            </div>

                            <div id="discount-container"
                                class="hidden bg-white p-3 rounded-lg border border-gray-200 mt-2">
                                <div class="grid grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <input type="number" id="discount-amount" placeholder="0"
                                            class="w-full py-2 px-3 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                    </div>
                                    <div>
                                        <select id="discount-type"
                                            class="w-full py-2 px-3 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                            <option value="fixed">Rp (Nominal)</option>
                                            <option value="percent">% (Persen)</option>
                                        </select>
                                    </div>
                                </div>
                                <button id="apply-transaction-discount"
                                    class="w-full bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md text-sm font-medium">
                                    Terapkan Diskon
                                </button>
                            </div>

                            <button id="discount-toggle"
                                class="text-primary hover:text-primary-dark text-sm font-medium flex items-center py-1">
                                <span id="discount-label">Tambah Diskon</span>
                                <svg id="discount-arrow"
                                    class="w-4 h-4 ml-1 transform transition-transform duration-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Total Diskon:</span>
                            <span class="font-medium" id="total-discount">Rp0</span>
                        </div>

                        <div class="flex justify-between font-bold text-lg border-t border-gray-200 pt-3">
                            <span>TOTAL:</span>
                            <span id="total-amount" class="text-primary">Rp0</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <button id="cancel-transaction"
                        class="w-full bg-red-500 hover:bg-red-600 text-white py-3 px-4 rounded-lg font-medium"
                        type="button">
                        CANCEL
                    </button>
                    <button id="pay-now"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium">
                        BAYAR SEKARANG
                    </button>
                </div>
            </div>
        </form>

        <template id="product-row-template">
            <div class="product-row bg-white p-3 rounded-lg border border-gray-200 group" data-id="">
                <div class="flex flex-col sm:flex-row items-start sm:items-center">
                    <button
                        class="toggle-discount mr-2 text-gray-500 hover:text-primary flex items-center sm:h-full mb-2 sm:mb-0">
                        <svg class="w-4 h-4 transform transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="flex-1 w-full">
                        <div class="font-medium product-name"></div>
                        <div class="hidden text-sm text-gray-500 mt-1 product-code"></div>
                        <div class="product-discount-display text-xs text-blue-600 mt-1 hidden">
                            Diskon: <span class="discount-amount"></span> <span class="discount-type"></span>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center sm:ml-4 w-full sm:w-auto mt-3 sm:mt-0">
                        <div class="flex items-center border border-gray-300 rounded-md mr-4 mb-2 sm:mb-0">
                            <button type="button" class="decrease-qty px-2 py-1 text-gray-600 hover:bg-gray-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 12H4" />
                                </svg>
                            </button>
                            <input type="number" min="1" value="1"
                                class="quantity-input w-20 text-center border-x border-gray-300 py-1 focus:outline-none focus:ring-1 focus:ring-primary text-sm">
                            <button type="button" class="increase-qty px-2 py-1 text-gray-600 hover:bg-gray-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>

                        <div class="font-medium product-subtotal min-w-[80px] text-right text-sm mr-4 sm:mr-0">
                            Rp0
                        </div>

                        <button class="remove-product ml-2 text-red-500 hover:text-red-700 flex items-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="product-discount-container hidden mt-3 pt-3 border-t border-gray-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Jumlah Diskon</label>
                            <input type="number"
                                class="item-discount-amount w-full py-2 px-3 text-sm border border-gray-300 rounded-md"
                                placeholder="0" min="0">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tipe Diskon</label>
                            <select
                                class="item-discount-type w-full py-2 px-3 text-sm border border-gray-300 rounded-md">
                                <option value="fixed">Rp (Nominal)</option>
                                <option value="percent">% (Persen)</option>
                            </select>
                        </div>
                    </div>
                    <button
                        class="apply-discount mt-2 w-full bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md text-sm font-medium">
                        Terapkan Diskon
                    </button>
                </div>
            </div>
        </template>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script src="{{ asset('js/kasir.transaksi.js') }}"></script>
    <script>
        $(document).ready(function() {
            let typingTimer;
            const doneTypingInterval = 400; // ms

            // Live search saat ketik
            $('#search-dropdown').on('input', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(liveSearch, doneTypingInterval);
            });

            $('#search-dropdown').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    return false;
                }
            });

            // Trigger ulang saat ganti kategori
            $('#category').on('change', function() {
                liveSearch();
            });

            function liveSearch() {
                const query = $('#search-dropdown').val();
                const category = $('#category').val();

                $.ajax({
                    url: "{{ route('products.search') }}",
                    method: 'GET',
                    data: {
                        query: query,
                        category: category
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            renderSearchResults(response.data);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error searching products:', xhr);
                    }
                });
            }

            function renderSearchResults(products) {
                const container = $('#product-list');
                container.empty();

                if (products.length === 0) {
                    container.html(`
                        <div class="flex flex-col col-span-3 items-center justify-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada produk ditemukan</h3>
                            <p class="text-sm text-gray-500">
                                Coba gunakan filter yang berbeda atau tambahkan produk baru
                            </p>
                        </div>
                    `);
                    return;
                }

                products.forEach(product => {
                    // Parse image jika masih berupa string JSON
                    const imageArray = typeof product.image === 'string' ?
                        JSON.parse(product.image) :
                        product.image;

                    const imageUrl = Array.isArray(imageArray) && imageArray.length && imageArray[0].path ?
                        imageArray[0].path :
                        '/images/default.png'; // fallback jika kosong

                    const stockBadge = product.stok > product.stok_minimum ?
                        'bg-green-100 text-green-800' :
                        'bg-red-100 text-red-800';

                    const card = $(`
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-md duration-300 overflow-hidden border border-gray-100 hover:border-blue-100 cursor-pointer product-card relative"
                                data-id="${product.id}"
                                data-barcode="${product.barcode || ''}"
                                data-name="${product.name}"
                                data-price="${product.harga_jual}"
                                data-cost="${product.harga_modal}"
                                data-category="${product.category?.name || ''}"
                                data-stock="${product.stok}"
                                data-modal-real="${product.is_modal_real}">
                                
                                <div class="relative h-40 overflow-hidden">
                                    <img src="${imageUrl}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                        alt="${product.name}" loading="lazy">

                                    <div class="absolute top-2 right-2 flex items-center gap-1">
                                        <div class="cart-indicator hidden bg-primary text-white rounded-full w-6 h-6 flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3">
                                    <div class="mb-1">
                                        <h3 class="text-base font-semibold text-gray-900 truncate">${product.name}</h3>
                                        <p class="text-xs text-gray-500">${product.category?.name || ''}</p>
                                    </div>

                                    <div class="flex flex-wrap justify-between items-center mt-2 gap-2">
                                        <div class="text-base font-bold text-primary">
                                            Rp${parseInt(product.harga_jual).toLocaleString('id-ID')}
                                        </div>
                                        <div class="flex items-center text-xs font-medium">
                                            <span class="py-1 px-3 rounded-lg font-semibold ${stockBadge}">
                                                Stok: ${product.stok}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    $('#product-list').append(card);
                });
            }
        });
    </script>

</x-kasir>
