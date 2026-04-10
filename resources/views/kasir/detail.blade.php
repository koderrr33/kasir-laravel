@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
<div style="max-width:700px">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px">
        <a href="{{ route('kasir.riwayat') }}" class="btn btn-ghost btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('kasir.struk', $transaction) }}" target="_blank" class="btn btn-ghost btn-sm">
            <i class="fa fa-print"></i> Cetak Struk
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <span style="font-family:'Space Mono',monospace;color:var(--accent)">
                {{ $transaction->no_transaksi }}
            </span>
            <span style="font-size:13px;color:var(--muted)">
                {{ $transaction->created_at->format('d M Y, H:i:s') }}
            </span>
        </div>
        <div style="padding:20px">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align:right">Harga</th>
                        <th style="text-align:center">Qty</th>
                        <th style="text-align:right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->items as $item)
                    <tr>
                        <td>
                            {{ $item->nama_produk }}
                            @if($item->qty >= 10)
                                <span style="background:rgba(245,197,66,.15);color:var(--accent);font-size:10px;padding:2px 8px;border-radius:99px;margin-left:6px;font-weight:700">
                                    ✨ DISKON
                                </span>
                            @endif
                        </td>
                        <td style="text-align:right;font-family:'Space Mono',monospace;font-size:13px">
                            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                        </td>
                        <td style="text-align:center">{{ $item->qty }}</td>
                        <td style="text-align:right;font-family:'Space Mono',monospace;font-size:13px">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="border-top:1px solid var(--border);margin-top:16px;padding-top:16px">
                <div style="max-width:280px;margin-left:auto">
                    @php $rows = [
                        ['Subtotal', 'Rp '.number_format($transaction->subtotal,0,',','.')],
                        $transaction->diskon_persen > 0
                            ? ['Diskon ('.$transaction->diskon_persen.'%)', '- Rp '.number_format($transaction->diskon_nominal,0,',','.')]
                            : null,
                        ['Total', 'Rp '.number_format($transaction->total,0,',','.')],
                        ['Bayar', 'Rp '.number_format($transaction->bayar,0,',','.')],
                        ['Kembalian', 'Rp '.number_format($transaction->kembalian,0,',','.')],
                    ]; @endphp
                    @foreach(array_filter($rows) as $row)
                    <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);font-size:14px">
                        <span style="color:var(--muted)">{{ $row[0] }}</span>
                        <span style="font-family:'Space Mono',monospace;font-weight:{{ $row[0]==='Total'?'800':'400' }};color:{{ $row[0]==='Total'?'var(--accent)':'var(--text)' }}">
                            {{ $row[1] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            @if($transaction->diskon_persen > 0)
            <div style="margin-top:16px;padding:12px 16px;background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:10px;font-size:13px;color:var(--green)">
                <i class="fa fa-circle-check"></i>
                Transaksi ini mendapat diskon <strong>{{ $transaction->diskon_persen }}%</strong>
                karena ada item dengan qty ≥ 10 pcs.
                Hemat: <strong>Rp {{ number_format($transaction->diskon_nominal, 0, ',', '.') }}</strong>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
