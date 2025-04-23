<x-owner>
    <div class="p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Data Stock Produk
                </h1>
                <p class="text-sm text-gray-500 mt-1">Manajemen stok produk dan penyesuaian</p>
            </div>
        </div>

        <form method="GET" action="{{ route('owner.batches') }}" onsubmit="return validateDateRange();" 
            class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-8 bg-white p-4 rounded-lg shadow-sm border border-gray-100">

            <div class="relative w-full">
                <label for="category" class="block text-sm font-medium mb-2 text-gray-700">Kategori Produk</label>
                <select id="category" name="category_id"
                    class="w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg hover:border-primary transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="relative w-full">
                <label class="block text-sm font-medium mb-2 text-gray-700">Nama Produk</label>
                <div class="relative">
                    <input type="text" name="product_name"
                        class="w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg hover:border-primary transition-all"
                        value="{{ request('product_name') }}" placeholder="Cari produk...">
                </div>
            </div>
        
            <div class="relative w-full">
                <label class="block text-sm font-medium mb-2 text-gray-700">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date"
                    class="w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg hover:border-primary transition-all"
                    value="{{ request('start_date') }}">
            </div>
            
            <div class="relative w-full">
                <label class="block text-sm font-medium mb-2 text-gray-700">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date"
                    class="w-full py-2.5 px-4 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg hover:border-primary transition-all"
                    value="{{ request('end_date') }}">
            </div>
            
            <div class="flex items-end w-full">
                <button type="submit"
                    class="w-full py-2.5 px-4 text-sm bg-primary text-white  border border-primary rounded-lg hover:bg-white hover:text-primary flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
            </div>
        </form>
        
        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-100">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="p-4 font-medium">Batch ID</th>
                        <th class="p-4 font-medium">Produk</th>
                        <th class="p-4 font-medium">Qty Awal</th>
                        <th class="p-4 font-medium">Sisa Qty</th>
                        <th class="p-4 font-medium">Harga Modal</th>
                        <th class="p-4 font-medium">Expired</th>
                        <th class="p-4 font-medium">Dibuat</th>
                        <th class="p-4 font-medium">Diupdate</th>
                        <th class="p-4 font-medium">Oleh</th>
                        <th class="p-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($stocks as $stock)
                    @php
                        $latestAdjustment = $stock->stockAdjustments()->latest()->first();
                    @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">{{ $stock->id }}</td>
                            <td class="p-4 font-medium text-gray-900">{{ $stock->product->name }}</td>
                            <td class="p-4">{{ $stock->quantity }}</td>
                            <td class="p-4 font-medium {{ $stock->remaining_quantity < ($stock->quantity * 0.2) ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $stock->remaining_quantity }}
                            </td>
                            <td class="p-4">Rp{{ number_format($stock->harga_modal, 0, ',', '.') }}</td>
                            <td class="p-4">
                                @if($stock->expired_at)
                                    <span class="{{ $stock->expired_at < now() ? 'text-red-600' : ($stock->expired_at < now()->addDays(30) ? 'text-yellow-600' : 'text-gray-900') }}">
                                        {{ date('d-m-Y', strtotime($stock->expired_at)) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-4">{{ $stock->created_at->format('d-m-Y') }}</td>
                            <td class="p-4">{{ $latestAdjustment?->created_at?->format('d-m-Y') ?? '-' }}</td>
                            <td class="p-4">{{ $latestAdjustment?->user?->name ?? '-' }}</td>
                            <td class="p-4">
                                <div class="flex justify-center gap-2">
                                    <button onclick="openModal('adjust-stock{{ $stock->id }}')" 
                                        class="px-3 py-1.5 bg-yellow-500 text-white border border-yellow-500 rounded-lg hover:bg-white hover:text-yellow-500 transition flex items-center text-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Adjust
                                    </button>
                                    <button onclick="openModal('lihat-adjust{{ $stock->id }}')" 
                                        class="px-3 py-1.5 bg-primary text-white border border-primary rounded-lg hover:bg-white hover:text-primary transition flex items-center text-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat
                                    </button>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="10" class="p-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <p>Tidak ada data stock ditemukan</p>
                                </div>
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        @foreach ($stocks as $stock)
            @include('owner.produk.adjustStock', ['stock' => $stock])
            @include('owner.produk.lihatAdjust')
        @endforeach
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

        function validateDateRange() {
            if (startDateInput.value && endDateInput.value && startDateInput.value > endDateInput.value) {
                alert('Tanggal akhir tidak boleh sebelum tanggal awal');
                return false;
            }
            return true;
        }
    </script>
</x-owner>