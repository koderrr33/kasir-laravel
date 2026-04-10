<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Minuman
            ['kode' => 'MNM001', 'nama' => 'Aqua Botol 600ml',       'kategori' => 'Minuman', 'harga' => 4000,   'stok' => 200, 'satuan' => 'botol'],
            ['kode' => 'MNM002', 'nama' => 'Teh Botol Sosro 450ml',  'kategori' => 'Minuman', 'harga' => 6000,   'stok' => 150, 'satuan' => 'botol'],
            ['kode' => 'MNM003', 'nama' => 'Coca Cola Kaleng 330ml', 'kategori' => 'Minuman', 'harga' => 8500,   'stok' => 120, 'satuan' => 'kaleng'],
            ['kode' => 'MNM004', 'nama' => 'Susu Ultra 250ml',       'kategori' => 'Minuman', 'harga' => 5500,   'stok' => 100, 'satuan' => 'kotak'],
            ['kode' => 'MNM005', 'nama' => 'Pocari Sweat 500ml',     'kategori' => 'Minuman', 'harga' => 9500,   'stok' => 80,  'satuan' => 'botol'],

            // Makanan Ringan
            ['kode' => 'MKN001', 'nama' => 'Indomie Goreng',         'kategori' => 'Makanan', 'harga' => 3500,   'stok' => 300, 'satuan' => 'bungkus'],
            ['kode' => 'MKN002', 'nama' => 'Chitato Rasa Sapi',      'kategori' => 'Makanan', 'harga' => 12000,  'stok' => 90,  'satuan' => 'bungkus'],
            ['kode' => 'MKN003', 'nama' => 'Oreo Original 133g',     'kategori' => 'Makanan', 'harga' => 14500,  'stok' => 75,  'satuan' => 'bungkus'],
            ['kode' => 'MKN004', 'nama' => 'Roti Tawar Sari Roti',   'kategori' => 'Makanan', 'harga' => 16000,  'stok' => 50,  'satuan' => 'bungkus'],
            ['kode' => 'MKN005', 'nama' => 'Wafer Tango Cokelat',    'kategori' => 'Makanan', 'harga' => 8000,   'stok' => 110, 'satuan' => 'bungkus'],

            // Kebersihan
            ['kode' => 'KBR001', 'nama' => 'Sabun Lifebuoy 75g',     'kategori' => 'Kebersihan', 'harga' => 5000,  'stok' => 150, 'satuan' => 'buah'],
            ['kode' => 'KBR002', 'nama' => 'Shampo Pantene 170ml',   'kategori' => 'Kebersihan', 'harga' => 22000, 'stok' => 60,  'satuan' => 'botol'],
            ['kode' => 'KBR003', 'nama' => 'Pasta Gigi Pepsodent',   'kategori' => 'Kebersihan', 'harga' => 11000, 'stok' => 80,  'satuan' => 'tube'],
            ['kode' => 'KBR004', 'nama' => 'Detergen Rinso 800g',    'kategori' => 'Kebersihan', 'harga' => 28000, 'stok' => 40,  'satuan' => 'bungkus'],
            ['kode' => 'KBR005', 'nama' => 'Tisu Paseo 250 Lembar',  'kategori' => 'Kebersihan', 'harga' => 13500, 'stok' => 70,  'satuan' => 'bungkus'],

            // Alat Tulis
            ['kode' => 'ATK001', 'nama' => 'Pulpen Pilot G2',        'kategori' => 'ATK', 'harga' => 8000,  'stok' => 200, 'satuan' => 'buah'],
            ['kode' => 'ATK002', 'nama' => 'Buku Tulis Sidu 40 Lbr', 'kategori' => 'ATK', 'harga' => 4500,  'stok' => 180, 'satuan' => 'buah'],
            ['kode' => 'ATK003', 'nama' => 'Pensil 2B Faber Castell', 'kategori' => 'ATK', 'harga' => 3000,  'stok' => 220, 'satuan' => 'buah'],

            // Frozen Food
            ['kode' => 'FRZ001', 'nama' => 'Sosis So Nice 500g',     'kategori' => 'Frozen Food', 'harga' => 32000, 'stok' => 40, 'satuan' => 'bungkus'],
            ['kode' => 'FRZ002', 'nama' => 'Nugget Fiesta 500g',     'kategori' => 'Frozen Food', 'harga' => 35000, 'stok' => 35, 'satuan' => 'bungkus'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
