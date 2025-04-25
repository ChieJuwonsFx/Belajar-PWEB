<x-kasir>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <div class="flex flex-col lg:flex-row items-center justify-between w-full gap-4 mb-6">
                <form method="GET" action="{{ route('kasir.transaksi') }}" class="w-full">
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
                                    class="block w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-0 focus:border-primary hover:border-primary pr-12"
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
    
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4" id="product-list">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md duration-300 overflow-hidden border border-gray-100 hover:border-blue-100 cursor-pointer product-card relative"
                         data-id="{{ $product->id }}"
                         data-name="{{ $product->name }}"
                         data-price="{{ $product->harga_jual }}"
                         data-cost="{{ $product->harga_modal }}"
                         data-category="{{ $product->category->name }}"
                         data-stock="{{ $product->stok }}">
                        <div class="relative h-40 overflow-hidden">
                            @if($image = json_decode($product->image, true)[0] ?? null)
                                <img src="{{ $image }}"
                                     class="w-full h-full object-cover transition-transform duration-300"
                                     alt="{{ $product->name }}"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 flex items-center gap-1">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $product->is_available == 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_available }}
                                </span>
                                <div class="cart-indicator hidden bg-primary text-white rounded-full w-6 h-6 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
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
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <div class="mb-4">
                <div class="relative">
                    <input type="search" name="customer" id="customer-search"
                    class="block w-full py-2.5 pl-4 pr-10 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg focus:ring-0 focus:border-primary hover:border-primary"
                    placeholder="Nama Customer (Opsional)">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="border rounded-lg overflow-hidden mb-4">
                <div class="hidden md:flex bg-gray-50 text-xs text-gray-700 uppercase p-3">
                    <div class="w-6/12 px-2">Produk</div>
                    <div class="w-2/12 px-2 text-right">Harga</div>
                    <div class="w-2/12 px-2 text-center">Qty</div>
                    <div class="w-2/12 px-2 text-right">Subtotal</div>
                </div>
                
                <div id="selected-products" class="divide-y divide-gray-200">
                    <div class="p-4 text-center text-gray-500 no-products">
                        Belum ada produk dipilih
                    </div>
                    
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium" id="subtotal">Rp0</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <div class="flex items-center">
                            <span class="text-gray-600 mr-2">Diskon:</span>
                            <button id="discount-toggle" class="text-primary hover:text-primary-dark flex items-center">
                                <span id="discount-label">Tambah Diskon</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                        <span class="font-medium" id="total-discount">Rp0</span>
                    </div>
                    
                    <div id="discount-input" class="hidden bg-white p-3 rounded-lg border border-gray-200 mt-2">
                        <div class="grid grid-cols-1 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Diskon</label>
                                <div class="relative">
                                    <input type="number" id="discount-amount" placeholder="0" 
                                           class="block w-full py-2 px-3 pr-16 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                                    <div class="absolute inset-y-0 right-0 flex items-center">
                                        <select id="discount-type" class="h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 focus:ring-0 focus:border-transparent text-sm rounded-r-md">
                                            <option value="fixed">Rp</option>
                                            <option value="percent">%</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between font-bold text-lg border-t pt-3">
                    <span>Total:</span>
                    <span id="total-amount">Rp0</span>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 gap-3">
                <button id="pay-now" class="w-full bg-primary hover:bg-primary-dark text-white py-2.5 px-4 rounded-lg font-medium transition duration-200">
                    Bayar Sekarang
                </button>
                <div class="grid grid-cols-2 gap-3">
                    <button id="hold-transaction" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2.5 px-4 rounded-lg font-medium transition duration-200">
                        Hold
                    </button>
                    <button id="cancel-transaction" class="bg-red-500 hover:bg-red-600 text-white py-2.5 px-4 rounded-lg font-medium transition duration-200">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <template id="product-row-template">
        <div class="product-row group" data-id="">
            <div class="flex flex-col md:flex-row items-start md:items-center p-3 hover:bg-gray-50">
                <div class="w-full md:w-6/12 px-2 flex items-center">
                    <button class="toggle-discount mr-2 text-gray-500 hover:text-primary">
                        <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div>
                        <div class="product-name font-medium text-gray-900"></div>
                        <div class="product-discount-display text-xs text-gray-500 mt-1 hidden">
                            Diskon: <span class="discount-amount"></span> <span class="discount-type"></span>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-2/12 px-2 mt-2 md:mt-0 text-right product-price"></div>
                <div class="w-full md:w-2/12 px-2 mt-2 md:mt-0">
                    <div class="flex items-center justify-center md:justify-start">
                        <button class="decrease-qty px-2 py-1 bg-gray-200 rounded-l-lg hover:bg-gray-300">
                            -
                        </button>
                        <input type="number" min="1" value="1" 
                               class="quantity-input w-12 text-center border-t border-b border-gray-300 py-1 focus:outline-none">
                        <button class="increase-qty px-2 py-1 bg-gray-200 rounded-r-lg hover:bg-gray-300">
                            +
                        </button>
                    </div>
                </div>
                <div class="w-full md:w-2/12 px-2 mt-2 md:mt-0 text-right product-subtotal font-medium"></div>
                <div class="w-full md:w-1/12 px-2 mt-2 md:mt-0 text-right">
                    <button class="remove-product text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="product-discount-container hidden bg-blue-50 px-3 py-2 border-t border-blue-100">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-3">
                    <div class="w-full md:w-6/12 px-2">
                        <span class="text-sm text-gray-600">Diskon Produk:</span>
                    </div>
                    <div class="w-full md:w-2/12 px-2">
                        <div class="relative">
                            <input type="number" class="item-discount-amount w-full py-2 px-3 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" placeholder="Jumlah" min="0">
                        </div>
                    </div>
                    <div class="w-full md:w-2/12 px-2">
                        <select class="item-discount-type w-full py-2 px-3 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                            <option value="fixed">Rp (Nominal)</option>
                            <option value="percent">% (Persen)</option>
                        </select>
                    </div>
                    <div class="w-full md:w-2/12 px-2 flex justify-end">
                        <button class="apply-discount bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md text-sm font-medium">
                            Terapkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <style>
        .product-card.selected {
            border: 2px solid #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1), 0 2px 4px -1px rgba(59, 130, 246, 0.06);
        }
        .cart-indicator {
            transition: all 0.3s ease;
        }
        .product-card.selected .cart-indicator {
            display: flex;
            animation: bounce 0.5s;
        }
        .toggle-discount.active svg {
            transform: rotate(180deg);
        }
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const discountToggle = document.getElementById('discount-toggle');
            const discountInput = document.getElementById('discount-input');
            
            discountToggle.addEventListener('click', function() {
                discountInput.classList.toggle('hidden');
                const isHidden = discountInput.classList.contains('hidden');
                document.getElementById('discount-label').textContent = isHidden ? 'Tambah Diskon' : 'Tutup Diskon';
            });
    
            let selectedProducts = [];
            let transactionDiscount = { amount: 0, type: 'fixed' };
    
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function() {
                    const productId = this.dataset.id;
                    const product = {
                        id: productId,
                        name: this.dataset.name,
                        price: parseFloat(this.dataset.price),
                        cost: parseFloat(this.dataset.cost),
                        category: this.dataset.category,
                        stock: parseInt(this.dataset.stock)
                    };
                    
                    const existingProduct = selectedProducts.find(p => p.id === productId);
                    
                    if (existingProduct) {
                        updateProductQuantity(productId, existingProduct.quantity + 1);
                        this.classList.add('selected');
                        setTimeout(() => {
                            this.classList.remove('selected');
                        }, 500);
                    } else {
                        addProductToTable(product);
                        this.classList.add('selected');
                        const cartIndicator = this.querySelector('.cart-indicator');
                        cartIndicator.classList.remove('hidden');
                    }
                });
            });
    
            function addProductToTable(product) {
                const container = document.getElementById('selected-products');
    
                const placeholder = container.querySelector('.no-products');
                if (placeholder) {
                    placeholder.remove();
                }
    
                const template = document.getElementById('product-row-template');
                const clone = template.content.cloneNode(true);
    
                const row = clone.querySelector('.product-row'); 
                if (!row) {
                    console.error("Template tidak memiliki elemen .product-row");
                    return;
                }
    
                row.setAttribute('data-id', product.id);
                row.querySelector('.product-name').textContent = product.name;
                row.querySelector('.product-price').textContent = formatCurrency(product.price);
                row.querySelector('.product-subtotal').textContent = formatCurrency(product.price);
    
                container.appendChild(clone);
    
                selectedProducts.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    cost: product.cost,
                    quantity: 1,
                    discount: { amount: 0, type: 'fixed' },
                    subtotal: product.price
                });
    
                setupProductRowEvents(row, product.id);
                updateTotals();
            }
    
            function setupProductRowEvents(row, productId) {
                const quantityInput = row.querySelector('.quantity-input');
                const decreaseBtn = row.querySelector('.decrease-qty');
                const increaseBtn = row.querySelector('.increase-qty');
                const removeBtn = row.querySelector('.remove-product');
                const toggleDiscountBtn = row.querySelector('.toggle-discount');
                const applyDiscountBtn = row.querySelector('.apply-discount');
                const discountContainer = row.querySelector('.product-discount-container');
                const discountAmountInput = row.querySelector('.item-discount-amount');
                const discountTypeSelect = row.querySelector('.item-discount-type');
                const discountDisplay = row.querySelector('.product-discount-display');
    
                quantityInput.addEventListener('change', function () {
                    updateProductQuantity(productId, parseInt(this.value));
                });
    
                decreaseBtn.addEventListener('click', function () {
                    const currentQty = parseInt(quantityInput.value);
                    if (currentQty > 1) {
                        quantityInput.value = currentQty - 1;
                        updateProductQuantity(productId, currentQty - 1);
                    }
                });
    
                increaseBtn.addEventListener('click', function () {
                    const currentQty = parseInt(quantityInput.value);
                    quantityInput.value = currentQty + 1;
                    updateProductQuantity(productId, currentQty + 1);
                });
    
                removeBtn.addEventListener('click', function () {
                    removeProduct(productId);
                });
    
                toggleDiscountBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    discountContainer.classList.toggle('hidden');
                    this.classList.toggle('active');
                });
    
                applyDiscountBtn.addEventListener('click', function () {
                    const discountAmount = parseFloat(discountAmountInput.value) || 0;
                    const discountType = discountTypeSelect.value;
                    updateProductDiscount(productId, discountAmount, discountType);
                    discountContainer.classList.add('hidden');
                    toggleDiscountBtn.classList.remove('active');
    
                    if (discountAmount > 0) {
                        discountDisplay.classList.remove('hidden');
                        discountDisplay.querySelector('.discount-amount').textContent = discountAmount;
                        discountDisplay.querySelector('.discount-type').textContent = discountType === 'fixed' ? 'Rp' : '%';
                    } else {
                        discountDisplay.classList.add('hidden');
                    }
                });
            }
    
            function updateProductQuantity(productId, newQuantity) {
                const product = selectedProducts.find(p => p.id === productId);
                if (product) {
                    product.quantity = newQuantity;
                    product.subtotal = calculateSubtotal(product);
                    updateRow(productId);
                    updateTotals();
    
                    const row = document.querySelector(`.product-row[data-id="${productId}"]`);
                    if (row) {
                        row.querySelector('.quantity-input').value = newQuantity;
                    }
                }
            }
    
            function updateProductDiscount(productId, amount, type) {
                const product = selectedProducts.find(p => p.id === productId);
                if (product) {
                    product.discount = { amount, type };
                    product.subtotal = calculateSubtotal(product);
                    updateRow(productId);
                    updateTotals();
                }
            }
    
            function calculateSubtotal(product) {
                let subtotal = product.price * product.quantity; 
                
                if (product.discount.amount > 0) {
                    if (product.discount.type === 'fixed') {
                        subtotal -= product.discount.amount;
                    } else if (product.discount.type === 'percent') {
                        subtotal -= (subtotal * (product.discount.amount / 100));
                    }
                }
    
                return Math.max(0, subtotal);
            }
    
            function updateRow(productId) {
                const product = selectedProducts.find(p => p.id === productId);
                if (!product) return;
                
                const row = document.querySelector(`.product-row[data-id="${productId}"]`);
                if (row) {
                    row.querySelector('.product-subtotal').textContent = formatCurrency(product.subtotal);
                    
                    if (product.discount.amount > 0) {
                        row.querySelector('.item-discount-amount').value = product.discount.amount;
                        row.querySelector('.item-discount-type').value = product.discount.type;
                        
                        const discountDisplay = row.querySelector('.product-discount-display');
                        discountDisplay.classList.remove('hidden');
                        discountDisplay.querySelector('.discount-amount').textContent = product.discount.amount;
                        discountDisplay.querySelector('.discount-type').textContent = product.discount.type === 'fixed' ? 'Rp' : '%';
                    }
                }
            }
    
            function removeProduct(productId) {
                selectedProducts = selectedProducts.filter(p => p.id !== productId);
                const row = document.querySelector(`.product-row[data-id="${productId}"]`);
                if (row) {
                    row.remove();
                }
                
                const productCard = document.querySelector(`.product-card[data-id="${productId}"]`);
                if (productCard) {
                    productCard.classList.remove('selected');
                    productCard.querySelector('.cart-indicator').classList.add('hidden');
                }
                
                const container = document.getElementById('selected-products');
                if (container.children.length === 0) {
                    container.innerHTML = `
                        <div class="p-4 text-center text-gray-500 no-products">
                            Belum ada produk dipilih
                        </div>
                    `;
                }
                
                updateTotals();
            }
    
            function updateTotals() {
                const subtotal = selectedProducts.reduce((sum, product) => sum + (product.price * product.quantity), 0);
                const totalDiscount = selectedProducts.reduce((sum, product) => {
                    if (product.discount.amount > 0) {
                        if (product.discount.type === 'fixed') {
                            return sum + product.discount.amount;
                        } else if (product.discount.type === 'percent') {
                            return sum + (product.price * (product.discount.amount / 100) * product.quantity);
                        }
                    }
                    return sum;
                }, 0);
                
                let transactionDiscAmount = 0;
                if (transactionDiscount.amount > 0) {
                    if (transactionDiscount.type === 'fixed') {
                        transactionDiscAmount = transactionDiscount.amount;
                    } else if (transactionDiscount.type === 'percent') {
                        transactionDiscAmount = (subtotal - totalDiscount) * (transactionDiscount.amount / 100);
                    }
                }
                
                const total = Math.max(0, subtotal - totalDiscount - transactionDiscAmount);
                
                document.getElementById('subtotal').textContent = formatCurrency(subtotal);
                document.getElementById('total-discount').textContent = formatCurrency(totalDiscount + transactionDiscAmount);
                document.getElementById('total-amount').textContent = formatCurrency(total);
            }
    
            function formatCurrency(amount) {
                return 'Rp' + amount.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.');
            }
    
            const discountAmountInput = document.getElementById('discount-amount');
            const discountTypeSelect = document.getElementById('discount-type');
    
            discountAmountInput.addEventListener('change', function() {
                transactionDiscount.amount = parseFloat(this.value) || 0;
                transactionDiscount.type = discountTypeSelect.value;
                updateTotals();
            });
    
            discountTypeSelect.addEventListener('change', function() {
                transactionDiscount.type = this.value;
                updateTotals();
            });
    
            document.getElementById('pay-now').addEventListener('click', function() {
                if (selectedProducts.length === 0) {
                    alert('Tidak ada produk yang dipilih');
                    return;
                }
                alert('Fungsi pembayaran akan diimplementasikan disini');
            });
    
            document.getElementById('hold-transaction').addEventListener('click', function() {
                if (selectedProducts.length === 0) {
                    alert('Tidak ada produk yang dipilih');
                    return;
                }
                alert('Fungsi hold transaksi akan diimplementasikan disini');
            });
    
            document.getElementById('cancel-transaction').addEventListener('click', function() {
                if (selectedProducts.length === 0) {
                    alert('Tidak ada produk yang dipilih');
                    return;
                }
    
                selectedProducts = [];
                
                const rows = document.querySelectorAll('.product-row');
                rows.forEach(row => row.remove());
    
                const productCards = document.querySelectorAll('.product-card');
                productCards.forEach(card => {
                    card.classList.remove('selected');
                    const cartIndicator = card.querySelector('.cart-indicator');
                    if (cartIndicator) {
                        cartIndicator.classList.add('hidden');
                    }
                });
    
                const container = document.getElementById('selected-products');
                container.innerHTML = `
                    <div class="p-4 text-center text-gray-500 no-products">
                        Belum ada produk dipilih
                    </div>
                `;
    
                updateTotals();
    
                alert('Transaksi dibatalkan');
            });
        });
    </script>
    
    {{-- <style>
        .product-card.selected {
            border: 2px solid #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1), 0 2px 4px -1px rgba(59, 130, 246, 0.06);
        }
        .cart-indicator {
            transition: all 0.3s ease;
        }
        .product-card.selected .cart-indicator {
            display: flex;
            animation: bounce 0.5s;
        }
        .toggle-discount.active svg {
            transform: rotate(180deg);
        }
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const discountToggle = document.getElementById('discount-toggle');
            const discountInput = document.getElementById('discount-input');
            
            discountToggle.addEventListener('click', function() {
                discountInput.classList.toggle('hidden');
                const isHidden = discountInput.classList.contains('hidden');
                document.getElementById('discount-label').textContent = isHidden ? 'Tambah Diskon' : 'Tutup Diskon';
            });
            
            let selectedProducts = [];
            let transactionDiscount = { amount: 0, type: 'fixed' };
            
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function() {
                    const productId = this.dataset.id;
                    const product = {
                        id: productId,
                        name: this.dataset.name,
                        price: parseFloat(this.dataset.price),
                        cost: parseFloat(this.dataset.cost),
                        category: this.dataset.category,
                        stock: parseInt(this.dataset.stock)
                    };
                    
                    const existingProduct = selectedProducts.find(p => p.id === productId);
                    
                    if (existingProduct) {
                        updateProductQuantity(productId, existingProduct.quantity + 1);
                        this.classList.add('selected');
                        setTimeout(() => {
                            this.classList.remove('selected');
                        }, 500);
                    } else {
                        addProductToTable(product);
                        this.classList.add('selected');
                        const cartIndicator = this.querySelector('.cart-indicator');
                        cartIndicator.classList.remove('hidden');
                    }
                });
            });
        
            function addProductToTable(product) {
                const container = document.getElementById('selected-products');
        
                const placeholder = container.querySelector('.no-products');
                if (placeholder) {
                    placeholder.remove();
                }
        
                const template = document.getElementById('product-row-template');
                const clone = template.content.cloneNode(true);
        
                const row = clone.querySelector('.product-row'); 
                if (!row) {
                    console.error("Template tidak memiliki elemen .product-row");
                    return;
                }
        
                row.setAttribute('data-id', product.id);
                row.querySelector('.product-name').textContent = product.name;
                row.querySelector('.product-price').textContent = formatCurrency(product.price);
                row.querySelector('.product-subtotal').textContent = formatCurrency(product.price);
        
                container.appendChild(clone);
        
                selectedProducts.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    cost: product.cost,
                    quantity: 1,
                    discount: { amount: 0, type: 'fixed' },
                    subtotal: product.price
                });
        
                setupProductRowEvents(row, product.id);
                updateTotals();
            }
        
            function setupProductRowEvents(row, productId) {
                const quantityInput = row.querySelector('.quantity-input');
                const decreaseBtn = row.querySelector('.decrease-qty');
                const increaseBtn = row.querySelector('.increase-qty');
                const removeBtn = row.querySelector('.remove-product');
                const toggleDiscountBtn = row.querySelector('.toggle-discount');
                const applyDiscountBtn = row.querySelector('.apply-discount');
                const discountContainer = row.querySelector('.product-discount-container');
                const discountAmountInput = row.querySelector('.item-discount-amount');
                const discountTypeSelect = row.querySelector('.item-discount-type');
                const discountDisplay = row.querySelector('.product-discount-display');
        
                quantityInput.addEventListener('change', function () {
                    updateProductQuantity(productId, parseInt(this.value));
                });
        
                decreaseBtn.addEventListener('click', function () {
                    const currentQty = parseInt(quantityInput.value);
                    if (currentQty > 1) {
                        quantityInput.value = currentQty - 1;
                        updateProductQuantity(productId, currentQty - 1);
                    }
                });
        
                increaseBtn.addEventListener('click', function () {
                    const currentQty = parseInt(quantityInput.value);
                    quantityInput.value = currentQty + 1;
                    updateProductQuantity(productId, currentQty + 1);
                });
        
                removeBtn.addEventListener('click', function () {
                    removeProduct(productId);
                });
        
                toggleDiscountBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    discountContainer.classList.toggle('hidden');
                    this.classList.toggle('active');
                });
        
                applyDiscountBtn.addEventListener('click', function () {
                    const discountAmount = parseFloat(discountAmountInput.value) || 0;
                    const discountType = discountTypeSelect.value;
                    updateProductDiscount(productId, discountAmount, discountType);
                    discountContainer.classList.add('hidden');
                    toggleDiscountBtn.classList.remove('active');
        
                    if (discountAmount > 0) {
                        discountDisplay.classList.remove('hidden');
                        discountDisplay.querySelector('.discount-amount').textContent = discountAmount;
                        discountDisplay.querySelector('.discount-type').textContent = discountType === 'fixed' ? 'Rp' : '%';
                    } else {
                        discountDisplay.classList.add('hidden');
                    }
                });
            }
        
            function updateProductQuantity(productId, newQuantity) {
                const product = selectedProducts.find(p => p.id === productId);
                if (product) {
                    product.quantity = newQuantity;
                    product.subtotal = calculateSubtotal(product);
                    updateRow(productId);
                    updateTotals();
                    
                    const row = document.querySelector(`.product-row[data-id="${productId}"]`);
                    if (row) {
                        row.querySelector('.quantity-input').value = newQuantity;
                    }
                }
            }
            
            function updateProductDiscount(productId, amount, type) {
                const product = selectedProducts.find(p => p.id === productId);
                if (product) {
                    product.discount = { amount, type };
                    product.subtotal = calculateSubtotal(product);
                    updateRow(productId);
                    updateTotals();
                }
            }
            
            function calculateSubtotal(product) {
                let subtotal = product.price * product.quantity; 
                
                if (product.discount.amount > 0) {
                    if (product.discount.type === 'fixed') {
                        subtotal -= product.discount.amount;
                    } else if (product.discount.type === 'percent') {
                        subtotal -= (subtotal * (product.discount.amount / 100));
                    }
                }

                return Math.max(0, subtotal);
            }

            
            function updateRow(productId) {
                const product = selectedProducts.find(p => p.id === productId);
                if (!product) return;
                
                const row = document.querySelector(`.product-row[data-id="${productId}"]`);
                if (row) {
                    row.querySelector('.product-subtotal').textContent = formatCurrency(product.subtotal);
                    
                    if (product.discount.amount > 0) {
                        row.querySelector('.item-discount-amount').value = product.discount.amount;
                        row.querySelector('.item-discount-type').value = product.discount.type;
                        
                        const discountDisplay = row.querySelector('.product-discount-display');
                        discountDisplay.classList.remove('hidden');
                        discountDisplay.querySelector('.discount-amount').textContent = product.discount.amount;
                        discountDisplay.querySelector('.discount-type').textContent = product.discount.type === 'fixed' ? 'Rp' : '%';
                    }
                }
            }
            
            function removeProduct(productId) {
                selectedProducts = selectedProducts.filter(p => p.id !== productId);
                const row = document.querySelector(`.product-row[data-id="${productId}"]`);
                if (row) {
                    row.remove();
                }
                
                const productCard = document.querySelector(`.product-card[data-id="${productId}"]`);
                if (productCard) {
                    productCard.classList.remove('selected');
                    productCard.querySelector('.cart-indicator').classList.add('hidden');
                }
                
                const container = document.getElementById('selected-products');
                if (container.children.length === 0) {
                    container.innerHTML = `
                        <div class="p-4 text-center text-gray-500 no-products">
                            Belum ada produk dipilih
                        </div>
                    `;
                }
                
                updateTotals();
            }
            
            function updateTotals() {
                const subtotal = selectedProducts.reduce((sum, product) => sum + (product.price * product.quantity), 0);
                const totalDiscount = selectedProducts.reduce((sum, product) => {
                    if (product.discount.amount > 0) {
                        if (product.discount.type === 'fixed') {
                            return sum + product.discount.amount;
                        } else if (product.discount.type === 'percent') {
                            return sum + (product.price * (product.discount.amount / 100) * product.quantity);
                        }
                    }
                    return sum;
                }, 0);
                
                let transactionDiscAmount = 0;
                if (transactionDiscount.amount > 0) {
                    if (transactionDiscount.type === 'fixed') {
                        transactionDiscAmount = transactionDiscount.amount;
                    } else if (transactionDiscount.type === 'percent') {
                        transactionDiscAmount = (subtotal - totalDiscount) * (transactionDiscount.amount / 100);
                    }
                }
                
                const total = Math.max(0, subtotal - totalDiscount - transactionDiscAmount);
                
                document.getElementById('subtotal').textContent = formatCurrency(subtotal);
                document.getElementById('total-discount').textContent = formatCurrency(totalDiscount + transactionDiscAmount);
                document.getElementById('total-amount').textContent = formatCurrency(total);
            }
            
            function formatCurrency(amount) {
                return 'Rp' + amount.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&.');
            }
            
            const discountAmountInput = document.getElementById('discount-amount');
            const discountTypeSelect = document.getElementById('discount-type');
            
            discountAmountInput.addEventListener('change', function() {
                transactionDiscount.amount = parseFloat(this.value) || 0;
                transactionDiscount.type = discountTypeSelect.value;
                updateTotals();
            });
            
            discountTypeSelect.addEventListener('change', function() {
                transactionDiscount.type = this.value;
                updateTotals();
            });
            
            document.getElementById('pay-now').addEventListener('click', function() {
                if (selectedProducts.length === 0) {
                    alert('Tidak ada produk yang dipilih');
                    return;
                }
                alert('Fungsi pembayaran akan diimplementasikan disini');
            });
            
            document.getElementById('hold-transaction').addEventListener('click', function() {
                if (selectedProducts.length === 0) {
                    alert('Tidak ada produk yang dipilih');
                    return;
                }
                alert('Fungsi hold transaksi akan diimplementasikan disini');
            });
            
            document.getElementById('cancel-transaction').addEventListener('click', function() {
                if (selectedProducts.length === 0) {
                    alert('Tidak ada produk yang dipilih');
                    return;
                }

                selectedProducts = [];
                
                const rows = document.querySelectorAll('.product-row');
                rows.forEach(row => row.remove());

                const productCards = document.querySelectorAll('.product-card');
                productCards.forEach(card => {
                    card.classList.remove('selected');
                    const cartIndicator = card.querySelector('.cart-indicator');
                    if (cartIndicator) {
                        cartIndicator.classList.add('hidden');
                    }
                });

                const container = document.getElementById('selected-products');
                container.innerHTML = `
                    <div class="p-4 text-center text-gray-500 no-products">
                        Belum ada produk dipilih
                    </div>
                `;

                updateTotals();

                alert('Transaksi dibatalkan');
            });
        });
    </script>     --}}
</x-kasir>