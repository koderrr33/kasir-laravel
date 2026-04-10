<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'no_transaksi', 'subtotal', 'diskon_persen', 'diskon_nominal',
        'total', 'bayar', 'kembalian', 'kasir', 'keterangan',
    ];

    protected $casts = [
        'subtotal'       => 'decimal:2',
        'diskon_persen'  => 'decimal:2',
        'diskon_nominal' => 'decimal:2',
        'total'          => 'decimal:2',
        'bayar'          => 'decimal:2',
        'kembalian'      => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public static function generateNoTransaksi(): string
    {
        $prefix = 'TRX-' . date('Ymd') . '-';
        $last = self::where('no_transaksi', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $number = $last
            ? (int) substr($last->no_transaksi, strlen($prefix)) + 1
            : 1;

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
