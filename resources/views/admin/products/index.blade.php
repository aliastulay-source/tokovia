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
        .btn-logout { background: #e91e63; color: white; padding: 8px 15px; border: none; border-radius: 5px; cursor: pointer; }
        .btn-kasir { background: #555; color: white !important; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 14px; font-weight: bold; display: inline-block; border: 2px solid white; }
        .alert-success { background: #d4edda; color: #155724; padding: 10px 20px; margin: 10px; border-radius: 5px; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 10px 20px; margin: 10px; border-radius: 5px; }
        .form-section {
    background: white;
    margin: 15px;
    padding: 0;
    border-radius: 12px;
    border: 2px solid #e91e63;
    box-shadow: 0 4px 12px rgba(233,30,99,0.1);
    overflow: hidden;
}
.form-section-header {
    background: #e91e63;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: center; /* <-- TAMBAHKAN BARIS INI */
    gap: 8px;
}
.form-section-header h2 {
    color: white;
    font-size: 16px;
    margin: 0;
}
.form-section-body {
    padding: 20px;
}
        .form-group { margin-bottom: 10px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;
        }
        .form-group input.error { border-color: #e91e63; }
        .error-msg { color: #e91e63; font-size: 13px; margin-top: 4px; }
        .btn-tambah { background: #e91e63; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; width: 100%; }
        .produk-section { margin: 15px; }
        .produk-section h2 { margin-bottom: 15px; color: #333; }
        table { width: 100%; background: white; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-collapse: collapse; }
        th { background: #333; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .btn-hapus { background: #f44336; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
        .stok-form { display: flex; gap: 5px; align-items: center; }
        .stok-input { width: 70px; padding: 5px 8px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .btn-stok { background: #4caf50; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; font-size: 13px; white-space: nowrap; }
        .stok-badge { display: inline-block; background: #e91e63; color: white; padding: 2px 8px; border-radius: 10px; font-size: 13px; }

        /* Modal */
        .modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; justify-content:center; align-items:center; }
        .modal-overlay.active { display:flex; }
        .modal { background:white; border-radius:10px; padding:25px; width:320px; box-shadow: 0 5px 20px rgba(0,0,0,0.3); }
        .modal h3 { margin-bottom:15px; color:#333; }
        .modal input { width:100%; padding:10px; border:1px solid #ddd; border-radius:5px; font-size:15px; margin-bottom:15px; }
        .modal-btns { display:flex; gap:10px; }
        .btn-confirm { background:#4caf50; color:white; padding:10px; border:none; border-radius:5px; cursor:pointer; flex:1; font-size:15px; }
        .btn-cancel { background:#aaa; color:white; padding:10px; border:none; border-radius:5px; cursor:pointer; flex:1; font-size:15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1> Admin - Toko Via</h1>
        <div style="display:flex; gap:8px; align-items:center;">
            <a href="{{ route('admin.kasir') }}" class="btn-kasir">🧾 Kasir</a>
            <!-- Tombol trigger modal -->
<button onclick="document.getElementById('modalHapus').style.display='flex'"
    style="background:#f44336; color:white; padding:5px 10px; border:none; border-radius:5px; cursor:pointer; font-size:14px; font-weight:bold;">
    🗑️ Hapus Riwayat
</button>

<!-- Modal Password -->
<div id="modalHapus" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
    <div style="background:white; border-radius:12px; padding:24px; width:90%; max-width:360px; box-shadow:0 8px 24px rgba(0,0,0,0.2);">
        <h3 style="margin:0 0 8px; color:#f44336;">⚠️ Hapus Riwayat</h3>
        <p style="font-size:13px; color:#666; margin-bottom:16px;">Masukkan password untuk mengkonfirmasi penghapusan semua riwayat.</p>
        <input type="password" id="inputPassword" placeholder="Masukkan password"
            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; font-size:14px; margin-bottom:8px; box-sizing:border-box;">
        <div id="pesanError" style="color:#f44336; font-size:12px; margin-bottom:10px; display:none;">Password salah!</div>
        <div style="display:flex; gap:8px;">
            <button onclick="document.getElementById('modalHapus').style.display='none'"
                style="flex:1; padding:10px; border:1px solid #ddd; border-radius:8px; background:white; cursor:pointer;">
                Batal
            </button>
            <button onclick="cekPassword()"
                style="flex:1; padding:10px; background:#f44336; color:white; border:none; border-radius:8px; cursor:pointer;">
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- Form hapus (disubmit via JS) -->
<form id="formHapus" action="{{ route('admin.riwayat.hapus') }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
function cekPassword() {
    const input = document.getElementById('inputPassword').value;
    const password = '{{ \App\Models\Setting::get("hapus_password") }}';
    if (input === password) {
        document.getElementById('formHapus').submit();
    } else {
        document.getElementById('pesanError').style.display = 'block';
        document.getElementById('inputPassword').value = '';
    }
}
</script>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            ⚠️ {{ $errors->first() }}
        </div>
    @endif

    {{-- Form Tambah Produk --}}
    <div class="form-section">
    <div class="form-section-header">
        <h2> Tambah Produk</h2>
    </div>
    <div class="form-section-body">
    <form action="{{ route('admin.products.store') }}" method="POST" id="formProduk" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="nama" id="inputNama"
                       placeholder="Contoh: Pisau"
                       value="{{ old('nama') }}"
                       autocomplete="off"
                       required
                       class="{{ $errors->has('nama') ? 'error' : '' }}">
                @error('nama')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
                <div class="error-msg" id="namaWarning" style="display:none;">
                    ⚠️ Produk ini sudah ada! Gunakan fitur <strong>Tambah Stok</strong> di tabel bawah.
                </div>
            </div>
            <div class="form-group">
<div class="form-group">
    <label>Harga Asli</label>
    <input type="text" id="harga_asli_display" placeholder="Contoh: 10.000" required>
    <input type="hidden" name="harga_asli" id="harga_asli_value">
</div>
<div class="form-group">
    <label>Harga Jual</label>
    <input type="text" id="harga_jual_display" placeholder="Contoh: 15.000" required>
    <input type="hidden" name="harga" id="harga_jual_value">
</div>
            <div class="form-group">
                <label>Gambar Produk</label>
                <input type="file" name="gambar" accept="image/*" onchange="previewGambar(this)">
                <img id="previewImg" src="" alt="" style="display:none; margin-top:8px; width:100%; max-height:200px; object-fit:contain; border-radius:8px; border:1px solid #ddd;">
            </div>
            <button type="submit" class="btn-tambah" id="btnSimpan">Simpan Produk</button>
        </form>
    </div>

    {{-- Daftar Produk --}}
    <div class="produk-section">
        <h2>📦 Daftar Produk</h2>
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga Asli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Tambah Stok</th>
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
                        <td>Rp {{ number_format($product->harga_asli, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td><span class="stok-badge">{{ $product->stok }}</span></td>
                    <td>
                        <div class="stok-form">
                            <input type="number" class="stok-input" id="stok_{{ $product->id }}" min="1" placeholder="Jml">
                            <button type="button" class="btn-stok" onclick="openModal({{ $product->id }}, '{{ $product->nama }}')">
                                ➕ Tambah
                            </button>
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                              onsubmit="return confirm('Hapus produk {{ $product->nama }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#888;">Belum ada produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Konfirmasi Tambah Stok --}}
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <h3>➕ Tambah Stok</h3>
            <p id="modalDesc" style="margin-bottom:12px; color:#555;"></p>
            <form id="modalForm" method="POST">
                @csrf
                <input type="number" name="jumlah" id="modalJumlah" min="1" placeholder="Jumlah stok ditambah" required>
                <div class="modal-btns">
                    <button type="submit" class="btn-confirm">✅ Simpan</button>
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar nama produk yang sudah ada (untuk validasi real-time) --}}
    <script>
        const existingNames = @json($products->pluck('nama')->map(fn($n) => strtolower($n)));

        // Validasi nama real-time
        const inputNama = document.getElementById('inputNama');
        const namaWarning = document.getElementById('namaWarning');
        const btnSimpan = document.getElementById('btnSimpan');

        inputNama.addEventListener('input', function () {
            const val = this.value.trim().toLowerCase();
            if (val && existingNames.includes(val)) {
                namaWarning.style.display = 'block';
                this.classList.add('error');
                btnSimpan.disabled = true;
                btnSimpan.style.opacity = '0.5';
            } else {
                namaWarning.style.display = 'none';
                this.classList.remove('error');
                btnSimpan.disabled = false;
                btnSimpan.style.opacity = '1';
            }
        });

        // Preview gambar
        function previewGambar(input) {
            const preview = document.getElementById('previewImg');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = ''; preview.style.display = 'none';
            }
        }

        // Modal tambah stok
        function openModal(productId, productName) {
            const jumlah = document.getElementById('stok_' + productId).value;
            if (!jumlah || jumlah < 1) {
                alert('Masukkan jumlah stok terlebih dahulu!');
                document.getElementById('stok_' + productId).focus();
                return;
            }
            document.getElementById('modalDesc').textContent = 'Tambah stok untuk: ' + productName;
            document.getElementById('modalJumlah').value = jumlah;
            document.getElementById('modalForm').action = '/admin/products/' + productId + '/tambah-stok';
            document.getElementById('modalOverlay').classList.add('active');
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('active');
        }

        // Tutup modal jika klik di luar
        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // Format rupiah otomatis
function formatRupiah(input, hiddenId) {
    input.addEventListener('input', function () {
        let angka = this.value.replace(/\D/g, '');
        document.getElementById(hiddenId).value = angka;
        this.value = angka ? parseInt(angka).toLocaleString('id-ID') : '';
    });
}

formatRupiah(document.getElementById('harga_asli_display'), 'harga_asli_value');
formatRupiah(document.getElementById('harga_jual_display'), 'harga_jual_value');
    </script>
@include('admin.partials.bottom-nav')
</body>
</html>
