<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Halaman toko publik
    public function shop()
    {
        $products = Product::all();
        return view('shop.index', compact('products'));
    }

    // Halaman admin - daftar produk
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
    'nama' => 'required|unique:products,nama',
    'harga' => 'required|numeric',
    'harga_asli' => 'required|numeric',
    'stok' => 'required|numeric',
    'gambar' => 'nullable|image',
], [
            'nama.unique' => 'Produk dengan nama ini sudah ada! Gunakan fitur Tambah Stok.',
        ]);

       $data = $request->only(['nama', 'harga', 'harga_asli', 'stok']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Product::create($data);
        return redirect()->route('admin.products.index')
               ->with('success', 'Produk berhasil ditambahkan!');
    }

    // Tambah stok produk
    public function tambahStok(Request $request, Product $product)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ], [
            'jumlah.min' => 'Jumlah stok minimal 1.',
        ]);

        $product->stok += $request->jumlah;
        $product->save();

        return redirect()->route('admin.products.index')
               ->with('success', "Stok {$product->nama} berhasil ditambah {$request->jumlah}!");
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        if ($product->gambar) {
            \Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();
        return redirect()->route('admin.products.index')
               ->with('success', 'Produk berhasil dihapus!');
    }
}
