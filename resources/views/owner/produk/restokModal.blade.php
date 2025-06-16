<div id="restok-produk" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal('restok-produk')"></div>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 sm:p-0">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden">
            <div class="bg-primary px-6 py-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold">Restok Produk</h2>
                        <p class="text-primary-100 text-sm">Tambah stok produk</p>
                    </div>
                    <button type="button" class="text-white hover:text-primary-200 transition-colors" onclick="closeModal('restok-produk')">
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
                    
                    <div class="space-y-4">
                        <div>
                            <label for="restock-product-name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                            <input type="text" id="restock-product-name" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-gray-50" readonly>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="harga_modal" class="block text-sm font-medium text-gray-700 mb-1">Harga Modal <span class="text-danger">*</span></label>
                                <div class="relative">
                                    <input type="number" name="harga_modal" id="harga_modal" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500" 
                                        placeholder="20.000" 
                                        min="0"
                                        step="1">
                                    <div id="harga_modal_error" class="mt-1 text-sm text-danger hidden"></div>
                                </div>
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="quantity" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500" 
                                    placeholder="20" 
                                    min="1"
                                    step="1">
                                <div id="quantity_error" class="mt-1 text-sm text-danger hidden"></div>
                            </div>

                            <div>
                                <label for="expired_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kadaluarsa</label>
                                <div class="relative">
                                    <input type="date" name="expired_at" id="expired_at" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                                    <div id="expired_at_error" class="mt-1 text-sm text-danger hidden"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('restok-produk')" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-600 focus:outline-none focus:ring-1 focus:ring-primary-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const today = new Date();
        const timezoneOffset = today.getTimezoneOffset() * 60000;
        const localDate = new Date(today - timezoneOffset).toISOString().split('T')[0];
        $('#expired_at').attr('min', localDate);
        
        // Validasi
        $('#restock-form').on('submit', function(e) {
            e.preventDefault();
            clearErrors();
            
            let isValid = true;
            
            // Validate harga_modal
            const hargaModal = $('#harga_modal');
            if (!hargaModal.val() || isNaN(hargaModal.val()) || parseFloat(hargaModal.val()) < 0) {
                showError('harga_modal', 'Harga modal wajib diisi dan tidak boleh negatif');
                isValid = false;
            }
            
            // Validate quantity
            const quantity = $('#quantity');
            if (!quantity.val() || isNaN(quantity.val()) || parseInt(quantity.val()) < 1) {
                showError('quantity', 'Jumlah stok minimal 1');
                isValid = false;
            }
            
            // Validate expired_at klo ada
            const expiredAt = $('#expired_at');
            if (expiredAt.val()) {
                const selectedDate = new Date(expiredAt.val());
                if (selectedDate < new Date(localDate)) {
                    showError('expired_at', 'Tanggal kadaluarsa tidak boleh sebelum hari ini');
                    isValid = false;
                }
            }
            
            if (isValid) {
                this.submit();
            }
        });
        
        function clearErrors() {
            $('[id$="_error"]').addClass('hidden');
            $('input').removeClass('border-danger');
        }
        
        function showError(fieldId, message) {
            $(`#${fieldId}_error`).text(message).removeClass('hidden');
            $(`#${fieldId}`).addClass('border-danger');
        }
        
        // Clear error pas ngetik
        $('input').on('input', function() {
            $(`#${this.id}_error`).addClass('hidden');
            $(this).removeClass('border-danger');
        });
    });
</script>