<x-owner>
<div class="container w-full p-5 flex flex-col gap-10">
    <div>
        <h1 class="text-4xl text-bold">Dashboard</h1>
        <p>Grafik Keuntungan Per Bulan</p>
    </div>

    <div class="flex gap-5 w-[80%] h-50 text-center">
        <div class="w-full flex flex-col justify-center">
            <h3>Keuntungan Ekspektasi</h3>
            <canvas id="expectedProfitChart" width="auto" height="auto"></canvas>
        </div>
        <div class="w-full flex flex-col justify-center">
            <h3>Keuntungan Sebenarnya</h3>
            <canvas id="actualProfitChart" width="auto" height="auto"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Tabel Transaksi Terbaru --}}
        <div>
            <h2 class="text-2xl font-semibold mb-3">Transaksi Terbaru</h2>
            <div class="bg-white p-4 rounded-lg shadow">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Tanggal</th>
                            {{-- <th class="p-2">Customer</th> --}}
                            <th class="p-2">Total</th>
                            <th class="p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestTransactions as $transaction)
                            <tr class="border-b">
                                <td class="p-2">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, H:i') }}</td>
                                {{-- <td class="p-2">{{ $transaction->user_name ?? $transaction->customer_offline }}</td> --}}
                                <td class="p-2">Rp {{ number_format($transaction->total_jual, 0, ',', '.') }}</td>
                                <td class="p-2">{{ $transaction->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-4">Tidak ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Tabel Kerugian Terbaru --}}
        <div>
            <h2 class="text-2xl font-semibold mb-3">Kerugian Terbaru</h2>
            <div class="bg-white p-4 rounded-lg shadow">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Produk</th>
                            <th class="p-2">Alasan</th>
                            <th class="p-2">Total Kerugian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestLosses as $loss)
                            <tr class="border-b">
                                <td class="p-2">{{ \Carbon\Carbon::parse($loss->created_at)->format('d M Y') }}</td>
                                <td class="p-2">{{ $loss->product_name }} ({{ $loss->quantity }} pcs)</td>
                                <td class="p-2">{{ $loss->alasan }}</td>
                                <td class="p-2 text-red-600">Rp {{ number_format($loss->quantity * $loss->harga_modal, 0, ',', '.') }}</td>
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
    const chartData = @json($chartData);

    const labels = chartData.map(data => `${data.month}`);
    const expectedProfits = chartData.map(data => data.expectedProfit);
    const actualProfits = chartData.map(data => data.actualProfit);

    // Grafik Keuntungan Ekspektasi
    const ctx1 = document.getElementById('expectedProfitChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Keuntungan Ekspektasi',
                data: expectedProfits,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });

    // Grafik Keuntungan Sebenarnya
    const ctx2 = document.getElementById('actualProfitChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Keuntungan Sebenarnya',
                data: actualProfits,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });

</script>
</x-owner>
