<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Toko Via</title>
    <style>
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
        .card {
            background: white; border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 12px; overflow: hidden;
        }
        .card-header {
            background: #f5f5f5; padding: 12px 15px;
            display: flex; justify-content: space-between;
            align-items: center; cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        .card-header h3 { font-size: 14px; color: #333; }
        .card-header .info { font-size: 13px; color: #888; }
        .card-header .total { color: #e91e63; font-weight: bold; font-size: 15px; }
        .card-body { padding: 12px 15px; display: none; }
        .card-body.show { display: block; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #333; color: white; padding: 8px; text-align: left; }
        td { padding: 8px; border-bottom: 1px solid #eee; }
        .badge {
            background: #e91e63; color: white;
            padding: 2px 8px; border-radius: 10px;
            font-size: 11px;
        }
        .kosong { text-align: center; padding: 40px; color: #888; font-size: 40px; }
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
    <h1>📋 Riwayat Transaksi</h1>
   <div class="header-right">
        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    @if($transaksis->isEmpty())
        <div class="kosong">📋<br><small>Belum ada transaksi</small></div>
    @else
        @foreach($transaksis as $trx)
        <div class="card">
            <div class="card-header" onclick="toggle('trx-{{ $trx->id }}')">
                <div>
                    <h3>{{ $trx->kode_transaksi }}</h3>
                    <div class="info">{{ $trx->created_at->format('d/m/Y H:i') }} • Kasir: {{ $trx->kasir }}</div>
                </div>
                <div style="text-align:right">
                    <div class="total">Rp {{ number_format($trx->total, 0, ',', '.') }}</div>
                    <span class="badge">{{ $trx->items->count() }} item</span>
                </div>
            </div>
            <div class="card-body" id="trx-{{ $trx->id }}">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trx->items as $item)
                        <tr>
                            <td>{{ $item->nama_produk }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top:10px; font-size:13px; color:#888;">
                    Bayar: Rp {{ number_format($trx->bayar, 0, ',', '.') }} |
                    Kembalian: Rp {{ number_format($trx->kembalian, 0, ',', '.') }}
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<script>
    function toggle(id) {
        const el = document.getElementById(id);
        el.classList.toggle('show');
    }
</script>

@include('admin.partials.bottom-nav')
</body>
</html>