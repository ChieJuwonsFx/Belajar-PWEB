<x-owner>
    <div class="container w-full p-5 flex flex-col gap-10">
        <div>
            <h1 class="text-4xl text-bold">Dashboard Owner</h1>
            <p>Ringkasan Kinerja Toko Anda</p>
        </div>

        {{-- Ringkasan Profit Periode (Hari Ini, Minggu Ini, Bulan Ini) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- Profit Hari Ini --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-500 mb-2">Profit Hari Ini</h3>
                <div class="flex justify-between items-baseline mb-1">
                    <p class="text-xl font-bold text-blue-600">Realita:</p>
                    <p class="text-xl font-bold text-blue-600">Rp {{ number_format($profitTodayActual, 0, ',', '.') }}</p>
                </div>
                <div class="flex justify-between items-baseline">
                    <p class="text-xl font-bold text-gray-800">Ekspektasi:</p>
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($profitTodayExpected, 0, ',', '.') }}</p>
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
                    <p class="text-xl font-bold text-gray-800">Ekspektasi:</p>
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($profitThisWeekExpected, 0, ',', '.') }}</p>
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
                    <p class="text-xl font-bold text-gray-800">Ekspektasi:</p>
                    <p class="text-xl font-bold text-gray-800">Rp {{ number_format($profitThisMonthExpected, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Bagian Grafik Profit Realita --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 w-full h-auto">
            {{-- Grafik Keuntungan Sebenarnya (Bulanan) --}}
            <div class="w-full bg-white p-4 rounded-lg shadow flex flex-col justify-center items-center">
                <h3 class="text-xl font-semibold mb-3">Grafik Keuntungan Sebenarnya Per Bulan</h3>
                <canvas id="actualProfitMonthChart" width="auto" height="300px"></canvas>
            </div>
            {{-- Grafik Keuntungan Sebenarnya (Mingguan) --}}
            <div class="w-full bg-white p-4 rounded-lg shadow flex flex-col justify-center items-center">
                <h3 class="text-xl font-semibold mb-3">Grafik Keuntungan Sebenarnya Per Minggu</h3>
                <canvas id="actualProfitWeekChart" width="auto" height="300px"></canvas>
            </div>
            {{-- Grafik Keuntungan Sebenarnya (Harian) --}}
            <div class="w-full bg-white p-4 rounded-lg shadow flex flex-col justify-center items-center">
                <h3 class="text-xl font-semibold mb-3">Grafik Keuntungan Sebenarnya Per Hari</h3>
                <canvas id="actualProfitDayChart" width="auto" height="300px"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            {{-- Tabel Transaksi Terbaru --}}
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
            {{-- Tabel Kerugian Terbaru --}}
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

        {{-- Bagian Filter Laporan dan Tampilan Laporan --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Cetak Laporan Penjualan</h2>
            <form id="reportFilterForm" class="mb-4 flex flex-col md:flex-row gap-4 items-center">
                @csrf
                <div class="w-full md:w-1/3">
                    <label for="report_year" class="block text-sm font-medium text-gray-700">Pilih Tahun:</label>
                    <select id="report_year" name="year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $year == \Carbon\Carbon::now()->year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-1/3">
                    <label for="report_month" class="block text-sm font-medium text-gray-700">Pilih Bulan:</label>
                    <select id="report_month" name="month" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="all">Semua Bulan</option>
                        @foreach($availableMonths as $monthNum => $monthName)
                            <option value="{{ $monthNum }}" {{ $monthNum == \Carbon\Carbon::now()->month ? 'selected' : '' }}>{{ $monthName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-1/3 flex md:justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-dark focus:outline-none focus:border-primary focus:ring-primary disabled:opacity-25 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-2m3 2v-2m-12 1h12a2 2 0 002-2V4a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2zm1-9h10v2H4V9z"></path></svg>
                        Tampilkan Laporan
                    </button>
                </div>
            </form>

            <div id="reportOutput" class="mt-6 border p-4 rounded-md hidden">
                <h3 class="text-xl font-semibold mb-3">Laporan Penjualan <span id="reportPeriod"></span></h3>
                <div class="flex justify-between items-center mb-3">
                    <p class="text-sm text-gray-600">Total Transaksi: <span id="totalReportTransactions" class="font-bold"></span></p>
                    <button id="printReportBtn" class="inline-flex items-center px-3 py-1 bg-gray-200 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak
                    </button>
                </div>
                <div class="overflow-x-auto mb-4">
                    <table class="w-full text-sm text-left border-collapse" id="reportTable">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-2 border">Tanggal</th>
                                <th class="p-2 border">ID Transaksi</th>
                                <th class="p-2 border">Admin/Kasir</th>
                                <th class="p-2 border text-right">Total Jual</th>
                                <th class="p-2 border text-right">Total Modal</th>
                                <th class="p-2 border text-right">Keuntungan</th>
                                <th class="p-2 border">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data laporan akan di-load di sini oleh JavaScript --}}
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="3" class="p-2 border text-right">TOTAL KESELURUHAN:</td>
                                <td class="p-2 border text-right" id="reportTotalSales"></td>
                                <td class="p-2 border text-right" id="reportTotalModal"></td>
                                <td class="p-2 border text-right" id="reportTotalProfit"></td>
                                <td class="p-2 border"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        @include('owner.laporan')

    </div> {{-- Penutup untuk div.container --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data Bulanan
        const chartDataMonthly = @json($chartData);
        const labelsMonthly = chartDataMonthly.map(data => `${data.month}`);
        const actualProfitsMonthly = chartDataMonthly.map(data => data.actualProfit);

        // Data Harian
        const chartDataDailyRealita = @json($chartDataDailyRealita);
        const labelsDaily = chartDataDailyRealita.map(data => data.date);
        const actualProfitsDaily = chartDataDailyRealita.map(data => data.actualProfit);

        // Data Mingguan
        const chartDataWeeklyRealita = @json($chartDataWeeklyRealita);
        const labelsWeekly = chartDataWeeklyRealita.map(data => data.week);
        const actualProfitsWeekly = chartDataWeeklyRealita.map(data => data.actualProfit);


        // --- FUNGSI UNTUK MEMBUAT GRAFIK BARU ---
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
                    maintainAspectRatio: true, // Penting untuk mengontrol ukuran dengan CSS
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

        // --- Panggil Fungsi untuk Membuat Grafik ---
        createProfitChart('actualProfitMonthChart', 'Keuntungan Sebenarnya Per Bulan', labelsMonthly, actualProfitsMonthly, 'Bulan');
        createProfitChart('actualProfitWeekChart', 'Keuntungan Sebenarnya Per Minggu', labelsWeekly, actualProfitsWeekly, 'Minggu');
        createProfitChart('actualProfitDayChart', 'Keuntungan Sebenarnya Per Hari', labelsDaily, actualProfitsDaily, 'Hari');


        // --- Logika Filter Laporan dan Print ---
        const reportFilterForm = document.getElementById('reportFilterForm');
        const reportYearSelect = document.getElementById('report_year');
        const reportMonthSelect = document.getElementById('report_month');
        const reportOutputDiv = document.getElementById('reportOutput');
        const reportPeriodSpan = document.getElementById('reportPeriod');
        const reportTableBody = document.querySelector('#reportTable tbody');
        const totalReportTransactionsSpan = document.getElementById('totalReportTransactions');
        const reportTotalSalesSpan = document.getElementById('reportTotalSales');
        const reportTotalModalSpan = document.getElementById('reportTotalModal');
        const reportTotalProfitSpan = document.getElementById('reportTotalProfit');
        const printReportBtn = document.getElementById('printReportBtn');

        // Referensi elemen di Blade terpisah (sales_report_printable.blade.php)
        const printableReportContent = document.getElementById('printableReportContent');
        const printReportPeriodSpan = document.getElementById('printReportPeriod');
        const printTotalReportTransactionsSpan = document.getElementById('printTotalReportTransactions');
        const printReportTotalSalesSpan = document.getElementById('printReportTotalSales');
        const printReportTotalModalSpan = document.getElementById('printReportTotalModal');
        const printReportTotalProfitSpan = document.getElementById('printReportTotalProfit');
        const printReportTableBody = document.getElementById('printReportTableBody');
        const printReportTotalSalesFooter = document.getElementById('printReportTotalSalesFooter');
        const printReportTotalModalFooter = document.getElementById('printReportTotalModalFooter');
        const printReportTotalProfitFooter = document.getElementById('printReportTotalProfitFooter');


        // Fungsi untuk mengambil bulan yang tersedia berdasarkan tahun yang dipilih
        reportYearSelect.addEventListener('change', async function() {
            const selectedYear = this.value;
            reportMonthSelect.innerHTML = '<option value="all">Loading...</option>'; // Tampilkan loading
            try {
                const response = await fetch(`{{ route('owner.report.getMonths') }}?year=${selectedYear}`);
                const data = await response.json();
                reportMonthSelect.innerHTML = '<option value="all">Semua Bulan</option>'; // Reset option
                if (data.success) {
                    for (const monthNum in data.months) {
                        const option = document.createElement('option');
                        option.value = monthNum;
                        option.textContent = data.months[monthNum];
                        if (selectedYear == {{ \Carbon\Carbon::now()->year }} && monthNum == {{ \Carbon\Carbon::now()->month }}) {
                            option.selected = true; // Set bulan saat ini sebagai default jika tahunnya adalah tahun sekarang
                        }
                        reportMonthSelect.appendChild(option);
                    }
                } else {
                    console.error('Failed to load months:', data.message);
                }
            } catch (error) {
                console.error('Error fetching months:', error);
                reportMonthSelect.innerHTML = '<option value="all">Gagal memuat bulan</option>';
            }
        });

        // Event listener untuk submit form laporan
        reportFilterForm.addEventListener('submit', async function(event) {
            event.preventDefault(); // Mencegah form submit secara default

            const year = reportYearSelect.value;
            const month = reportMonthSelect.value;

            // Clear previous report data
            reportTableBody.innerHTML = '<tr><td colspan="7" class="text-center p-4">Memuat data...</td></tr>';
            printReportTableBody.innerHTML = '<tr><td colspan="7" class="text-center p-4">Memuat data...</td></tr>'; // Untuk print juga
            reportOutputDiv.classList.remove('hidden'); // Tampilkan div laporan

            try {
                const response = await fetch(`{{ route('owner.report.generate') }}?year=${year}&month=${month}`);
                const data = await response.json();

                reportTableBody.innerHTML = ''; // Clear loading message
                printReportTableBody.innerHTML = ''; // Clear loading message for print

                if (data.success && data.reportData.length > 0) {
                    let totalSales = 0;
                    let totalModal = 0;
                    let totalProfit = 0;

                    data.reportData.forEach(transaction => {
                        const row = `
                            <tr class="border-b">
                                <td class="p-2 border">${new Date(transaction.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })} ${new Date(transaction.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}</td>
                                <td class="p-2 border">${transaction.transaction_id}</td>
                                <td class="p-2 border">${transaction.admin_name ?? 'N/A'}</td>
                                <td class="p-2 border text-right">Rp ${transaction.total_jual.toLocaleString('id-ID')}</td>
                                <td class="p-2 border text-right">Rp ${transaction.total_modal.toLocaleString('id-ID')}</td>
                                <td class="p-2 border text-right">Rp ${transaction.profit.toLocaleString('id-ID')}</td>
                                <td class="p-2 border">${transaction.status}</td>
                            </tr>
                        `;
                        reportTableBody.insertAdjacentHTML('beforeend', row);
                        printReportTableBody.insertAdjacentHTML('beforeend', row); // Isi juga tabel cetak
                        totalSales += transaction.total_jual;
                        totalModal += transaction.total_modal;
                        totalProfit += transaction.profit;
                    });

                    // Update summary di tampilan dashboard
                    totalReportTransactionsSpan.textContent = data.reportData.length;
                    reportTotalSalesSpan.textContent = `Rp ${totalSales.toLocaleString('id-ID')}`;
                    reportTotalModalSpan.textContent = `Rp ${totalModal.toLocaleString('id-ID')}`;
                    reportTotalProfitSpan.textContent = `Rp ${totalProfit.toLocaleString('id-ID')}`;

                    // Update summary di konten cetak
                    printTotalReportTransactionsSpan.textContent = data.reportData.length;
                    printReportTotalSalesSpan.textContent = `Rp ${totalSales.toLocaleString('id-ID')}`;
                    printReportTotalModalSpan.textContent = `Rp ${totalModal.toLocaleString('id-ID')}`;
                    printReportTotalProfitSpan.textContent = `Rp ${totalProfit.toLocaleString('id-ID')}`;
                    printReportTotalSalesFooter.textContent = `Rp ${totalSales.toLocaleString('id-ID')}`;
                    printReportTotalModalFooter.textContent = `Rp ${totalModal.toLocaleString('id-ID')}`;
                    printReportTotalProfitFooter.textContent = `Rp ${totalProfit.toLocaleString('id-ID')}`;

                } else {
                    const noDataRow = '<tr><td colspan="7" class="text-center p-4">Tidak ada data laporan untuk periode ini.</td></tr>';
                    reportTableBody.innerHTML = noDataRow;
                    printReportTableBody.innerHTML = noDataRow; // Untuk print juga

                    totalReportTransactionsSpan.textContent = '0';
                    reportTotalSalesSpan.textContent = 'Rp 0';
                    reportTotalModalSpan.textContent = 'Rp 0';
                    reportTotalProfitSpan.textContent = 'Rp 0';

                    printTotalReportTransactionsSpan.textContent = '0';
                    printReportTotalSalesSpan.textContent = 'Rp 0';
                    printReportTotalModalSpan.textContent = 'Rp 0';
                    printReportTotalProfitSpan.textContent = 'Rp 0';
                    printReportTotalSalesFooter.textContent = 'Rp 0';
                    printReportTotalModalFooter.textContent = 'Rp 0';
                    printReportTotalProfitFooter.textContent = 'Rp 0';
                }

                // Update report period label
                const monthName = reportMonthSelect.options[reportMonthSelect.selectedIndex].text;
                reportPeriodSpan.textContent = `(${month === 'all' ? 'Tahun ' + year : monthName + ' ' + year})`;
                printReportPeriodSpan.textContent = `(${month === 'all' ? 'Tahun ' + year : monthName + ' ' + year})`; // Untuk print juga


            } catch (error) {
                console.error('Error generating report:', error);
                const errorRow = '<tr><td colspan="7" class="text-center p-4 text-red-500">Gagal memuat laporan.</td></tr>';
                reportTableBody.innerHTML = errorRow;
                printReportTableBody.innerHTML = errorRow; // Untuk print juga

                totalReportTransactionsSpan.textContent = '0';
                reportTotalSalesSpan.textContent = 'Rp 0';
                reportTotalModalSpan.textContent = 'Rp 0';
                reportTotalProfitSpan.textContent = 'Rp 0';

                printTotalReportTransactionsSpan.textContent = '0';
                printReportTotalSalesSpan.textContent = 'Rp 0';
                printReportTotalModalSpan.textContent = 'Rp 0';
                printReportTotalProfitSpan.textContent = 'Rp 0';
                printReportTotalSalesFooter.textContent = 'Rp 0';
                printReportTotalModalFooter.textContent = 'Rp 0';
                printReportTotalProfitFooter.textContent = 'Rp 0';
            }
        });

        // Event listener untuk tombol print
        printReportBtn.addEventListener('click', function() {
            let printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Laporan Penjualan</title>');
            // Sertakan styling yang sudah ada di sales_report_printable.blade.php
            printWindow.document.write(printableReportContent.querySelector('style').outerHTML);
            printWindow.document.write('</head><body>');
            // Hanya tulis konten dari div printableReportContent
            printWindow.document.write(printableReportContent.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });

        // Jalankan filter saat halaman dimuat untuk menampilkan laporan default
        reportFilterForm.dispatchEvent(new Event('submit'));
    </script>
</x-owner>
