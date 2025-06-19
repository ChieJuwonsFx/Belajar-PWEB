<div id="printableReportContent" style="display: none;">
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 20px; }
        .report-header { text-align: center; margin-bottom: 20px; }
        .report-header h2 { margin: 0; font-size: 24px; color: #333; }
        .report-header p { margin: 5px 0; font-size: 14px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .summary-box {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #eee;
            background-color: #f9f9f9;
        }
        .summary-item {
            text-align: center;
            padding: 5px;
        }
        .summary-item .label {
            font-size: 12px;
            color: #555;
            margin-bottom: 5px;
        }
        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
    </style>

    <div class="report-header">
        <h2>Laporan Penjualan</h2>
        <p>Periode: <span id="printReportPeriod"></span></p>
    </div>

    <div class="summary-box">
        <div class="summary-item">
            <div class="label">Total Transaksi:</div>
            <div class="value" id="printTotalReportTransactions"></div>
        </div>
        <div class="summary-item">
            <div class="label">Total Penjualan:</div>
            <div class="value" id="printReportTotalSales"></div>
        </div>
        <div class="summary-item">
            <div class="label">Total Modal:</div>
            <div class="value" id="printReportTotalModal"></div>
        </div>
        <div class="summary-item">
            <div class="label">Total Keuntungan:</div>
            <div class="value" id="printReportTotalProfit"></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>ID Transaksi</th>
                <th>Admin/Kasir</th>
                <th class="text-right">Total Jual</th>
                <th class="text-right">Total Modal</th>
                <th class="text-right">Keuntungan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="printReportTableBody">
            {{-- otomatis js --}}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="font-bold text-right">TOTAL KESELURUHAN:</td>
                <td class="font-bold text-right" id="printReportTotalSalesFooter"></td>
                <td class="font-bold text-right" id="printReportTotalModalFooter"></td>
                <td class="font-bold text-right" id="printReportTotalProfitFooter"></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
