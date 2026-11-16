<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk Parkir — {{ $transaksi->kendaraan->plat_nomor }}</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f3f4f6;color:#111827;margin:0;padding:32px}.receipt{max-width:420px;margin:auto;background:white;padding:28px;border:1px solid #e5e7eb;border-radius:12px}.center{text-align:center}.muted{color:#6b7280;font-size:13px}.rule{border:0;border-top:1px dashed #9ca3af;margin:18px 0}.row{display:flex;justify-content:space-between;gap:16px;margin:11px 0;font-size:14px}.total{font-size:18px;font-weight:bold}.actions{max-width:420px;margin:16px auto;text-align:center}.button{display:inline-block;border:0;border-radius:6px;padding:10px 16px;background:#4f46e5;color:white;text-decoration:none;cursor:pointer;margin:0 4px}@media print{body{background:white;padding:0}.receipt{border:0;border-radius:0}.actions{display:none}}
    </style>
</head>
<body>
    <main class="receipt">
        <header class="center">
            <h1 style="margin:0 0 6px;letter-spacing:2px">ParkirBCM</h1>
            <p class="muted" style="margin:0">Bukti transaksi parkir</p>
        </header>
        <hr class="rule">
        <div class="row"><span>No. transaksi</span><strong>#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</strong></div>
        <div class="row"><span>Plat nomor</span><strong>{{ $transaksi->kendaraan->plat_nomor }}</strong></div>
        <div class="row"><span>Jenis kendaraan</span><span>{{ ucfirst($transaksi->kendaraan->jenis_kendaraan) }}</span></div>
        <div class="row"><span>Pemilik</span><span>{{ $transaksi->kendaraan->pemilik ?: '—' }}</span></div>
        <div class="row"><span>Area parkir</span><span>{{ $transaksi->area->nama_area }}</span></div>
        <hr class="rule">
        <div class="row"><span>Waktu masuk</span><span>{{ $transaksi->waktu_masuk->format('d/m/Y H:i') }}</span></div>
        <div class="row"><span>Waktu keluar</span><span>{{ $transaksi->waktu_keluar?->format('d/m/Y H:i') ?? 'Belum keluar' }}</span></div>
        <div class="row"><span>Durasi</span><span>{{ $transaksi->durasi_jam ? $transaksi->durasi_jam.' jam' : '—' }}</span></div>
        <div class="row"><span>Tarif per jam</span><span>Rp {{ number_format($transaksi->durasi_jam && $transaksi->biaya_total !== null ? $transaksi->biaya_total / $transaksi->durasi_jam : $transaksi->tarif->tarif_per_jam, 0, ',', '.') }}</span></div>
        <hr class="rule">
        <div class="row total"><span>Total bayar</span><span>{{ $transaksi->biaya_total !== null ? 'Rp '.number_format($transaksi->biaya_total, 0, ',', '.') : 'Belum dihitung' }}</span></div>
        <p class="center muted" style="margin:24px 0 0">Petugas: {{ $transaksi->user->nama_lengkap }}<br>Terima kasih telah menggunakan layanan parkir.</p>
    </main>
    <div class="actions"><button class="button" onclick="window.print()">Cetak struk</button><a class="button" href="{{ route('petugas.transaksi.index') }}">Kembali</a></div>
</body>
</html>
