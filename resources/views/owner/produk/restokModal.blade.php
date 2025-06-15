<div id="restok-produk" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal('restok-produk')"></div>
    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Restok Produk</h2>
                    <p class="text-primary-100">Tambah stok produk</p>
                </div>
                <button type="button" class="text-white hover:text-primary-100 transition-colors" onclick="closeModal('restok-produk')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form id="restock-form" action="{{ route('owner.stok.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="restock-product-id" name="product_id">
                
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="restock-product-name" class="block mb-2 text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" id="restock-product-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" readonly>
                    </div>

                    <div>
                        <label for="harga_modal" class="block mb-2 text-sm font-medium text-gray-700">Harga Modal</label>
                        <input type="number" name="harga_modal" id="harga_modal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="20000" required>
                    </div>
                    
                    <div>
                        <label for="quantity" class="block mb-2 text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="20" required>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="text-white bg-primary border border-primary hover:bg-white hover:text-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>