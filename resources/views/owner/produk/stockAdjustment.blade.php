<x-owner>
    <div class="p-6 space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Data Stock Produk
                </h1>
                <p class="text-sm text-gray-500 mt-1">Manajemen stok produk dan penyesuaian</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Stock
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <form method="GET" action="{{ route('owner.batches') }}" onsubmit="return validateDateRange();" 
            class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 bg-white p-5 rounded-xl shadow-sm border border-gray-200">
            
            <div class="space-y-1">
                <label for="category" class="block text-sm font-medium text-gray-700">Kategori Produk</label>
                <select id="category" name="category_id"
                    class="w-full py-2 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg hover:border-indigo-400 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                <input type="text" name="product_name"
                    class="w-full py-2 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg hover:border-indigo-400 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                    value="{{ request('product_name') }}" placeholder="Cari produk...">
            </div>
        
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date"
                    class="w-full py-2 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg hover:border-indigo-400 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                    value="{{ request('start_date') }}">
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date"
                    class="w-full py-2 px-3 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg hover:border-indigo-400 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                    value="{{ request('end_date') }}">
            </div>
            
            <div class="flex items-end">
                <button type="submit"
                    class="w-full h-[42px] text-sm bg-primary text-white border border-primary rounded-lg hover:bg-white hover:text-primary flex items-center justify-center transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
            </div>
        </form>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty Awal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Qty</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Modal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expired</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diupdate</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oleh</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($stocks as $stock)
                        @php
                            $latestAdjustment = $stock->stockAdjustments()->latest()->first();
                        @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stock->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stock->product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stock->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $stock->remaining_quantity < ($stock->quantity * 0.2) ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $stock->remaining_quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp{{ number_format($stock->harga_modal, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($stock->expired_at)
                                        <span class="{{ $stock->expired_at < now() ? 'text-red-600' : ($stock->expired_at < now()->addDays(30) ? 'text-yellow-600' : 'text-gray-900') }}">
                                            {{ date('d-m-Y', strtotime($stock->expired_at)) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stock->created_at->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $latestAdjustment?->created_at?->format('d-m-Y') ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-primary font-medium">
                                            {{ substr($latestAdjustment?->user?->name ?? '-', 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900">{{ $latestAdjustment?->user?->name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <div class="flex justify-center gap-2">
                                        <button onclick="openModal('adjust-stock{{ $stock->id }}')" 
                                            class="px-3 py-1.5 bg-amber-500 text-white border border-amber-500 rounded-lg hover:bg-white hover:text-amber-500 transition flex items-center text-xs">
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
                                <td colspan="10" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <p class="text-sm">Tidak ada data stock ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($stocks as $stock)
            @include('owner.produk.adjustStock', ['stock' => $stock])
            @include('owner.produk.lihatAdjust')
        @endforeach
    </div>
    
    <script>
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        const today = new Date().toISOString().split('T')[0];
        startDateInput.max = today;
        endDateInput.max = today;

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