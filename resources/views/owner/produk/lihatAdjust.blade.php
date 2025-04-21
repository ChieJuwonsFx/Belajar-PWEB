<div id="lihat-adjust{{ $stock->id }}" class="modal hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeModal('lihat-adjust{{ $stock->id }}')"></div>
    <div class="relative bg-white rounded-xl shadow-2xl max-w-4xl w-full mx-auto my-8 overflow-hidden">
        <div class="bg-primary p-6 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold flex items-center">
                        Riwayat Penyesuaian Stok
                    </h2>
                    <p class="text-blue-100 mt-1">Detail penyesuaian stok untuk produk {{ $stock->product->name }}</p>
                </div>
                <button type="button" class="text-white hover:text-blue-200 transition-colors" onclick="closeModal('lihat-adjust{{ $stock->id }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($stock->stockAdjustments as $adjustment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $adjustment->alasan == 'Rusak' ? 'bg-red-100 text-red-800' : 
                                       ($adjustment->alasan == 'Hilang' ? 'bg-yellow-100 text-yellow-800' :
                                       ($adjustment->alasan == 'Expired' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800')) }}">
                                    {{ $adjustment->alasan }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-red-600 font-semibold">
                                -{{ $adjustment->quantity }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 max-w-xs truncate">
                                {{ $adjustment->note ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $adjustment->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $adjustment->user->name }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg border border-primary">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-blue-100 text-primary mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Stok Awal</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $stock->quantity }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-card-warningBg p-4 rounded-lg border border-warning"> 
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-yellow- text-warning mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Penyesuaian</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $stock->stockAdjustments->where('quantity', '>', 0)->sum('quantity') }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-card-dangerBg p-4 rounded-lg border border-danger">
                    <div class="flex items-center">
                        <div class="p-2 rounded-full bg-red-100 text-danger mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kerugian</p>
                            <p class="text-lg font-semibold text-gray-900">
                                Rp{{ number_format($stock->stockAdjustments->where('alasan', '!=', 'Diretur')->sum(function ($adjustment) {
                                    return $adjustment->quantity * $adjustment->stock->harga_modal;
                                }), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="flex justify-end">
                <button onclick="closeModal('lihat-adjust{{ $stock->id }}')" class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors shadow-sm inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>