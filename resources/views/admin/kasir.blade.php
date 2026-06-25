<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Toko Via</title>
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; background: #f0f0f0; }

    /* Header */
    .header {
        background: #333;
        color: white;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .header h1 { font-size: 16px; }
    .header-right { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
    .btn-nav {
        background: #555;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        text-decoration: none;
    }
    .btn-logout {
        background: #e91e63;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
    }

    /* Layout Desktop */
    .container {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 12px;
        padding: 12px;
        height: calc(100vh - 50px);
    }

    /* Layout Mobile */
    @media(max-width: 768px) {
        .container {
            grid-template-columns: 1fr;
            height: auto;
            padding: 8px;
        }
        .produk-grid {
            max-height: 280px !important;
            grid-template-columns: repeat(3, 1fr) !important;
        }
        .keranjang {
            max-height: none !important;
        }
    }

    @media(max-width: 400px) {
        .produk-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
    }

    /* Produk */
    .produk-section { display: flex; flex-direction: column; gap: 8px; }
    .search-box input {
        width: 100%;
        padding: 10px 15px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        outline: none;
    }
    .produk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 8px;
        overflow-y: auto;
        max-height: calc(100vh - 130px);
        padding-bottom: 10px;
    }
    .produk-card {
        background: white;
        border-radius: 10px;
        padding: 10px;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    .produk-card:hover, .produk-card:active { border-color: #e91e63; }
    .produk-card .emoji { font-size: 28px; text-align: center; margin-bottom: 6px; }
    .produk-card h3 { font-size: 12px; color: #333; margin-bottom: 3px; }
    .produk-card .harga { color: #e91e63; font-weight: bold; font-size: 12px; }
    .produk-card .stok { color: #888; font-size: 10px; }

    /* Keranjang */
    .keranjang {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    height: calc(100vh - 74px);
    position: sticky;
    top: 12px;
}

@media(max-width: 768px) {
    .keranjang {
        height: auto;
        position: relative;
        top: 0;
    }
    .keranjang-items {
        max-height: 250px;
    }
}
    }
    .keranjang-header {
        background: #333;
        color: white;
        padding: 10px 15px;
        font-weight: bold;
        font-size: 14px;
    }
    .keranjang-items {
    flex: 1;
    overflow-y: auto;
    padding: 8px;
    min-height: 100px;
}

.keranjang-footer {
    position: sticky;
    bottom: 0;
    background: white;
    border-top: 2px solid #eee;
    padding: 12px;
    z-index: 10;
    box-shadow: 0 -3px 10px rgba(0,0,0,0.08);
}
    .item-info { flex: 1; }
    .item-info h4 { font-size: 12px; color: #333; }
    .item-info p { font-size: 11px; color: #888; }
    .item-qty {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .qty-btn {
        width: 24px;
        height: 24px;
        border: none;
        border-radius: 50%;
        background: #e91e63;
        color: white;
        cursor: pointer;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .qty-num { font-weight: bold; font-size: 13px; min-width: 18px; text-align: center; }
    .item-subtotal { font-weight: bold; color: #e91e63; font-size: 12px; white-space: nowrap; }

    /* Footer Keranjang */
    .keranjang-footer { padding: 12px; border-top: 2px solid #eee; }
    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-size: 13px;
    }
    .total-row.besar {
        font-size: 16px;
        font-weight: bold;
        color: #e91e63;
    }
    .input-bayar {
        width: 100%;
        padding: 10px;
        border: 2px solid #e91e63;
        border-radius: 8px;
        font-size: 15px;
        margin: 8px 0;
        outline: none;
        text-align: right;
    }
    .kembalian-box {
        background: #f0faf0;
        border: 1px solid #4caf50;
        border-radius: 8px;
        padding: 7px 12px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-weight: bold;
        color: #2e7d32;
        font-size: 13px;
    }
    .btn-bayar {
        width: 100%;
        padding: 13px;
        background: linear-gradient(135deg, #e91e63, #ff5722);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
    }
    .btn-bayar:disabled { background: #ccc; cursor: not-allowed; }
    .btn-clear {
        width: 100%;
        padding: 7px;
        background: #f5f5f5;
        color: #888;
        border: none;
        border-radius: 8px;
        font-size: 12px;
        cursor: pointer;
        margin-top: 5px;
    }
    .kosong-keranjang {
        text-align: center;
        color: #ccc;
        padding: 30px 20px;
        font-size: 35px;
    }

    /* Modal Struk */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        padding: 15px;
    }
    .modal-overlay.show { display: flex; }
    .modal {
        background: white;
        border-radius: 15px;
        padding: 20px;
        width: 100%;
        max-width: 320px;
        max-height: 90vh;
        overflow-y: auto;
    }
    .struk { font-family: monospace; }
    .struk h2 { text-align: center; font-size: 16px; margin-bottom: 4px; }
    .struk .sub { text-align: center; font-size: 11px; color: #888; margin-bottom: 8px; }
    .struk hr { border: none; border-top: 1px dashed #ccc; margin: 8px 0; }
    .struk-item {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-bottom: 3px;
    }
    .struk-total {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        font-size: 14px;
    }
    .struk-footer { text-align: center; font-size: 11px; color: #888; margin-top: 8px; }
    .modal-buttons { display: flex; gap: 8px; margin-top: 12px; }
    .btn-print {
        flex: 1; padding: 10px;
        background: #e91e63; color: white;
        border: none; border-radius: 8px;
        cursor: pointer; font-size: 13px;
    }
    .btn-close-modal {
        flex: 1; padding: 10px;
        background: #f5f5f5; color: #333;
        border: none; border-radius: 8px;
        cursor: pointer; font-size: 13px;
    }
</style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h1>🧾 Kasir - Toko Via</h1>
    <div class="header-right">
        <a href="{{ route('admin.products.index') }}" class="btn-nav">📦 Produk</a>
        <a href="{{ route('admin.riwayat') }}" class="btn-nav">📋 Riwayat</a>
        <a href="{{ route('admin.laporan') }}" class="btn-nav">📊 Laporan</a>
        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</div>

<!-- Main -->
<div class="container">

    <!-- Kiri: Produk -->
    <div class="produk-section">
        <div class="search-box">
            <input type="text" placeholder="🔍 Cari produk..." onkeyup="filterProduk(this.value)">
        </div>
        <div class="produk-grid" id="produkGrid">
            @foreach($products as $product)
            <div class="produk-card" onclick="tambahKeKeranjang({{ $product->id }}, '{{ $product->nama }}', {{ $product->harga }}, {{ $product->stok }})"
                 data-nama="{{ strtolower($product->nama) }}">
                @if($product->gambar)
    <img src="{{ asset('storage/' . $product->gambar) }}" style="width:100%; height:80px; object-fit:cover; border-radius:8px;">
@else
    <div class="emoji">🍳</div>
@endif
                <h3>{{ $product->nama }}</h3>
                <div class="harga">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                <div class="stok">Stok: {{ $product->stok }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Kanan: Keranjang -->
    <div class="keranjang">
        <div class="keranjang-header">🛒 Keranjang Belanja</div>

        <div class="keranjang-items" id="keranjangItems">
            <div class="kosong-keranjang" id="kosongMsg">
                🛒<br><small>Pilih produk</small>
            </div>
        </div>

        <div class="keranjang-footer">
            <div class="total-row">
                <span>Jumlah Item:</span>
                <span id="jumlahItem">0</span>
            </div>
            <div class="total-row besar">
                <span>TOTAL:</span>
                <span id="totalHarga">Rp 0</span>
            </div>
            <input type="text" class="input-bayar" id="inputBayar"
                    placeholder="Uang bayar..." autocomplete="off">
            <div class="kembalian-box">
                <span>Kembalian:</span>
                <span id="kembalian">Rp 0</span>
            </div>
            <button class="btn-bayar" id="btnBayar" onclick="prosesBayar()" disabled>
                💳 BAYAR
            </button>
            <button class="btn-clear" onclick="clearKeranjang()">🗑️ Kosongkan</button>
        </div>
    </div>
</div>

<!-- Modal Struk -->
<div class="modal-overlay" id="modalStruk">
    <div class="modal">
        <div class="struk" id="strukContent">
            <h2>🛍️ TOKO VIA</h2>
            <div class="sub">Toko Alat Dapur</div>
            <hr>
            <div id="strukInfo"></div>
            <hr>
            <div id="strukItems"></div>
            <hr>
            <div id="strukTotal"></div>
            <div class="struk-footer">Terima kasih telah berbelanja!<br>Semoga puas dengan produk kami 😊</div>
        </div>
        <div class="modal-buttons">
            <button class="btn-print" onclick="cetakStruk()">🖨️ Cetak Struk</button>
            <button class="btn-close-modal" onclick="tutupModal()">✅ Selesai</button>
        </div>
    </div>
</div>

<script>
    let keranjang = [];
    document.getElementById('inputBayar').addEventListener('input', function () {
    let angkaBersih = this.value.replace(/\D/g, '');
    if (angkaBersih) {
        this.value = parseInt(angkaBersih).toLocaleString('id-ID');
    } else {
        this.value = '';
    }
    hitungKembalian();
});

    function tambahKeKeranjang(id, nama, harga, stok) {
        const existing = keranjang.find(i => i.id === id);
        if (existing) {
            if (existing.jumlah >= stok) {
                alert('Stok tidak mencukupi!');
                return;
            }
            existing.jumlah++;
        } else {
            keranjang.push({ id, nama, harga, jumlah: 1, stok });
        }
        renderKeranjang();
    }

    function renderKeranjang() {
        const container = document.getElementById('keranjangItems');
        const kosong = document.getElementById('kosongMsg');

        if (keranjang.length === 0) {
            container.innerHTML = '<div class="kosong-keranjang">🛒<br><small>Pilih produk</small></div>';
            document.getElementById('jumlahItem').textContent = '0';
            document.getElementById('totalHarga').textContent = 'Rp 0';
            document.getElementById('btnBayar').disabled = true;
            return;
        }

        let html = '';
        let total = 0;
        let jumlah = 0;

        keranjang.forEach((item, index) => {
            const subtotal = item.harga * item.jumlah;
            total += subtotal;
            jumlah += item.jumlah;
            html += `
                <div class="keranjang-item">
                    <div class="item-info">
                        <h4>${item.nama}</h4>
                        <p>Rp ${formatRupiah(item.harga)}</p>
                    </div>
                    <div class="item-qty">
                        <button class="qty-btn" onclick="kurangQty(${index})">−</button>
                        <span class="qty-num">${item.jumlah}</span>
                        <button class="qty-btn" onclick="tambahQty(${index})">+</button>
                    </div>
                    <div class="item-subtotal">Rp ${formatRupiah(subtotal)}</div>
                </div>`;
        });

        container.innerHTML = html;
        document.getElementById('jumlahItem').textContent = jumlah;
        document.getElementById('totalHarga').textContent = 'Rp ' + formatRupiah(total);
        document.getElementById('btnBayar').disabled = false;
        hitungKembalian();
    }

    function tambahQty(index) {
        if (keranjang[index].jumlah >= keranjang[index].stok) {
            alert('Stok tidak mencukupi!');
            return;
        }
        keranjang[index].jumlah++;
        renderKeranjang();
    }

    function kurangQty(index) {
        if (keranjang[index].jumlah <= 1) {
            keranjang.splice(index, 1);
        } else {
            keranjang[index].jumlah--;
        }
        renderKeranjang();
    }

    function clearKeranjang() {
        keranjang = [];
        document.getElementById('inputBayar').value = '';
        document.getElementById('kembalian').textContent = 'Rp 0';
        renderKeranjang();
    }

    function hitungKembalian() {
    const total = keranjang.reduce((sum, i) => sum + (i.harga * i.jumlah), 0);
    const angkaBersih = document.getElementById('inputBayar').value.replace(/\D/g, '');
    const bayar = parseInt(angkaBersih) || 0;
    const kembalian = bayar - total;
    document.getElementById('kembalian').textContent = 'Rp ' + formatRupiah(kembalian >= 0 ? kembalian : 0);
}

    function prosesBayar() {
    const total = keranjang.reduce((sum, i) => sum + (i.harga * i.jumlah), 0);
    const angkaBersih = document.getElementById('inputBayar').value.replace(/\D/g, '');
    const bayar = parseInt(angkaBersih) || 0;

        if (bayar < total) {
            alert('Uang bayar kurang!');
            return;
        }

        fetch('{{ route("admin.kasir.proses") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                items: keranjang,
                bayar: bayar
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                tampilkanStruk(data);
                clearKeranjang();
            } else {
                alert(data.error);
            }
        });
    }

    function tampilkanStruk(data) {
        document.getElementById('strukInfo').innerHTML = `
            <div class="struk-item"><span>Kode:</span><span>${data.kode_transaksi}</span></div>
            <div class="struk-item"><span>Waktu:</span><span>${data.waktu}</span></div>
            <div class="struk-item"><span>Kasir:</span><span>${data.kasir}</span></div>
        `;

        let itemsHtml = '';
        data.items.forEach(item => {
            itemsHtml += `
                <div class="struk-item">
                    <span>${item.nama} x${item.jumlah}</span>
                    <span>Rp ${formatRupiah(item.harga * item.jumlah)}</span>
                </div>`;
        });
        document.getElementById('strukItems').innerHTML = itemsHtml;

        document.getElementById('strukTotal').innerHTML = `
            <div class="struk-total"><span>TOTAL</span><span>Rp ${formatRupiah(data.total)}</span></div>
            <div class="struk-item"><span>Bayar</span><span>Rp ${formatRupiah(data.bayar)}</span></div>
            <div class="struk-item"><span>Kembalian</span><span>Rp ${formatRupiah(data.kembalian)}</span></div>
        `;

        document.getElementById('modalStruk').classList.add('show');
    }

    function cetakStruk() {
        const struk = document.getElementById('strukContent').innerHTML;
        const win = window.open('', '_blank');
        win.document.write(`
            <html><head><title>Struk</title>
            <style>
                body { font-family: monospace; width: 300px; margin: 0 auto; }
                h2 { text-align: center; }
                .sub { text-align: center; font-size: 12px; color: #888; }
                hr { border: none; border-top: 1px dashed #ccc; margin: 8px 0; }
                .struk-item { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 3px; }
                .struk-total { display: flex; justify-content: space-between; font-weight: bold; font-size: 15px; }
                .struk-footer { text-align: center; font-size: 12px; margin-top: 10px; }
            </style>
            </head><body>${struk}</body></html>
        `);
        win.print();
    }

    function tutupModal() {
        document.getElementById('modalStruk').classList.remove('show');
    }

    function filterProduk(val) {
        const cards = document.querySelectorAll('.produk-card');
        cards.forEach(card => {
            card.style.display = card.dataset.nama.includes(val.toLowerCase()) ? 'block' : 'none';
        });
    }

    function formatRupiah(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
</script>

</body>
</html>