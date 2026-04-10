@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
<div style="max-width:560px">
    <a href="{{ route('products.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:20px">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="card-header">
            <span><i class="fa fa-pen" style="color:var(--accent)"></i> Edit Produk</span>
            <span style="font-family:'Space Mono',monospace;font-size:12px;color:var(--muted)">{{ $product->kode }}</span>
        </div>
        <div style="padding:24px">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0;padding-left:18px">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf @method('PUT')
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form-group">
                        <label>Kode Produk</label>
                        <input type="text" name="kode" value="{{ old('kode', $product->kode) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" value="{{ old('kategori', $product->kategori) }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="nama" value="{{ old('nama', $product->nama) }}" required>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Satuan</label>
                        <select name="satuan">
                            @foreach(['pcs','botol','bungkus','kaleng','kotak','buah','tube','kg','liter'] as $s)
                            <option value="{{ $s }}" {{ old('satuan', $product->satuan) == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                    <i class="fa fa-save"></i> Update Produk
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
