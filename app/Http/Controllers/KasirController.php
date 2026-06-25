<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    // Halaman kasir
    public function index()
    {
        $products = Product::where('stok', '>', 0)->get();
        return view('admin.kasir', compact('products'));
    }

    // Proses transaksi
    public function proses(Request $request)
    {
        $request->validate([
            'items'  => 'required|array',
            'bayar'  => 'required|numeric',
        ]);

        $items = $request->items;
        $total = 0;

        // Hitung total
        foreach ($items as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        $kembalian = $request->bayar - $total;

        if ($kembalian < 0) {
            return response()->json(['error' => 'Uang bayar kurang!'], 400);
        }

        // Buat kode transaksi
        $kode = 'TRX-' . date('Ymd') . '-' . rand(1000, 9999);

        // Simpan transaksi
        $transaksi = Transaction::create([
            'kode_transaksi' => $kode,
            'total'          => $total,
            'bayar'          => $request->bayar,
            'kembalian'      => $kembalian,
            'kasir'          => Auth::user()->name,
        ]);

        // Simpan item & kurangi stok
        foreach ($items as $item) {
            TransactionItem::create([
                'transaction_id' => $transaksi->id,
                'product_id'     => $item['id'],
                'nama_produk'    => $item['nama'],
                'harga'          => $item['harga'],
                'jumlah'         => $item['jumlah'],
                'subtotal'       => $item['harga'] * $item['jumlah'],
            ]);

            // Kurangi stok
            $product = Product::find($item['id']);
            $product->stok -= $item['jumlah'];
            $product->save();
        }

        return response()->json([
            'success'        => true,
            'kode_transaksi' => $kode,
            'total'          => $total,
            'bayar'          => $request->bayar,
            'kembalian'      => $kembalian,
            'kasir'          => Auth::user()->name,
            'items'          => $items,
            'waktu'          => now()->format('d/m/Y H:i'),
        ]);
    }

    // Riwayat transaksi
    public function riwayat()
    {
        $transaksis = Transaction::with('items')->latest()->get();
        return view('admin.riwayat', compact('transaksis'));
    }

    // Laporan harian
    public function laporan(Request $request)
{
    $query = Transaction::with('items');

    if ($request->hari) {
        $query->whereDay('created_at', $request->hari);
    }
    if ($request->bulan) {
        $query->whereMonth('created_at', $request->bulan);
    }
    if ($request->tahun) {
        $query->whereYear('created_at', $request->tahun);
    }

    // Kalau tidak ada filter sama sekali, tampilkan hari ini
    if (!$request->hari && !$request->bulan && !$request->tahun) {
        $query->whereDate('created_at', today());
    }

    $hari_ini = $query->latest()->get();
    $total_hari_ini = $hari_ini->sum('total');
    $total_transaksi = $hari_ini->count();

    return view('admin.laporan', compact('hari_ini', 'total_hari_ini', 'total_transaksi'));
}
    // Hapus semua riwayat transaksi
public function hapusRiwayat()
{
    TransactionItem::query()->delete();
    Transaction::query()->delete();

    return redirect()->route('admin.products.index')
           ->with('success', 'Semua riwayat transaksi berhasil dihapus!');
}
}