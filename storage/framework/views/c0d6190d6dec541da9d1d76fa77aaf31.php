<?php $__env->startSection('title', 'Kasir'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .kasir-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
        height: calc(100vh - 120px);
    }
    @media (max-width: 980px) {
        .kasir-grid { grid-template-columns: 1fr; height: auto; }
        .panel-cart { position: sticky; bottom: 0; }
    }
    /* ── Produk Panel ── */
    .panel-produk { display: flex; flex-direction: column; overflow: hidden; }
    .search-bar {
        position: relative; margin-bottom: 16px;
    }
    .search-bar input {
        padding-left: 42px;
        background: var(--card);
    }
    .search-bar i {
        position: absolute; left: 14px; top: 50%;
        transform: translateY(-50%); color: var(--muted);
    }
    .filter-tabs {
        display: flex; gap: 8px; margin-bottom: 16px;
        flex-wrap: wrap;
    }
    .filter-tab {
        padding: 6px 14px; border-radius: 99px;
        font-size: 12px; font-weight: 600; cursor: pointer;
        border: 1px solid var(--border);
        background: var(--card); color: var(--muted);
        transition: all .2s;
    }
    .filter-tab.active, .filter-tab:hover {
        background: var(--accent); color: #000; border-color: var(--accent);
    }
    .produk-grid {
        display: grid;
        /* Biar kartu tetap "kotak" saat item sedikit:
           - track kolom dibuat fixed (tidak melebar 1fr)
           - grid dirapikan rata kiri */
        grid-template-columns: repeat(auto-fill, minmax(160px, 160px));
        justify-content: start;
        align-content: start;
        align-items: start;
        gap: 12px;
        overflow-y: auto;
        flex: 1;
        padding-right: 4px;
    }
    @media (max-width: 520px) {
        /* di layar kecil, boleh melebar agar muat */
        .produk-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); }
    }
    .produk-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px;
        cursor: pointer;
        transition: all .2s;
        position: relative;
        overflow: hidden;
        aspect-ratio: 1 / 1;
        display: flex;
        flex-direction: column;
    }
    .produk-card:hover {
        border-color: var(--accent);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,.3);
    }
    .produk-card.habis { opacity: .5; cursor: not-allowed; }
    .produk-card .kat {
        font-size: 10px; color: var(--muted);
        text-transform: uppercase; letter-spacing: .5px;
        margin-bottom: 6px;
    }
    .produk-card .nama {
        font-size: 13px; font-weight: 700; margin-bottom: 8px;
        line-height: 1.3;
    }
    .produk-card .harga {
        font-size: 14px; font-weight: 800;
        color: var(--accent);
        font-family: 'Space Mono', monospace;
    }
    .produk-card .stok {
        font-size: 11px; color: var(--muted); margin-top: 4px;
    }
    .produk-card .stok.low { color: var(--accent2); }
    .add-badge {
        position: absolute; top: 10px; right: 10px;
        width: 26px; height: 26px;
        background: var(--accent); color: #000;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 14px; font-weight: 700;
        opacity: 0; transition: all .2s;
    }
    .produk-card:hover .add-badge { opacity: 1; }

    /* ── Cart Panel ── */
    .panel-cart {
        display: flex; flex-direction: column;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }
    .cart-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--border);
        font-weight: 700; font-size: 15px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .cart-body {
        flex: 1; overflow-y: auto;
        padding: 12px;
    }
    .cart-empty {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; height: 200px;
        color: var(--muted); gap: 12px;
        font-size: 13px;
    }
    .cart-empty i { font-size: 40px; opacity: .3; }
    .cart-item {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 10px;
        transition: all .2s;
    }
    .cart-item:hover { border-color: var(--accent); }
    .cart-item-top {
        display: flex; justify-content: space-between; align-items: flex-start;
    }
    .cart-item-nama { font-size: 13px; font-weight: 700; margin-bottom: 4px; }
    .cart-item-harga { font-size: 12px; color: var(--muted); }
    .cart-item-bottom {
        display: flex; align-items: center; justify-content: space-between;
        margin-top: 10px;
    }
    .qty-ctrl {
        display: flex; align-items: center; gap: 0;
    }
    .qty-btn {
        width: 30px; height: 30px;
        background: var(--card); border: 1px solid var(--border);
        color: var(--text); font-size: 16px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all .15s;
    }
    .qty-btn:first-child { border-radius: 8px 0 0 8px; }
    .qty-btn:last-child  { border-radius: 0 8px 8px 0; }
    .qty-btn:hover { background: var(--accent); color: #000; border-color: var(--accent); }
    .qty-input {
        width: 48px; height: 30px; text-align: center;
        background: var(--surface); border: 1px solid var(--border);
        border-left: none; border-right: none;
        color: var(--text); font-family: 'Space Mono', monospace;
        font-size: 14px; font-weight: 700;
    }
    .qty-input:focus { outline: none; }
    .item-subtotal {
        font-size: 14px; font-weight: 800;
        color: var(--accent);
        font-family: 'Space Mono', monospace;
    }
    .remove-btn {
        background: none; border: none;
        color: var(--muted); cursor: pointer; font-size: 14px;
        padding: 4px; transition: color .2s;
    }
    .remove-btn:hover { color: var(--red); }

    /* Diskon badge */
    .diskon-info {
        margin: 0 12px 10px;
        padding: 10px 14px;
        background: rgba(245,197,66,.1);
        border: 1px solid rgba(245,197,66,.3);
        border-radius: 8px;
        font-size: 12px; color: var(--accent);
        display: flex; align-items: center; gap: 8px;
    }
    .diskon-info.hidden { display: none; }

    /* Cart Footer */
    .cart-footer {
        border-top: 1px solid var(--border);
        padding: 16px;
    }
    .summary-row {
        display: flex; justify-content: space-between;
        font-size: 13px; margin-bottom: 8px; color: var(--muted);
    }
    .summary-row.discount { color: var(--green); }
    .summary-row.total {
        font-size: 18px; font-weight: 800; color: var(--text);
        margin: 12px 0; padding-top: 12px;
        border-top: 1px solid var(--border);
    }
    .bayar-input-wrap { margin: 12px 0; }
    .bayar-input-wrap label {
        font-size: 11px; color: var(--muted);
        font-weight: 600; text-transform: uppercase;
        margin-bottom: 6px; display: block;
    }
    .bayar-input-wrap input {
        font-family: 'Space Mono', monospace;
        font-size: 18px; font-weight: 700;
        text-align: right;
    }
    .quick-cash {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin: 10px 0 12px;
    }
    .quick-cash .chip {
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text);
        cursor: pointer;
        transition: all .15s ease;
    }
    .quick-cash .chip:hover { border-color: rgba(245,197,66,.35); transform: translateY(-1px); }
    .quick-cash .chip.primary { background: rgba(245,197,66,.12); border-color: rgba(245,197,66,.28); color: var(--accent); }
    .kembalian-box {
        background: rgba(34,197,94,.1);
        border: 1px solid rgba(34,197,94,.3);
        border-radius: 8px; padding: 10px 14px;
        display: flex; justify-content: space-between;
        margin-bottom: 12px;
    }
    .kembalian-box .label { font-size: 12px; color: var(--green); font-weight: 600; }
    .kembalian-box .value {
        font-family: 'Space Mono', monospace;
        font-weight: 800; color: var(--green); font-size: 16px;
    }
    .kembalian-box.minus {
        background: rgba(239,68,68,.08);
        border-color: rgba(239,68,68,.28);
    }
    .kembalian-box.minus .label, .kembalian-box.minus .value { color: var(--red); }
    .btn-bayar {
        width: 100%; padding: 14px;
        background: var(--accent); color: #000;
        border: none; border-radius: 10px;
        font-family: inherit; font-size: 15px; font-weight: 800;
        cursor: pointer; transition: all .2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-bayar:hover { background: #e8b820; transform: translateY(-1px); }
    .btn-bayar:disabled { background: var(--border); color: var(--muted); cursor: not-allowed; transform: none; }

    /* Modal */
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,.8);
        z-index: 200; display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none; transition: opacity .3s;
    }
    .modal-overlay.show { opacity: 1; pointer-events: all; }
    .modal-box {
        background: var(--card); border: 1px solid var(--border);
        border-radius: 20px; width: 480px; padding: 32px;
        transform: scale(.95); transition: transform .3s;
    }
    .modal-overlay.show .modal-box { transform: scale(1); }
    .modal-icon {
        width: 64px; height: 64px; border-radius: 50%;
        background: rgba(34,197,94,.15);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px; color: var(--green);
    }
    .modal-title { font-size: 22px; font-weight: 800; text-align: center; margin-bottom: 6px; }
    .modal-sub { font-size: 13px; color: var(--muted); text-align: center; margin-bottom: 24px; }
    .struk-row {
        display: flex; justify-content: space-between;
        padding: 8px 0; border-bottom: 1px solid var(--border);
        font-size: 13px;
    }
    .struk-row:last-child { border-bottom: none; }
    .struk-total {
        font-size: 18px; font-weight: 800;
        color: var(--accent);
        font-family: 'Space Mono', monospace;
    }
    .modal-actions {
        display: flex; gap: 12px; margin-top: 24px;
    }
    .modal-actions .btn { flex: 1; justify-content: center; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="kasir-grid">
    <!-- ── Produk Panel ── -->
    <div class="panel-produk">
        <div class="search-bar">
            <i class="fa fa-search"></i>
            <input type="text" id="searchInput" placeholder="Cari produk (nama / kode)…">
        </div>
        <div class="filter-tabs">
            <div class="filter-tab active" data-kat="all">Semua</div>
            <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="filter-tab" data-kat="<?php echo e($kat); ?>"><?php echo e($kat); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="produk-grid" id="produkGrid">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="produk-card <?php echo e($product->stok == 0 ? 'habis' : ''); ?>"
                 data-id="<?php echo e($product->id); ?>"
                 data-nama="<?php echo e($product->nama); ?>"
                 data-harga="<?php echo e($product->harga); ?>"
                 data-stok="<?php echo e($product->stok); ?>"
                 data-kode="<?php echo e($product->kode); ?>"
                 data-kat="<?php echo e($product->kategori); ?>"
                 onclick="tambahKeCart(this)">
                <div class="kat"><?php echo e($product->kategori); ?></div>
                <div class="nama"><?php echo e($product->nama); ?></div>
                <div class="harga">Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?></div>
                <div class="stok <?php echo e($product->stok <= 10 && $product->stok > 0 ? 'low' : ''); ?>">
                    <?php if($product->stok == 0): ?>
                        <i class="fa fa-ban"></i> Habis
                    <?php elseif($product->stok <= 10): ?>
                        <i class="fa fa-triangle-exclamation"></i> Stok: <?php echo e($product->stok); ?>

                    <?php else: ?>
                        <i class="fa fa-check-circle" style="color:var(--green)"></i> Stok: <?php echo e($product->stok); ?>

                    <?php endif; ?>
                </div>
                <div class="add-badge"><i class="fa fa-plus" style="font-size:11px"></i></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- ── Cart Panel ── -->
    <div class="panel-cart">
        <div class="cart-header">
            <span><i class="fa fa-cart-shopping" style="color:var(--accent)"></i> Keranjang</span>
            <button class="btn btn-ghost btn-sm" onclick="clearCart()">
                <i class="fa fa-trash"></i> Kosongkan
            </button>
        </div>
        <div class="cart-body" id="cartBody">
            <div class="cart-empty" id="cartEmpty">
                <i class="fa fa-cart-shopping"></i>
                <span>Keranjang masih kosong<br>Klik produk untuk menambahkan</span>
            </div>
            <div id="cartItems"></div>
        </div>

        <div class="diskon-info hidden" id="diskonInfo">
            <i class="fa fa-tag"></i>
            <span>🎉 Selamat! Anda mendapat <strong>diskon 5%</strong> karena ada item dengan qty ≥ 10!</span>
        </div>

        <div class="cart-footer">
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotalDisplay">Rp 0</span>
            </div>
            <div class="summary-row discount" id="diskonRow" style="display:none">
                <span>Diskon (5%)</span>
                <span id="diskonDisplay">- Rp 0</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="totalDisplay" style="font-family:'Space Mono',monospace;color:var(--accent)">Rp 0</span>
            </div>
            <div class="bayar-input-wrap">
                <label>Uang Bayar</label>
                <input type="number" id="bayarInput" placeholder="0" min="0" step="100" inputmode="numeric" oninput="hitungKembalian()">
            </div>
            <div class="quick-cash" aria-label="Nominal cepat">
                <button type="button" class="chip" onclick="setBayarQuick(20000)">20k</button>
                <button type="button" class="chip" onclick="setBayarQuick(50000)">50k</button>
                <button type="button" class="chip" onclick="setBayarQuick(100000)">100k</button>
                <button type="button" class="chip" onclick="setBayarQuick(200000)">200k</button>
                <button type="button" class="chip primary" onclick="setBayarPas()">Uang pas</button>
            </div>
            <div class="kembalian-box" id="kembalianBox" style="display:none">
                <span class="label"><i class="fa fa-coins"></i> Kembalian</span>
                <span class="value" id="kembalianDisplay">Rp 0</span>
            </div>
            <button class="btn-bayar" id="btnBayar" disabled onclick="prosesTransaksi()">
                <i class="fa fa-check-circle"></i> Bayar
            </button>
        </div>
    </div>
</div>

<!-- ── Modal Sukses ── -->
<div class="modal-overlay" id="modalSukses">
    <div class="modal-box">
        <div class="modal-icon"><i class="fa fa-check"></i></div>
        <div class="modal-title">Transaksi Berhasil!</div>
        <div class="modal-sub" id="modalNoTransaksi"></div>
        <div id="modalStrukRows"></div>
        <div class="modal-actions">
            <a id="btnCetakStruk" href="#" target="_blank" class="btn btn-ghost">
                <i class="fa fa-print"></i> Struk
            </a>
            <button class="btn btn-primary" onclick="tutupModal()">
                <i class="fa fa-arrow-right"></i> Transaksi Baru
            </button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// ─── State ────────────────────────────────────────────────────────────────────
let cart = {}; // { id: { nama, harga, stok, qty } }
const DISKON_MINIMAL_QTY = 10;
const DISKON_MINIMAL_ITEM_BERBEDA = 10;
const DISKON_PERSEN = 5;

// ─── Format Rupiah ─────────────────────────────────────────────────────────
function rp(n) {
    return 'Rp ' + Number(n).toLocaleString('id-ID');
}

function getTotalNow() {
    const subtotal = Object.values(cart).reduce((s,i) => s + i.harga*i.qty, 0);
    const itemValues = Object.values(cart);
    const diskonDariQty = itemValues.some(i => i.qty >= DISKON_MINIMAL_QTY);
    const diskonDariBarangBerbeda = Object.keys(cart).length >= DISKON_MINIMAL_ITEM_BERBEDA;
    const diskon = (diskonDariQty || diskonDariBarangBerbeda) ? subtotal * DISKON_PERSEN / 100 : 0;
    return { subtotal, diskon, total: subtotal - diskon, dapatDiskon: diskon > 0 };
}

function setBayarQuick(nominal) {
    const inp = document.getElementById('bayarInput');
    inp.value = String(nominal);
    hitungKembalian();
    inp.focus();
}

function setBayarPas() {
    const { total } = getTotalNow();
    setBayarQuick(Math.ceil(total));
}

// ─── Tambah ke Cart ───────────────────────────────────────────────────────
function tambahKeCart(el) {
    const stok = parseInt(el.dataset.stok);
    if (stok === 0) return;
    const id   = el.dataset.id;
    if (cart[id]) {
        if (cart[id].qty >= stok) { alert('Stok tidak mencukupi!'); return; }
        cart[id].qty++;
    } else {
        cart[id] = { nama: el.dataset.nama, harga: parseFloat(el.dataset.harga), stok, qty: 1 };
    }
    renderCart();
}

// ─── Ubah Qty ─────────────────────────────────────────────────────────────
function ubahQty(id, delta) {
    if (!cart[id]) return;
    const newQty = cart[id].qty + delta;
    if (newQty <= 0)              { hapusItem(id); return; }
    if (newQty > cart[id].stok)   { alert('Stok tidak mencukupi!'); return; }
    cart[id].qty = newQty;
    renderCart();
}
function setQty(id, val) {
    if (!cart[id]) return;
    const v = parseInt(val) || 1;
    if (v <= 0)            { hapusItem(id); return; }
    if (v > cart[id].stok) { alert('Stok tidak mencukupi!'); return; }
    cart[id].qty = v;
    renderCart();
}
function hapusItem(id) {
    delete cart[id];
    renderCart();
}
function clearCart() {
    if (Object.keys(cart).length && !confirm('Kosongkan keranjang?')) return;
    cart = {};
    renderCart();
}

// ─── Hitung & Render Cart ─────────────────────────────────────────────────
function renderCart() {
    const ids = Object.keys(cart);
    const empty  = document.getElementById('cartEmpty');
    const items  = document.getElementById('cartItems');

    if (ids.length === 0) {
        empty.style.display  = 'flex';
        items.innerHTML      = '';
        updateSummary(0, 0, 0);
        return;
    }
    empty.style.display = 'none';

    let subtotal = 0;
    let html = '';
    let mendapatDiskon = false;
    const jumlahBarangBerbeda = ids.length;

    ids.forEach(id => {
        const item = cart[id];
        const sub  = item.harga * item.qty;
        subtotal  += sub;
        if (item.qty >= DISKON_MINIMAL_QTY) mendapatDiskon = true;

        html += `
        <div class="cart-item">
            <div class="cart-item-top">
                <div>
                    <div class="cart-item-nama">${item.nama}</div>
                    <div class="cart-item-harga">${rp(item.harga)} / ${item.qty >= DISKON_MINIMAL_QTY ? '<span style="color:var(--accent)">✨ qty ≥10 diskon!</span>' : 'pcs'}</div>
                </div>
                <button class="remove-btn" onclick="hapusItem('${id}')"><i class="fa fa-xmark"></i></button>
            </div>
            <div class="cart-item-bottom">
                <div class="qty-ctrl">
                    <button class="qty-btn" onclick="ubahQty('${id}', -1)">−</button>
                    <input class="qty-input" type="number" value="${item.qty}" min="1" max="${item.stok}"
                           onchange="setQty('${id}', this.value)">
                    <button class="qty-btn" onclick="ubahQty('${id}', 1)">+</button>
                </div>
                <span class="item-subtotal">${rp(sub)}</span>
            </div>
        </div>`;
    });

    items.innerHTML = html;

    mendapatDiskon = mendapatDiskon || jumlahBarangBerbeda >= DISKON_MINIMAL_ITEM_BERBEDA;
    const diskonNominal = mendapatDiskon ? subtotal * DISKON_PERSEN / 100 : 0;
    const total         = subtotal - diskonNominal;

    updateSummary(subtotal, diskonNominal, total, mendapatDiskon);
    hitungKembalian();

    // Diskon banner
    const diskonInfo = document.getElementById('diskonInfo');
    diskonInfo.classList.toggle('hidden', !mendapatDiskon);
    if (mendapatDiskon) {
        const pakaiBarangBerbeda = jumlahBarangBerbeda >= DISKON_MINIMAL_ITEM_BERBEDA;
        diskonInfo.querySelector('span').innerHTML = pakaiBarangBerbeda
            ? '🎉 Selamat! Anda mendapat <strong>diskon 5%</strong> karena membeli <strong>10 barang berbeda</strong>!'
            : '🎉 Selamat! Anda mendapat <strong>diskon 5%</strong> karena ada item dengan qty ≥ 10!';
    }
}

function updateSummary(subtotal, diskon, total, mendapatDiskon = false) {
    document.getElementById('subtotalDisplay').textContent = rp(subtotal);
    document.getElementById('totalDisplay').textContent    = rp(total);

    const diskonRow = document.getElementById('diskonRow');
    diskonRow.style.display = mendapatDiskon ? 'flex' : 'none';
    document.getElementById('diskonDisplay').textContent = '- ' + rp(diskon);
}

function hitungKembalian() {
    const { total } = getTotalNow();
    const bayar      = parseFloat(document.getElementById('bayarInput').value) || 0;
    const kembalian  = bayar - total;
    const kembBox    = document.getElementById('kembalianBox');
    const btnBayar   = document.getElementById('btnBayar');

    if (bayar > 0) {
        kembBox.style.display = 'flex';
        kembBox.classList.toggle('minus', kembalian < 0);
        if (kembalian >= 0) {
            kembBox.querySelector('.label').innerHTML = '<i class="fa fa-coins"></i> Kembalian';
            document.getElementById('kembalianDisplay').textContent = rp(kembalian);
        } else {
            kembBox.querySelector('.label').innerHTML = '<i class="fa fa-circle-xmark"></i> Kurang';
            document.getElementById('kembalianDisplay').textContent = rp(Math.abs(kembalian));
        }
    } else {
        kembBox.style.display = 'none';
    }

    btnBayar.disabled = !(Object.keys(cart).length > 0 && bayar >= total && total > 0);
}

// ─── Filter & Search ──────────────────────────────────────────────────────
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        filterProduk();
    });
});
document.getElementById('searchInput').addEventListener('input', filterProduk);

