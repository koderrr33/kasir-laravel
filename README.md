# 🛒 TokoKu POS — Aplikasi Kasir Laravel

Aplikasi kasir (Point of Sale) berbasis **Laravel 11** dengan fitur diskon otomatis 5% ketika ada item dengan qty ≥ 10 pcs.

---

## ✨ Fitur Utama

| Fitur | Keterangan |
|---|---|
| 🛍️ **Kasir Interaktif** | Tambah produk ke keranjang dengan satu klik |
| 💰 **Diskon Otomatis 5%** | Berlaku jika ada item dengan qty ≥ 10 pcs |
| 🔍 **Filter & Pencarian** | Cari produk berdasarkan nama, kode, atau kategori |
| 🖨️ **Cetak Struk** | Struk siap cetak untuk printer thermal |
| 📋 **Riwayat Transaksi** | Lihat semua transaksi yang pernah terjadi |
| 📦 **Manajemen Produk** | CRUD produk dengan tracking stok otomatis |
| 📊 **20 Produk Awal** | Data produk siap pakai dari berbagai kategori |

---

## 🗂️ Struktur Project

```
kasir-laravel/
│
├── app/
│   ├── Http/Controllers/
│   │   ├── KasirController.php       ← Logic kasir & transaksi
│   │   └── ProductController.php     ← CRUD produk
│   └── Models/
│       ├── Product.php               ← Model produk
│       ├── Transaction.php           ← Model transaksi
│       └── TransactionItem.php       ← Model item transaksi
│
├── database/
│   ├── migrations/
│   │   ├── ..._create_products_table.php
│   │   └── ..._create_transactions_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── ProductSeeder.php         ← 20 produk siap pakai
│
├── resources/views/
│   ├── layouts/app.blade.php         ← Layout utama (sidebar, topbar)
│   ├── kasir/
│   │   ├── index.blade.php           ← Halaman kasir utama
│   │   ├── riwayat.blade.php         ← Riwayat transaksi
│   │   ├── detail.blade.php          ← Detail transaksi
│   │   └── struk.blade.php           ← Cetak struk (thermal)
│   └── products/
│       ├── index.blade.php           ← Daftar produk
│       ├── create.blade.php          ← Form tambah produk
│       └── edit.blade.php            ← Form edit produk
│
└── routes/web.php                    ← Semua route aplikasi
```

---

## ⚙️ Cara Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL / PostgreSQL / SQLite

### Langkah Instalasi

**1. Clone atau copy project ini**
```bash
git clone <repo-url> kasir-laravel
cd kasir-laravel
```

**2. Install dependensi PHP**
```bash
composer install
```

**3. Salin file konfigurasi**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasi database di `.env`**

Pilih salah satu opsi:

**Opsi A — SQLite (paling mudah):**
```env
DB_CONNECTION=sqlite
```
Buat file database:
```bash
touch database/database.sqlite
```

**Opsi B — MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kasir_db
DB_USERNAME=root
DB_PASSWORD=your_password
```
Buat database di MySQL dulu:
```sql
CREATE DATABASE kasir_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**5. Jalankan migrasi & seeder**
```bash
php artisan migrate
php artisan db:seed
```

