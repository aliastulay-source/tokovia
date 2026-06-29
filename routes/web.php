<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;

// Halaman publik
Route::get('/', [ProductController::class, 'shop'])->name('shop');

// Login admin
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin/ganti-password', [AdminController::class, 'formGantiPassword'])->name('admin.ganti-password');
Route::post('/admin/ganti-password', [AdminController::class, 'simpanPassword'])->name('admin.simpan-password');

// Halaman admin (harus login)
Route::middleware('auth')->prefix('admin')->group(function () {

    // Produk
    Route::resource('products', ProductController::class)->names([
        'index'   => 'admin.products.index',
        'store'   => 'admin.products.store',
        'destroy' => 'admin.products.destroy',
    ]);

    // Tambah stok
    Route::post('/products/{product}/tambah-stok', [ProductController::class, 'tambahStok'])->name('admin.products.tambahStok');

    // Kasir
    Route::get('/kasir', [KasirController::class, 'index'])->name('admin.kasir');
    Route::post('/kasir/proses', [KasirController::class, 'proses'])->name('admin.kasir.proses');

    // Riwayat & Laporan
    Route::get('/riwayat', [KasirController::class, 'riwayat'])->name('admin.riwayat');
    Route::get('/laporan', [KasirController::class, 'laporan'])->name('admin.laporan');
    Route::delete('/riwayat/hapus-semua', [KasirController::class, 'hapusRiwayat'])->name('admin.riwayat.hapus');
});