function filterProduk() {
    const kat  = document.querySelector('.filter-tab.active').dataset.kat;
    const cari = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.produk-card').forEach(el => {
        const matchKat  = kat === 'all' || el.dataset.kat === kat;
        const matchCari = el.dataset.nama.toLowerCase().includes(cari) || el.dataset.kode.toLowerCase().includes(cari);
        el.style.display = matchKat && matchCari ? '' : 'none';
    });
}

// ─── Proses Transaksi ─────────────────────────────────────────────────────
async function prosesTransaksi() {
    const bayar = parseFloat(document.getElementById('bayarInput').value) || 0;
    const items = Object.entries(cart).map(([id, item]) => ({ id, qty: item.qty }));

    document.getElementById('btnBayar').disabled = true;

    try {
        const res = await fetch('<?php echo e(route("kasir.proses")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ items, bayar }),
        });
        const ct = (res.headers.get('content-type') || '').toLowerCase();
        let data = null;
        if (ct.includes('application/json')) {
            data = await res.json();
        } else {
            const text = await res.text();
            throw new Error(text?.slice?.(0, 200) || 'Respons tidak valid');
        }

        if (res.ok && data?.success) {
            tampilModalSukses(data);
        } else {
            const msg = data?.message || 'Terjadi kesalahan saat memproses pembayaran.';
            if (window.toast) window.toast(msg, 'error', 'Pembayaran gagal', 3200);
            else alert('Error: ' + msg);
            document.getElementById('btnBayar').disabled = false;
        }
    } catch (e) {
        const msg = String(e?.message || e || 'Terjadi kesalahan koneksi.');
        if (window.toast) window.toast(msg, 'error', 'Pembayaran gagal', 3600);
        else alert('Terjadi kesalahan koneksi!');
        document.getElementById('btnBayar').disabled = false;
    }
}

