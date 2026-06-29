<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian - Toko Via</title>
    <style>
        @media print {
    .header, .bottom-nav, .bottom-nav-spacer,
    form, .summary-cards, .card-header button { display: none !important; }
    body { background: white; }
    .card { box-shadow: none; border: none; }
}
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f0f0; }
        .header {
            background: #333; color: white;
            padding: 12px 20px;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;
        }
        .header h1 { font-size: 18px; }
        .header-right { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-nav {
            background: #555; color: white;
            padding: 6px 12px; border: none;
            border-radius: 5px; cursor: pointer;
            font-size: 13px; text-decoration: none;
        }
        .btn-logout {
            background: #e91e63; color: white;
            padding: 6px 12px; border: none;
            border-radius: 5px; cursor: pointer; font-size: 13px;
        }
        .container { padding: 15px; }

        /* Summary Cards */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 15px;
        }
        .summary-card {
            background: white; border-radius: 10px;
            padding: 15px; text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .summary-card .icon { font-size: 30px; margin-bottom: 8px; }
        .summary-card .nilai { font-size: 20px; font-weight: bold; color: #e91e63; }
        .summary-card .label { font-size: 12px; color: #888; margin-top: 4px; }

        /* Tabel */
        .card {
            background: white; border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .card-header {
            background: #333; color: white;
            padding: 12px 15px; font-size: 15px; font-weight: bold;
        }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #555; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        tr:last-child td { border-bottom: none; }
        .kosong { text-align: center; padding: 40px; color: #888; }
        .total-row td { font-weight: bold; background: #fff3f7; color: #e91e63; }

        @media(max-width: 600px) {
            .summary-grid { grid-template-columns: repeat(2, 1fr); }
            table { font-size: 12px; }
            th, td { padding: 8px 6px; }
        }
    </style>
    <!-- PWA -->
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#e91e63">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="Tokovia">
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then(() => console.log('Service Worker registered'))
            .catch(err => console.log('SW error:', err));
    }
</script>
</head>
<body>

<div class="header">
    <h1>📊 Laporan Harian</h1>
    <div class="header-right">
    <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
        @csrf
        <button type="submit" class="btn-logout">Logout</button>
    </form>
</div>
</div>

<div class="container">

    <form method="GET" action="{{ route('admin.laporan') }}" style="margin-bottom:15px; display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
    <select name="hari" style="padding:8px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px;">
        <option value="">-- Hari --</option>
        @for($d = 1; $d <= 31; $d++)
            <option value="{{ $d }}" {{ request('hari') == $d ? 'selected' : '' }}>{{ $d }}</option>
        @endfor
    </select>
    <select name="bulan" style="padding:8px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px;">
        <option value="">-- Bulan --</option>
        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
            <option value="{{ $i + 1 }}" {{ request('bulan') == $i + 1 ? 'selected' : '' }}>{{ $bln }}</option>
        @endforeach
    </select>
    <select name="tahun" style="padding:8px 12px; border:1px solid #ddd; border-radius:8px; font-size:13px;">
        <option value="">-- Tahun --</option>
        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
    </select>
    <button type="submit" style="padding:8px 16px; background:#e91e63; color:white; border:none; border-radius:8px; font-size:13px; cursor:pointer;">🔍 Filter</button>
    <a href="{{ route('admin.laporan') }}" style="padding:8px 16px; background:#888; color:white; border-radius:8px; font-size:13px; text-decoration:none;">Reset</a>
</form>
<p style="margin-bottom:12px; color:#888; font-size:13px;">
    📅 Laporan tanggal: <strong>{{ date('d/m/Y') }}</strong>
</p>

    <!-- Summary -->
    <div class="summary-grid">
       <div class="summary-card">
    <div class="icon">💰</div>
    @php
        $keuntungan = $hari_ini->flatMap(fn($t) => $t->items)->sum(function($item) {
            return ($item->product->harga - $item->product->harga_asli) * $item->jumlah;
        });
    @endphp
    <div class="nilai" style="color:#4caf50;">Rp {{ number_format($keuntungan, 0, ',', '.') }}</div>
    <div class="label">Total Keuntungan</div>
</div>
        <div class="summary-card">
            <div class="icon">💰</div>
            <div class="nilai">Rp {{ number_format($total_hari_ini, 0, ',', '.') }}</div>
            <div class="label">Total Pendapatan</div>
        </div>
        <div class="summary-card">
            <div class="icon">📦</div>
            <div class="nilai">{{ $hari_ini->sum(fn($t) => $t->items->sum('jumlah')) }}</div>
            <div class="label">Total Item Terjual</div>
        </div>
        <div class="summary-card">
            <div class="label">Popular Item</div>
            <div class="icon">💵</div>
            <div class="nilai">
    @php
        $semuaItem = $hari_ini->flatMap(fn($t) => $t->items)
            ->groupBy('nama_produk')
            ->map(fn($g) => $g->sum('jumlah'))
            ->sortDesc()
            ->first();
        $namaItem = $hari_ini->flatMap(fn($t) => $t->items)
            ->groupBy('nama_produk')
            ->map(fn($g) => $g->sum('jumlah'))
            ->sortDesc()
            ->keys()
            ->first();
    @endphp
    {{ $semuaItem ?? 0 }}
</div>
<div class="label">{{ $namaItem ?? '-' }}</div>
        </div>
    </div>

    <!-- Tabel Transaksi Hari Ini -->
    <div class="card">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <span>📋 Detail Transaksi Hari Ini</span>
    <button onclick="window.print()" style="background:#e91e63; color:white; border:none; padding:6px 14px; border-radius:6px; cursor:pointer; font-size:13px;">
        🖨️ Print / Save PDF
    </button>
</div>
        @if($hari_ini->isEmpty())
            <div class="kosong">Belum ada transaksi hari ini</div>
        @else
        <table>
            <thead>
    <tr>
        <th>Nama Barang</th>
        <th>Waktu</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
        <th>Kasir</th>
    </tr>
</thead>
<tbody>
    @foreach($hari_ini as $trx)
        @foreach($trx->items as $item)
        <tr>
            <td>{{ $item->nama_produk }}</td>
            <td>{{ $trx->created_at->format('H:i') }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            <td>{{ $trx->kasir }}</td>
        </tr>
        @endforeach
    @endforeach
    <tr class="total-row">
        <td colspan="3">TOTAL HARI INI</td>
        <td>Rp {{ number_format($total_hari_ini, 0, ',', '.') }}</td>
        <td></td>
    </tr>
</tbody>
        </table>
        @endif
    </div>

</div>

@include('admin.partials.bottom-nav')
</body>
</html>