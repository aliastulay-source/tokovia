<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Via</title>
    @laravelPWA
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: #f8f8f8; }

        /* Header */
        .header {
            background: linear-gradient(135deg, #e91e63, #ff5722);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .header h1 { font-size: 22px; }
        .header-icons { display: flex; gap: 15px; font-size: 22px; cursor: pointer; }

        /* Banner */
        .banner {
            background: linear-gradient(135deg, #e91e63, #ff5722);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .banner h2 { font-size: 26px; margin-bottom: 8px; }
        .banner p { font-size: 14px; opacity: 0.9; }

        /* Search */
        .search-box {
            margin: 15px;
            position: relative;
        }
        .search-box input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            outline: none;
        }
        .search-box span {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        /* Kategori */
        .kategori {
            display: flex;
            gap: 10px;
            padding: 10px 15px;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .kategori::-webkit-scrollbar { display: none; }
        .kategori-btn {
            background: white;
            border: 2px solid #e91e63;
            color: #e91e63;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            white-space: nowrap;
        }
        .kategori-btn.active {
            background: #e91e63;
            color: white;
        }

        /* Produk Grid */
        .section-title {
            padding: 10px 15px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .produk-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 0 15px 80px;
        }
        @media(min-width: 600px) {
            .produk-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media(min-width: 900px) {
            .produk-grid { grid-template-columns: repeat(4, 1fr); }
        }

        .produk-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .produk-card:hover { transform: translateY(-3px); }

        .produk-img {
            width: 100%;
            height: 140px;
            background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
        }
        .produk-info { padding: 10px; }
        .produk-info h3 {
            font-size: 14px;
            color: #333;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .produk-info .harga {
            color: #e91e63;
            font-weight: bold;
            font-size: 15px;
        }
        .produk-info .stok {
            color: #888;
            font-size: 11px;
            margin: 3px 0 8px;
        }
        .btn-beli {
            width: 100%;
            padding: 8px;
            background: linear-gradient(135deg, #e91e63, #ff5722);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            font-weight: bold;
        }

        /* Bottom Nav */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            z-index: 100;
        }
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 11px;
            color: #888;
            cursor: pointer;
        }
        .nav-item.active { color: #e91e63; }
        .nav-item span:first-child { font-size: 22px; margin-bottom: 2px; }

        /* Kosong */
        .kosong {
            text-align: center;
            padding: 50px 20px;
            color: #888;
        }
        .kosong .icon { font-size: 60px; margin-bottom: 10px; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>🛍️ Toko Via</h1>
        <div class="header-icons">
            <span>🔔</span>
            <span>🛒</span>
        </div>
    </div>

    <!-- Banner -->
    <div class="banner">
        <h2>Selamat Datang! 👋</h2>
        <p>Temukan produk terbaik dengan harga terjangkau</p>
    </div>

    <!-- Search -->
    <div class="search-box">
        <span>🔍</span>
        <input type="text" placeholder="Cari produk..." id="searchInput" onkeyup="filterProduk()">
    </div>

    <!-- Kategori -->
    <div class="kategori">
        <button class="kategori-btn active">Semua</button>
        <button class="kategori-btn">Terbaru</button>
        <button class="kategori-btn">Termurah</button>
        <button class="kategori-btn">Terlaris</button>
    </div>

    <!-- Produk -->
    <div class="section-title">📦 Produk Kami</div>

    @if($products->isEmpty())
        <div class="kosong">
            <div class="icon">🛒</div>
            <p>Belum ada produk tersedia</p>
        </div>
    @else
        <div class="produk-grid" id="produkGrid">
            @foreach($products as $product)
            <div class="produk-card" data-nama="{{ strtolower($product->nama) }}">
                <div class="produk-img">🛍️</div>
                <div class="produk-info">
                    <h3>{{ $product->nama }}</h3>
                    <div class="harga">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                    <div class="stok">Stok: {{ $product->stok }}</div>
                    <button class="btn-beli">🛒 Beli</button>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- Bottom Nav -->
    <div class="bottom-nav">
        <div class="nav-item active">
            <span>🏠</span>
            <span>Beranda</span>
        </div>
        <div class="nav-item">
            <span>🔍</span>
            <span>Cari</span>
        </div>
        <div class="nav-item">
            <span>🛒</span>
            <span>Keranjang</span>
        </div>
        <div class="nav-item">
            <span>👤</span>
            <span>Akun</span>
        </div>
    </div>

    <script>
        function filterProduk() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.produk-card');
            cards.forEach(card => {
                const nama = card.getAttribute('data-nama');
                card.style.display = nama.includes(input) ? 'block' : 'none';
            });
        }
    </script>

</body>
</html>