<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Toko Via</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header {
            background: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 { font-size: 20px; }
        .btn-logout {
    background: #e91e63;
    color: white;
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
        .btn-kasir {
        background: #555;
        color: white !important;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        display: inline-block;
        border: 2px solid white;
}
}
        }
        .alert {
            background: #d4edda;
            color: #155724;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
        }
        .form-section {
            background: white;
            margin: 15px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-section h2 { margin-bottom: 15px; color: #333; }
        .form-group { margin-bottom: 10px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-tambah {
            background: #e91e63;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .produk-section { margin: 15px; }
        .produk-section h2 { margin-bottom: 15px; color: #333; }
        table { width: 100%; background: white; border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-collapse: collapse; }
        th { background: #333; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .btn-hapus {
            background: #f44336;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
    <h1>⚙️ Admin - Toko Via</h1>
    <div style="display:flex; gap:8px; align-items:center;">
    <a href="{{ route('admin.kasir') }}" class="btn-kasir">🧾 Kasir</a>
    <form action="{{ route('admin.riwayat.hapus') }}" method="POST"
          onsubmit="return confirm('Yakin ingin menghapus semua riwayat transaksi? Data tidak bisa dikembalikan!')">
        @csrf
        @method('DELETE')
        <button type="submit" style="background:#f44336; color:white; padding:1px 4px; border:none; border-radius:5px; cursor:pointer; font-size:14px; font-weight:bold;">
            🗑️ Hapus Riwayat
        </button>
    </form>
    <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="form-section">
        <h2>➕ Tambah Produk</h2>
        <form action="{{ route('admin.products.store') }}" method="POST" id="formProduk" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama" placeholder="Contoh: Pisau" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                 <input type="text" id="harga_display" placeholder="Contoh: 50.000" autocomplete="off" required>
                <input type="hidden" name="harga" id="harga_value">
            </div>
            <div class="form-group">
                <div class="form-group">
                <label>Gambar Produk</label>
                <input type="file" name="gambar" accept="image/*" onchange="previewGambar(this)">
                    <img id="previewImg" src="" alt="" style="display:none; margin-top:8px; width:100%; max-height:200px; object-fit:contain; border-radius:8px; border:1px solid #ddd;">
            </div>
                <label>Stok</label>
                <input type="number" name="stok" required>
            </div>
            <button type="submit" class="btn-tambah">Simpan Produk</button>
        </form>
    </div>

    <div class="produk-section">
        <h2>📦 Daftar Produk</h2>
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
    @if($product->gambar)
        <img src="{{ asset('storage/' . $product->gambar) }}" style="width:50px; height:50px; object-fit:cover; border-radius:5px;">
    @else
        <span style="color:#ccc;">No image</span>
    @endif
</td>
<td>{{ $product->nama }}</td>
<td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
<td>{{ $product->stok }}</td>
                    <td>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:#888;">Belum ada produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
<script>
    function previewGambar(input) {
    const preview = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}
    const hargaDisplay = document.getElementById('harga_display');
    const hargaValue   = document.getElementById('harga_value');

    hargaDisplay.addEventListener('input', function () {
        let angkaBersih = this.value.replace(/\D/g, '');
        hargaValue.value = angkaBersih;
        if (angkaBersih) {
            this.value = parseInt(angkaBersih).toLocaleString('id-ID');
        } else {
            this.value = '';
        }
    });

    document.getElementById('formProduk').addEventListener('submit', function (e) {
        if (!hargaValue.value) {
            e.preventDefault();
            hargaDisplay.style.borderColor = '#e91e63';
            hargaDisplay.focus();
        }
    });

    hargaDisplay.addEventListener('focus', function () {
        this.style.borderColor = '#ddd';
    });
</script>
</body>
</html>