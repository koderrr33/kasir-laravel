@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <span><i class="fa fa-receipt" style="color:var(--accent)"></i> Riwayat Transaksi</span>
    </div>
    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Waktu</th>
                    <th>Item</th>
                    <th>Subtotal</th>
                    <th>Diskon</th>
                    <th>Total</th>
                    <th>Kasir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td>
                        <span style="font-family:'Space Mono',monospace;font-size:12px;color:var(--accent)">
                            {{ $trx->no_transaksi }}
                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:12px">
                        {{ $trx->created_at->format('d M Y H:i') }}
                    </td>
                    <td>
                        <span style="background:var(--surface);border:1px solid var(--border);padding:3px 10px;border-radius:99px;font-size:12px">
                            {{ $trx->items->count() }} item
                        </span>
                    </td>
                    <td style="font-family:'Space Mono',monospace;font-size:13px">
                        Rp {{ number_format($trx->subtotal, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($trx->diskon_persen > 0)
                            <span style="color:var(--green);font-size:12px;font-weight:700">
                                {{ $trx->diskon_persen }}%
                            </span>
                        @else
                            <span style="color:var(--muted)">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-family:'Space Mono',monospace;font-weight:700;font-size:14px;color:var(--accent)">
                            Rp {{ number_format($trx->total, 0, ',', '.') }}
                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:13px">{{ $trx->kasir }}</td>
                    <td>
                        <a href="{{ route('kasir.detail', $trx) }}" class="btn btn-ghost btn-sm">
                            <i class="fa fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('kasir.struk', $trx) }}" target="_blank" class="btn btn-ghost btn-sm">
                            <i class="fa fa-print"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:var(--muted);padding:40px">
                        <i class="fa fa-receipt" style="font-size:32px;opacity:.3;display:block;margin-bottom:12px"></i>
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div style="padding:16px 20px;border-top:1px solid var(--border)">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
