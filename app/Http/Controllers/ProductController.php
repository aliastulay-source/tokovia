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
        'nama'      => 'required',
        'deskripsi' => 'required',
        'harga'     => 'required|numeric',
        'stok'      => 'required|numeric',
        'gambar'    => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['nama', 'deskripsi', 'harga', 'stok']);

    if ($request->hasFile('gambar')) {
        $data['gambar'] = $request->file('gambar')->store('produk', 'public');
    }

   Product::create($data);
    return redirect()->route('admin.products.index')
           ->with('success', 'Produk berhasil ditambahkan!');
}

    // Hapus produk
    public function destroy(Product $product)
    {
        // Hapus gambar jika ada
        if ($product->gambar) {
            \Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();
        return redirect()->route('admin.products.index')
               ->with('success', 'Produk berhasil dihapus!');
    }
}

