<x-kasir>
<div class="container w-full p-5 flex flex-col gap-10">
    <div>
        <h1 class="text-4xl text-bold">Selamat Datang, {{ $kasirName }} !</h1>
        <p>Ringkasan Kinerja Penjualan Anda</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
            <h3 class="text-lg font-semibold text-gray-500 mb-2">Profit Hari Ini</h3>
            <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($profitTodayKasir, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
            <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Transaksi (Paid)</h3>
            <p class="text-3xl font-bold text-green-600">{{ number_format($totalTransactionsHandled, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
            <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Profit Bersih</h3>
            <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($totalProfitHandled - $totalLostStockByKasir, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-5 w-full h-auto text-center">
        <div class="w-full lg:w-1/2 bg-white p-4 rounded-lg shadow flex flex-col justify-center items-center">
            <canvas id="expectedProfitChartKasir" width="auto" height="200px"></canvas>
        </div>
        <div class="w-full lg:w-1/2 bg-white p-4 rounded-lg shadow flex flex-col justify-center items-center">
            <canvas id="actualProfitChartKasir" width="auto" height="200px"></canvas>
        </div>
    </div>

    <div class="w-full">
        <div>
            <h2 class="text-2xl font-semibold mb-3">Transaksi Terbaru Yang Dilayani (Paid)</h2>
            <div class="bg-white p-4 rounded-lg shadow overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Customer / Admin</th>
                            <th class="p-2">Total Jual</th>
                            <th class="p-2">Keuntungan</th>
                            <th class="p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestTransactions as $transaction)
                            <tr class="border-b">
                                <td class="p-2">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, H:i') }}</td>
                                <td class="p-2">{{ $transaction->user_name ?? 'Customer Offline' }}</td>
                                <td class="p-2">Rp {{ number_format($transaction->total_jual, 0, ',', '.') }}</td>
                                <td class="p-2 text-green-600">Rp {{ number_format($transaction->profit, 0, ',', '.') }}</td>
                                <td class="p-2">{{ $transaction->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-4">Tidak ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartDataDaily = @json($chartDataDaily);

    const labelsDaily = chartDataDaily.map(data => data.date);
    const expectedProfitsDaily = chartDataDaily.map(data => data.expectedProfit);
    const actualProfitsDaily = chartDataDaily.map(data => data.actualProfit);

    // Grafik Keuntungan Ekspektasi Kasir
    const ctxKasir1 = document.getElementById('expectedProfitChartKasir').getContext('2d');
    new Chart(ctxKasir1, {
        type: 'line',
        data: {
            labels: labelsDaily,
            datasets: [{
                label: 'Keuntungan Ekspektasi Harian',
                data: expectedProfitsDaily,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Keuntungan (Rp)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                            return label;
                        }
                    }
                }
            }
        },
    });

    // Grafik Keuntungan Sebenarnya Kasir
    const ctxKasir2 = document.getElementById('actualProfitChartKasir').getContext('2d');
    new Chart(ctxKasir2, {
        type: 'line',
        data: {
            labels: labelsDaily,
            datasets: [{
                label: 'Keuntungan Sebenarnya Harian',
                data: actualProfitsDaily,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Keuntungan (Rp)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                            return label;
                        }
                    }
                }
            }
        },
    });

</script>
</x-kasir>
