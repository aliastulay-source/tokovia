<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: Arial, sans-serif; }
        .header {
            background: #212121;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { font-size: 18px; }
        .btn-logout {
            background: #e91e63;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .card {
            background: white;
            margin: 20px 15px;
            border-radius: 12px;
            border: 2px solid #e91e63;
            box-shadow: 0 4px 12px rgba(233,30,99,0.1);
            overflow: hidden;
        }
        .card-header {
            background: #e91e63;
            padding: 14px 20px;
        }
        .card-header h2 { color: white; font-size: 16px; margin: 0; }
        .card-body { padding: 20px; }
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: 13px;
            color: #555;
            margin-bottom: 6px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        .btn-simpan {
            width: 100%;
            padding: 12px;
            background: #e91e63;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            font-weight: bold;
        }
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
        }
        .alert-error {
            background: #ffebee;
            color: #c62828;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
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
    <h1>🔑 Ganti Password</h1>
    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn-logout">Logout</button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h2>🔒 Form Ganti Password Hapus Riwayat</h2>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">❌ {{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.simpan-password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="password_lama" placeholder="Masukkan password lama" required>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password_baru" placeholder="Masukkan password baru" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi" placeholder="Ulangi password baru" required>
            </div>
            <button type="submit" class="btn-simpan">Simpan Password</button>
        </form>

    </div>
</div>

@include('admin.partials.bottom-nav')
</body>
</html>