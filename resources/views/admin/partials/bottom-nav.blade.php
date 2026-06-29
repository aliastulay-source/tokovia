{{-- Bottom Navigation Bar --}}
@php
    $currentRoute = Route::currentRouteName();
@endphp

<style>
/* Bottom Nav */
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    border-top: 1px solid #e0e0e0;
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 60px;
    z-index: 999;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
}

.bottom-nav a,
.bottom-nav button.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    gap: 3px;
    color: #999;
    text-decoration: none;
    font-size: 10px;
    font-weight: 500;
    padding: 6px 0;
    border: none;
    background: none;
    cursor: pointer;
    transition: color 0.2s;
    font-family: Arial, sans-serif;
    height: 100%;
}

.bottom-nav a .nav-icon,
.bottom-nav button.nav-item .nav-icon {
    font-size: 22px;
    line-height: 1;
}

.bottom-nav a.active,
.bottom-nav a:hover {
    color: #e91e63;
}

.bottom-nav button.nav-item:hover {
    color: #e91e63;
}

/* Kasir tab — highlight khusus */
.bottom-nav a.nav-kasir.active,
.bottom-nav a.nav-kasir:hover {
    color: #e91e63;
}

/* Spacer agar konten tidak tertutup bottom nav */
.bottom-nav-spacer {
    height: 68px;
}

/* Sembunyikan btn-nav lama di header saat mobile (opsional) */
@media (max-width: 768px) {
    .header .header-right .btn-nav { display: none; }
}
</style>

<div class="bottom-nav">
    <a href="{{ route('admin.kasir') }}"
       class="nav-kasir {{ in_array($currentRoute, ['admin.kasir']) ? 'active' : '' }}">
        <span class="nav-icon">🧾</span>
        Kasir
    </a>

    <a href="{{ route('admin.products.index') }}"
       class="{{ in_array($currentRoute, ['admin.products.index']) ? 'active' : '' }}">
        <span class="nav-icon">📦</span>
        Produk
    </a>

    <a href="{{ route('admin.riwayat') }}"
       class="{{ in_array($currentRoute, ['admin.riwayat']) ? 'active' : '' }}">
        <span class="nav-icon">📋</span>
        Riwayat
    </a>

    <a href="{{ route('admin.laporan') }}"
       class="{{ in_array($currentRoute, ['admin.laporan']) ? 'active' : '' }}">
        <span class="nav-icon">📊</span>
        Laporan
    </a>
    <a href="{{ route('admin.ganti-password') }}"
   class="{{ in_array($currentRoute, ['admin.ganti-password']) ? 'active' : '' }}">
    <span class="nav-icon">🔑</span>
    Password
</a>
</form>
    
</div>

<div class="bottom-nav-spacer"></div>
