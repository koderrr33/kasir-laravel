<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProductController;

// Redirect root ke kasir
Route::get('/', fn() => redirect()->route('kasir.index'));

// ─── Kasir ────────────────────────────────────────────────────────────────────
Route::prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/',          [KasirController::class, 'index'])   ->name('index');
    Route::post('/proses',   [KasirController::class, 'proses'])  ->name('proses');
    Route::get('/riwayat',   [KasirController::class, 'riwayat']) ->name('riwayat');
    Route::get('/{transaction}',        [KasirController::class, 'detail']) ->name('detail');
    Route::get('/{transaction}/struk',  [KasirController::class, 'struk'])  ->name('struk');
});

// ─── Produk ───────────────────────────────────────────────────────────────────
Route::resource('products', ProductController::class)->except(['show']);
