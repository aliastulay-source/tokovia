<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Toko Via</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-box h1 {
            text-align: center;
            color: #e91e63;
            margin-bottom: 5px;
        }
        .login-box p {
            text-align: center;
            color: #888;
            margin-bottom: 25px;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        .error {
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #e91e63;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-login:hover { background: #c2185b; }
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
    <div class="login-box">
        <h1>🔐 Login Admin</h1>
        <p>Toko Via - Panel Admin</p>

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="admin@tokovia.com" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>
</body>
</html>