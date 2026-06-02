<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Sirkulasi Barang</title>
    <style>
        body { font-family: sans-serif; padding: 40px; }
        h1 { text-align: center; margin-bottom: 5px; }
        p.subtitle { text-align: center; color: #666; margin-bottom: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { bg-color: #f8f9fa; font-weight: bold; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .success { background: #d1fae5; color: #065f46; }
        .warning { background: #ffedd5; color: #9a3412; }
    </style>
</head>
<body onload="window.print()">
    <h1>LAPORAN SIRKULASI BARANG</h1>
    <p class="subtitle">Sistem Peminjaman Inventaris Berbasis NFC - Per Tanggal: {{ date('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pinjam</th>
                <th>Nama Peminjam</th>
                <th>Barang</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($history as $index => $log)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($log->tgl_pinjam)->format('d/m/Y H:i') }}</td>
                <td>{{ $log->user->nama }}</td>
                <td>{{ $log->barang->nama_barang }}</td>
                <td>{{ $log->tgl_kembali ? \Carbon\Carbon::parse($log->tgl_kembali)->format('d/m/Y H:i') : '-' }}</td>
                <td>
                    <span class="status-badge {{ $log->tgl_kembali ? 'success' : 'warning' }}">
                        {{ $log->tgl_kembali ? 'SELESAI' : 'DIPINJAM' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 60px; text-align: right;">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <br><br><br>
        <p>( __________________________ )</p>
        <p>Administrator</p>
    </div>
</body>
</html>
