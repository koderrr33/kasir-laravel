<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    // ─── Konstanta Diskon ─────────────────────────────────────────────────────
    const DISKON_MINIMAL_QTY  = 10;   // minimal qty per item untuk dapat diskon
    const DISKON_MINIMAL_ITEM_BERBEDA = 10; // minimal 10 barang berbeda untuk dapat diskon
    const DISKON_PERSEN       = 5;    // diskon 5% untuk total keseluruhan

    // ─── Halaman Kasir ────────────────────────────────────────────────────────
    public function index()
    {
        $products = Product::orderBy('kategori')->orderBy('nama')->get();
        $kategoris = $products->pluck('kategori')->unique()->values();
        return view('kasir.index', compact('products', 'kategoris'));
    }

    // ─── Proses Transaksi ─────────────────────────────────────────────────────
    public function proses(Request $request)
    {
        $request->validate([
            'items'         => 'required|array|min:1',
            'items.*.id'    => 'required|exists:products,id',
            'items.*.qty'   => 'required|integer|min:1',
            'bayar'         => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $items   = $request->items;
            $subtotal = 0;
            $cartItems = [];

            foreach ($items as $item) {
                $product = Product::findOrFail($item['id']);
                $qty     = (int) $item['qty'];

                if ($product->stok < $qty) {
                    throw new \Exception("Stok {$product->nama} tidak mencukupi. Stok tersedia: {$product->stok}");
                }

                $itemSubtotal = $product->harga * $qty;
                $subtotal    += $itemSubtotal;
                $cartItems[]  = [
                    'product'      => $product,
                    'qty'          => $qty,
                    'subtotal'     => $itemSubtotal,
                ];
            }

            // Hitung diskon — logic lama tetap:
            // 1) ada item qty >= 10, ATAU
            // 2) ada >= 10 barang berbeda
            $jumlahBarangBerbeda = collect($items)->pluck('id')->unique()->count();
            $diskonDariQty = collect($items)->contains(fn($i) => (int)$i['qty'] >= self::DISKON_MINIMAL_QTY);
            $diskonDariBarangBerbeda = $jumlahBarangBerbeda >= self::DISKON_MINIMAL_ITEM_BERBEDA;
            $mendapatDiskon = $diskonDariQty || $diskonDariBarangBerbeda;
            $diskonPersen   = $mendapatDiskon ? self::DISKON_PERSEN : 0;
            $diskonNominal  = $subtotal * ($diskonPersen / 100);
            $total          = $subtotal - $diskonNominal;
            $bayar          = (float) $request->bayar;

            if ($bayar < $total) {
                throw new \Exception('Uang bayar tidak mencukupi.');
            }

            $kembalian = $bayar - $total;

            // Simpan transaksi
            $transaction = Transaction::create([
                'no_transaksi'   => Transaction::generateNoTransaksi(),
                'subtotal'       => $subtotal,
                'diskon_persen'  => $diskonPersen,
                'diskon_nominal' => $diskonNominal,
                'total'          => $total,
                'bayar'          => $bayar,
                'kembalian'      => $kembalian,
                'kasir'          => 'Admin',
            ]);

            // Simpan item & kurangi stok
            foreach ($cartItems as $ci) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $ci['product']->id,
                    'nama_produk'    => $ci['product']->nama,
                    'harga_satuan'   => $ci['product']->harga,
                    'qty'            => $ci['qty'],
                    'subtotal'       => $ci['subtotal'],
                ]);

                $ci['product']->decrement('stok', $ci['qty']);
            }

            DB::commit();

            return response()->json([
                'success'        => true,
                'message'        => 'Transaksi berhasil!',
                'no_transaksi'   => $transaction->no_transaksi,
                'subtotal'       => $subtotal,
                'diskon_persen'  => $diskonPersen,
                'diskon_nominal' => $diskonNominal,
                'total'          => $total,
                'bayar'          => $bayar,
                'kembalian'      => $kembalian,
                'dapat_diskon'   => $mendapatDiskon,
                'transaction_id' => $transaction->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    // ─── Riwayat Transaksi ────────────────────────────────────────────────────
    public function riwayat()
    {
        $transactions = Transaction::with('items')
            ->orderByDesc('created_at')
            ->paginate(15);
        return view('kasir.riwayat', compact('transactions'));
    }

    // ─── Detail Transaksi ─────────────────────────────────────────────────────
    public function detail(Transaction $transaction)
    {
        $transaction->load('items.product');
        return view('kasir.detail', compact('transaction'));
    }

    // ─── Struk (untuk print) ──────────────────────────────────────────────────
    public function struk(Transaction $transaction)
    {
        $transaction->load('items');
        return view('kasir.struk', compact('transaction'));
    }
}
