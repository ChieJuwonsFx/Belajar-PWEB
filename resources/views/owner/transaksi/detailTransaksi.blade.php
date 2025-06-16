<x-owner>
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
            <div class="flex space-x-2">
    <button onclick="window.history.back()" 
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md text-gray-700 transition">
        Kembali
    </button>
                @if($transaction->status === 'Pending')
                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-md text-white transition">
                        Proses Pembayaran
                    </button>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Informasi Transaksi</h3>
                    <div class="mt-2 space-y-3">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">ID Transaksi:</span> {{ $transaction->id }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Tanggal:</span> {{ $transaction->created_at->format('d M Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Tipe:</span> 
                            <span class="px-2 py-1 rounded-full text-xs 
                                {{ $transaction->transaction_type === 'Online' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ $transaction->transaction_type }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Status:</span> 
                            <span class="px-2 py-1 rounded-full text-xs 
                                {{ $transaction->status === 'Paid' ? 'bg-green-100 text-green-800' : 
                                   ($transaction->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $transaction->status }}
                            </span>
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Informasi Pelanggan</h3>
                    <div class="mt-2 space-y-1">
                        @if($transaction->transaction_type === 'Online' && $transaction->user)
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Nama:</span> {{ $transaction->user->name }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Email:</span> {{ $transaction->user->email }}
                            </p>
                        @elseif($transaction->transaction_type === 'Offline')
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Nama:</span> {{ $transaction->customer_offline ?? 'Pelanggan Umum' }}
                            </p>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Informasi Kasir</h3>
                    <div class="mt-2 space-y-1">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Nama:</span> {{ $transaction->admin->name }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Produk</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($transaction->transactionItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->stock->variant ?? 'Standard' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($item->harga_modal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200">
                <div class="flex justify-end">
                    <div class="w-full max-w-md space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Total Modal:</span>
                            <span class="text-sm text-gray-600">Rp {{ number_format($transaction->total_modal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Total Jual:</span>
                            <span class="text-sm text-gray-600">Rp {{ number_format($transaction->total_jual, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-600">Diskon:</span>
                            <span class="text-sm text-gray-600">Rp {{ number_format($transaction->total_diskon, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-200 pt-2">
                            <span class="text-base font-bold text-gray-800">Total Akhir:</span>
                            <span class="text-base font-bold text-gray-800">Rp {{ number_format($transaction->total_jual - $transaction->total_diskon, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-owner>