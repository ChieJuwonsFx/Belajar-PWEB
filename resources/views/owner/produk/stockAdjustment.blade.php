<x-owner>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Data Stock Produk</h1>
    
        <form method="GET" action="{{ route('owner.batches') }}" onsubmit="return validateDateRange();" 
            class="w-full grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 gap-4 mb-6">

            <div class="relative w-full">
                <label for="category" class="block text-sm font-medium mb-1 text-gray-700">Kategori Produk</label>
                <select id="category" name="category_id"
                    class="appearance-none w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-primary rounded-lg hover:bg-white focus:ring-1 focus:border-primary focus:ring-gray-100">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="relative w-full">
                <label class="block text-sm font-medium mb-1 text-gray-700">Nama Produk</label>
                <input type="text" name="product_name"
                    class="block w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-primary rounded-lg focus:ring-1 focus:outline-none focus:border-primary focus:ring-gray-100 pr-12"
                    value="{{ request('product_name') }}" placeholder="Cari produk...">
            </div>
        
            <div class="relative w-full">
                <label class="block text-sm font-medium mb-1 text-gray-700">Dari Tanggal</label>
                <div class="flex items-center gap-2">
                    <input type="date" name="start_date" id="start_date"
                        class="flex-1 py-2.5 px-4 text-sm text-gray-900 bg-white border border-primary rounded-lg focus:ring-1 focus:border-primary focus:ring-gray-100"
                        value="{{ request('start_date') }}">
                </div>
            </div>
            
            <div class="relative w-full">
                <label class="block text-sm font-medium mb-1 text-gray-700">Sampai Tanggal</label>
                <div class="flex items-center gap-2">
                    <input type="date" name="end_date" id="end_date"
                        class="flex-1 py-2.5 px-4 text-sm text-gray-900 bg-white border border-primary rounded-lg focus:ring-1 focus:border-primary focus:ring-gray-100"
                        value="{{ request('end_date') }}">
                </div>
            </div>
            
        
            <div class="flex items-end w-full">
                <button type="submit"
                    class="w-full py-2 px-4 text-md bg-primary text-white border border-primary font-medium rounded-lg hover:bg-white hover:text-primary transition duration-200">
                    Filter
                </button>
            </div>
        </form>
        
    
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full table-auto text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 whitespace-nowrap">Produk</th>
                        <th class="p-3 whitespace-nowrap">Qty Awal</th>
                        <th class="p-3 whitespace-nowrap">Sisa Qty</th>
                        <th class="p-3 whitespace-nowrap">Harga Modal</th>
                        <th class="p-3 whitespace-nowrap">Expired</th>
                        <th class="p-3 whitespace-nowrap">Dibuat Pada</th>
                        <th class="p-3 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($stocks as $stock)
                    <tr>
                        <td class="p-3">{{ $stock->product->name }}</td>
                        <td class="p-3">{{ $stock->quantity }}</td>
                        <td class="p-3">{{ $stock->remaining_quantity }}</td>
                        <td class="p-3">Rp{{ number_format($stock->harga_modal, 0, ',', '.') }}</td>
                        <td class="p-3">{{ $stock->expired_at ? date('d-m-Y', strtotime($stock->expired_at)) : '-' }}</td>
                        <td class="p-3">{{ $stock->created_at->format('d-m-Y') }}</td>
                        <td class="p-3 flex flex-wrap gap-2 justify-center">
                            <a href="{{ route('owner.batches.store', $stock->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">Adjust</a>
                            <button data-stock-id="{{ $stock->id }}" class="lihat-btn px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">Lihat</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-3 text-center text-gray-500">Tidak ada data stock ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        startDateInput.addEventListener('change', function () {
            endDateInput.min = this.value;
            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = '';
            }
        });
    </script>
</x-owner>
