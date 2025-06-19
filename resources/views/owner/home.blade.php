<x-owner>
    <div class="container w-full p-5 flex flex-col gap-10">
        <div>
            <h1 class="text-4xl text-bold">Dashboard Owner</h1>
            <p>Ringkasan Kinerja Toko Anda</p>
        </div>

        {{-- Ringkasan Angka Penting Global (Tidak berubah) --}}
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
                <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Penjualan (Paid)</h3>
                <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
                <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Modal Penjualan (Paid)</h3>
                <p class="text-3xl font-bold text-red-600">Rp {{ number_format($totalCostOfSales, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
                <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Kerugian Stok</h3>
                <p class="text-3xl font-bold text-red-600">Rp {{ number_format($totalLostStockCost, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center justify-center text-center">
                <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Keuntungan Bersih</h3>
                <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($totalActualProfitOverall, 0, ',', '.') }}</p>
            </div>
        </div> --}}

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- Profit Hari Ini --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-500 mb-2">Profit Hari Ini</h3>
                <div class="flex justify-between items-baseline mb-1">
                    <p class="text-xl font-bold text-blue-600">Realita:</p>
                    <p class="text-xl font-bold text-blue-600">Rp {{ number_format($profitTodayActual, 0, ',', '.') }}</p>
                </div>
                <div class="flex justify-between items-baseline">
                    <p class="text-xl font-bold text-gray-500">Ekspektasi:</p>
                    <p class="text-xl font-bold text-gray-500">Rp {{ number_format($profitTodayExpected, 0, ',', '.') }}</p>
                </div>
            </div>
            {{-- Profit Minggu Ini --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-500 mb-2">Profit Minggu Ini</h3>
                <div class="flex justify-between items-baseline mb-1">
                    <p class="text-xl font-bold text-blue-600">Realita:</p>
                    <p class="text-xl font-bold text-blue-600">Rp {{ number_format($profitThisWeekActual, 0, ',', '.') }}</p>
                </div>
                <div class="flex justify-between items-baseline">
                    <p class="text-xl font-bold text-gray-500">Ekspektasi:</p>
                    <p class="text-xl font-bold text-gray-500">Rp {{ number_format($profitThisWeekExpected, 0, ',', '.') }}</p>
                </div>
            </div>
            {{-- Profit Bulan Ini --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-500 mb-2">Profit Bulan Ini</h3>
                <div class="flex justify-between items-baseline mb-1">
                    <p class="text-xl font-bold text-blue-600">Realita:</p>
                    <p class="text-xl font-bold text-blue-600">Rp {{ number_format($profitThisMonthActual, 0, ',', '.') }}</p>
                </div>
                <div class="flex justify-between items-baseline">
                    <p class="text-xl font-bold text-gray-500">Ekspektasi:</p>
                    <p class="text-xl font-bold text-gray-500">Rp {{ number_format($profitThisMonthExpected, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 w-full h-auto">
            {{-- Bulanan --}}
            <div class="w-full bg-white p-4 rounded-lg shadow flex flex-col justify-center items-center">
                <canvas id="actualProfitMonthChart" width="auto" height="300px"></canvas>
            </div>
            {{-- Mingguan --}}
            <div class="w-full bg-white p-4 rounded-lg shadow flex flex-col justify-center items-center">
                <canvas id="actualProfitWeekChart" width="auto" height="300px"></canvas>
            </div>
            {{-- Harian --}}
            <div class="w-full bg-white p-4 rounded-lg shadow flex flex-col justify-center items-center">
                <canvas id="actualProfitDayChart" width="auto" height="300px"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            {{-- Tabel Transaksi Terbaru (Tidak Berubah) --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">Transaksi Terbaru (Paid)</h2>
                <div class="bg-white p-4 rounded-lg shadow overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2">Tanggal</th>
                                <th class="p-2">Admin/Kasir</th>
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
            {{-- Tabel Kerugian Terbaru (Tidak Berubah) --}}
            <div>
                <h2 class="text-2xl font-semibold mb-3">Kerugian Stok Terbaru</h2>
                <div class="bg-white p-4 rounded-lg shadow overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2">Tanggal</th>
                                <th class="p-2">Produk (Qty)</th>
                                <th class="p-2">Alasan</th>
                                <th class="p-2">Nilai Kerugian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestLosses as $loss)
                                <tr class="border-b">
                                    <td class="p-2">{{ \Carbon\Carbon::parse($loss->created_at)->format('d M Y') }}</td>
                                    <td class="p-2">{{ $loss->product_name }} ({{ $loss->quantity }} pcs)</td>
                                    <td class="p-2">{{ $loss->alasan }}</td>
                                    <td class="p-2 text-red-600">Rp {{ number_format($loss->total_loss_value, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-4">Tidak ada data kerugian.</td>
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
        const chartDataMonthly = @json($chartData);
        const labelsMonthly = chartDataMonthly.map(data => `${data.month}`);
        const actualProfitsMonthly = chartDataMonthly.map(data => data.actualProfit);

        function createProfitChart(ctxId, chartLabel, labels, data, axisLabel, chartType = 'bar') {
            const ctx = document.getElementById(ctxId).getContext('2d');
            new Chart(ctx, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: chartLabel,
                        data: data,
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
                                text: axisLabel
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
        }

        // Grafik Keuntungan Sebenarnya (Bulanan)
        createProfitChart('actualProfitMonthChart', 'Keuntungan Sebenarnya (Net Profit)', labelsMonthly, actualProfitsMonthly, 'Bulan');

        const chartDataDailyRealita = @json($chartDataDailyRealita ?? []);
        const labelsDaily = chartDataDailyRealita.map(data => data.date);
        const actualProfitsDaily = chartDataDailyRealita.map(data => data.actualProfit);

        const chartDataWeeklyRealita = @json($chartDataWeeklyRealita ?? []);
        const labelsWeekly = chartDataWeeklyRealita.map(data => data.week);
        const actualProfitsWeekly = chartDataWeeklyRealita.map(data => data.actualProfit);

        // Grafik Keuntungan Sebenarnya (Mingguan)
        createProfitChart('actualProfitWeekChart', 'Keuntungan Sebenarnya (Net Profit)', labelsWeekly, actualProfitsWeekly, 'Minggu');

        // Grafik Keuntungan Sebenarnya (Harian)
        createProfitChart('actualProfitDayChart', 'Keuntungan Sebenarnya (Net Profit)', labelsDaily, actualProfitsDaily, 'Hari');
    </script>
</x-owner>