function tampilModalSukses(data) {
    document.getElementById('modalNoTransaksi').textContent = 'No. Transaksi: ' + data.no_transaksi;
    document.getElementById('btnCetakStruk').href = '<?php echo e(url("/kasir")); ?>/' + data.transaction_id + '/struk';

    let html = '';
    const rows = [
        ['Subtotal', rp(data.subtotal)],
        ...(data.dapat_diskon ? [['Diskon 5%', '- ' + rp(data.diskon_nominal)]] : []),
        ['Total', rp(data.total)],
        ['Bayar', rp(data.bayar)],
        ['Kembalian', rp(data.kembalian)],
    ];
    rows.forEach(([k, v]) => {
        html += `<div class="struk-row"><span>${k}</span><span class="${k==='Total'?'struk-total':''}">${v}</span></div>`;
    });
    if (data.dapat_diskon) {
        html += `<div style="text-align:center;margin-top:12px;padding:8px;background:rgba(245,197,66,.1);border-radius:8px;font-size:12px;color:var(--accent)">🎉 Diskon 5% berhasil diterapkan!</div>`;
    }
    document.getElementById('modalStrukRows').innerHTML = html;
    document.getElementById('modalSukses').classList.add('show');
    if (window.toast) window.toast('Transaksi tersimpan. Silakan cetak struk bila perlu.', 'success', 'Berhasil', 2200);
}

function tutupModal() {
    document.getElementById('modalSukses').classList.remove('show');
    cart = {};
    document.getElementById('bayarInput').value = '';
    document.getElementById('kembalianBox').style.display = 'none';
    renderCart();
    // Reload halaman agar stok ter-refresh
    setTimeout(() => location.reload(), 300);
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alnitak/Downloads/kasir-laravel/resources/views/kasir/index.blade.php ENDPATH**/ ?>