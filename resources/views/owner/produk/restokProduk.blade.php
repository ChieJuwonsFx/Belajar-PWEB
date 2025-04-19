<div id="restok-produk-{{ $product->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal('restok-produk-{{ $product->id }}')"></div>
    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Edit Produk</h2>
                    <p class="text-primary-100">Perbarui semua informasi produk di bawah ini</p>
                </div>
                <button type="button" class="text-white hover:text-primary-100 transition-colors" onclick="closeModal('restok-produk-{{ $product->id }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('owner.stok.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ $product->name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                            readonly>
                    </div>

                    <div>
                        <label for="harga_modal" class="block mb-2 text-sm font-medium text-gray-700">Harga Modal <span class="text-xs font-normal text-gray-700">(Isi harga modal produk untuk setiap unitnya.)</span></label>
                        <input type="number" name="harga_modal" id="harga_modal"  
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                            placeholder="20000" required>
                    </div>
                    <div>
                        <label for="quantity" class="block mb-2 text-sm font-medium text-gray-700">Quantity</label>
                        <p class="block mb-2 text-xs text-gray-700">Masukkan jumlah produk yang akan direstok.</p>
                        <input type="number" name="quantity" id="quantity" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                            placeholder="20" required>
                    </div>

                    @if (!$hasStockData = $product->stocks()->exists())
                        <div>
                            <label for="stok" class="block mb-2 text-sm font-medium text-gray-700">Stok Lama</label>
                            <p class="block mb-2 text-xs text-gray-700">Hitung stok lama sebelum melakukan restok agar data tetap akurat.</p>
                            <input type="number" name="stok" id="stok" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                                placeholder="20" required>
                        </div> 
                    @endif
                
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="text-white bg-primary border border-primary hover:bg-white hover:text-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                        <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>