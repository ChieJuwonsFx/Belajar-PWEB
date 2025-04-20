<div id="adjust-stock{{ $stock->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal('adjust-stock{{ $stock->id }}')"></div>
    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold">Edit Produk</h2>
                    <p class="text-primary-100">Perbarui semua informasi produk di bawah ini</p>
                </div>
                <button type="button" class="text-white hover:text-primary-100 transition-colors" onclick="closeModal('adjust-stock{{ $stock->id }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('owner.batches.store', $stock->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="quantity" class="block mb-2 text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" name="quantity" id="quantity" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" 
                            required>
                    </div>
                    <div>
                        <label for="alasan" class="block mb-2 text-sm font-medium text-gray-700">Alasan</label>
                        <select id="alasan" name="alasan" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Pilih Kategori</option>
                            <option value="Rusak">Rusak</option>
                            <option value="Diretur">Diretur</option>
                            <option value="Hilang">Hilang</option>
                        </select>
                    </div>
                </div>
                <div class="my-4">
                    <label for="note" class="block mb-2 text-sm font-medium text-gray-700">Note</label>
                    <textarea name="note" id="note" rows="3"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                        required>
                    </textarea>
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