**6. Jalankan aplikasi**
```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 📋 Daftar Produk Bawaan (20 Item)

| Kode | Nama | Kategori | Harga |
|---|---|---|---|
| MNM001 | Aqua Botol 600ml | Minuman | Rp 4.000 |
| MNM002 | Teh Botol Sosro 450ml | Minuman | Rp 6.000 |
| MNM003 | Coca Cola Kaleng 330ml | Minuman | Rp 8.500 |
| MNM004 | Susu Ultra 250ml | Minuman | Rp 5.500 |
| MNM005 | Pocari Sweat 500ml | Minuman | Rp 9.500 |
| MKN001 | Indomie Goreng | Makanan | Rp 3.500 |
| MKN002 | Chitato Rasa Sapi | Makanan | Rp 12.000 |
| MKN003 | Oreo Original 133g | Makanan | Rp 14.500 |
| MKN004 | Roti Tawar Sari Roti | Makanan | Rp 16.000 |
| MKN005 | Wafer Tango Cokelat | Makanan | Rp 8.000 |
| KBR001 | Sabun Lifebuoy 75g | Kebersihan | Rp 5.000 |
| KBR002 | Shampo Pantene 170ml | Kebersihan | Rp 22.000 |
| KBR003 | Pasta Gigi Pepsodent | Kebersihan | Rp 11.000 |
| KBR004 | Detergen Rinso 800g | Kebersihan | Rp 28.000 |
| KBR005 | Tisu Paseo 250 Lembar | Kebersihan | Rp 13.500 |
| ATK001 | Pulpen Pilot G2 | ATK | Rp 8.000 |
| ATK002 | Buku Tulis Sidu 40 Lbr | ATK | Rp 4.500 |
| ATK003 | Pensil 2B Faber Castell | ATK | Rp 3.000 |
| FRZ001 | Sosis So Nice 500g | Frozen Food | Rp 32.000 |
| FRZ002 | Nugget Fiesta 500g | Frozen Food | Rp 35.000 |

---

## 💡 Logika Diskon 5%

```
Diskon berlaku JIKA:
  Ada minimal 1 (satu) item dalam keranjang
  yang memiliki qty (jumlah beli) >= 10

Maka:
  Diskon = 5% × Subtotal Keseluruhan

Contoh:
  Aqua Botol   × 12 pcs  = Rp  48.000  ← qty ≥ 10 ✓
  Indomie      ×  3 pcs  = Rp  10.500
  ─────────────────────────────────────
  Subtotal               = Rp  58.500
  Diskon 5%              = Rp   2.925
  ─────────────────────────────────────
  TOTAL                  = Rp  55.575
```

Logika ini ada di `KasirController.php`:
```php
const DISKON_MINIMAL_QTY = 10;   // qty minimum per item
const DISKON_PERSEN      = 5;    // diskon 5%

$mendapatDiskon = collect($items)->contains(
    fn($i) => (int)$i['qty'] >= self::DISKON_MINIMAL_QTY
);
$diskonNominal = $mendapatDiskon ? $subtotal * (DISKON_PERSEN / 100) : 0;
```

---

## 🗺️ Daftar Route

| Method | URL | Nama | Keterangan |
|---|---|---|---|
| GET | `/` | — | Redirect ke kasir |
| GET | `/kasir` | `kasir.index` | Halaman kasir utama |
| POST | `/kasir/proses` | `kasir.proses` | Proses pembayaran (AJAX) |
| GET | `/kasir/riwayat` | `kasir.riwayat` | Riwayat transaksi |
| GET | `/kasir/{id}` | `kasir.detail` | Detail transaksi |
| GET | `/kasir/{id}/struk` | `kasir.struk` | Cetak struk |
| GET | `/products` | `products.index` | Daftar produk |
| GET | `/products/create` | `products.create` | Form tambah produk |
| POST | `/products` | `products.store` | Simpan produk baru |
| GET | `/products/{id}/edit` | `products.edit` | Form edit produk |
| PUT | `/products/{id}` | `products.update` | Update produk |
| DELETE | `/products/{id}` | `products.destroy` | Hapus produk |

---

## 🚀 Perintah Artisan Berguna

```bash
# Jalankan server development
php artisan serve

# Reset & isi ulang database
php artisan migrate:fresh --seed

# Lihat semua route
php artisan route:list

# Clear semua cache
php artisan optimize:clear

# Tinker (REPL interaktif)
php artisan tinker
```

---

## 🛠️ Tech Stack

- **Framework**: Laravel 11
- **Database**: SQLite / MySQL / PostgreSQL
- **Frontend**: Blade Template + Vanilla JS (tanpa npm build!)
- **Font**: Space Mono + Plus Jakarta Sans (Google Fonts)
- **Icons**: Font Awesome 6
- **Design**: Dark theme, POS-style layout
