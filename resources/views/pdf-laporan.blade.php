<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan Kas RT</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0F2A4A; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #0F2A4A; }
        .summary-box { background: #E8F1FB; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .summary-box p { margin: 5px 0; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #0F2A4A; color: white; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN KEUANGAN KAS RT</h2>
        <p>Dicetak pada: {{ date('d F Y') }}</p>
    </div>

    <div class="summary-box">
        <p>Total Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        <p>Total Pengeluaran: Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        <p style="font-size: 18px; color: #0EA882; margin-top: 10px;">SALDO AKHIR: Rp {{ number_format($totalKas, 0, ',', '.') }}</p>
    </div>

    <h3>Rincian Pemasukan Kas</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Masuk</th>
                <th>Nama Warga</th>
                <th>Periode Iuran</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $t->updated_at->format('d/m/Y') }}</td>
                <td>{{ $t->user ? $t->user->name : 'Warga Anonim' }}</td>
                <td>{{ $t->periode }}</td>
                <td class="text-right">Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>