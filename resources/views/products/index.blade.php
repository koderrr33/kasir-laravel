@extends('layouts.app')
@section('title', 'Data Produk')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:20px;font-weight:800">Data Produk ({{ $products->total() }})</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="card">
    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th style="text-align:right">Harga</th>
                    <th style="text-align:center">Stok</th>
                    <th>Satuan</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $i => $p)
                <tr>
                    <td style="color:var(--muted)">{{ $products->firstItem() + $i }}</td>
                    <td>
                        <span style="font-family:'Space Mono',monospace;font-size:12px;color:var(--accent)">
                            {{ $p->kode }}
                        </span>
                    </td>
                    <td style="font-weight:600">{{ $p->nama }}</td>
                    <td>
                        <span style="background:var(--surface);border:1px solid var(--border);padding:3px 10px;border-radius:99px;font-size:11px;color:var(--muted)">
                            {{ $p->kategori }}
                        </span>
                    </td>
                    <td style="text-align:right;font-family:'Space Mono',monospace;font-size:13px;font-weight:700">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </td>
                    <td style="text-align:center">
                        <span style="font-weight:700;color:{{ $p->stok == 0 ? 'var(--red)' : ($p->stok <= 10 ? 'var(--accent2)' : 'var(--green)') }}">
                            {{ $p->stok }}
                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:13px">{{ $p->satuan }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('products.edit', $p) }}" class="btn btn-ghost btn-sm">
                            <i class="fa fa-pen"></i>
                        </a>
                        <form action="{{ route('products.destroy', $p) }}" method="POST" style="display:inline"
                              onsubmit="return confirm('Hapus produk {{ $p->nama }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:var(--muted)">Belum ada produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div style="padding:16px 20px;border-top:1px solid var(--border)">{{ $products->links() }}</div>
    @endif
</div>
@endsection
