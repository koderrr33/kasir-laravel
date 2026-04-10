<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('kategori')->orderBy('nama')->paginate(20);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'     => 'required|string|unique:products,kode|max:20',
            'nama'     => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'harga'    => 'required|numeric|min:0',
            'stok'     => 'required|integer|min:0',
            'satuan'   => 'required|string|max:20',
        ]);

        Product::create($request->only(['kode', 'nama', 'kategori', 'harga', 'stok', 'satuan']));
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'kode'     => 'required|string|unique:products,kode,' . $product->id . '|max:20',
            'nama'     => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'harga'    => 'required|numeric|min:0',
            'stok'     => 'required|integer|min:0',
            'satuan'   => 'required|string|max:20',
        ]);

        $product->update($request->only(['kode', 'nama', 'kategori', 'harga', 'stok', 'satuan']));
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
