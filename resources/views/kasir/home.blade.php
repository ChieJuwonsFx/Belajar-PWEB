<x-kasir>
<div class="container w-full p-5 flex flex-col gap-10">
    <div>
        <h1 class="text-4xl text-bold">Dashboard</h1>
        <p>Grafik Pelayanan Anda 20 Hari Terakhir</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-5 w-full h-50 text-center">
        <div class="w-full lg:w-1/2 flex flex-col justify-center">
            <canvas id="profitChart" width="auto" height="auto"></canvas>
        </div>
    </div>

    <div class="w-full">
        <div>
            <h2 class="text-2xl font-semibold mb-3">Transaksi Terbaru Yang Dilayani</h2>
            <div class="bg-white p-4 rounded-lg shadow">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2">Total</th>
                            <th class="p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestTransactions as $transaction)
                            <tr class="border-b">
                                <td class="p-2">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, H:i') }}</td>
                                <td class="p-2">Rp {{ number_format($transaction->total_jual, 0, ',', '.') }}</td>
                                <td class="p-2">{{ $transaction->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center p-4">Tidak ada data transaksi.</td>
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

    const labels = chartData.map(data => data.date);
    const profits = chartData.map(data => data.profit);

    const ctx1 = document.getElementById('profitChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Valuasi Pelayanan',
                data: profits,
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

</script>
</x-kasir>