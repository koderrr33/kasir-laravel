<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk - <?php echo e($transaction->no_transaksi); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 300px;
            margin: 0 auto;
            padding: 16px;
            color: #000;
            background: #fff;
        }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 8px 0; }
        .row { display: flex; justify-content: space-between; margin: 3px 0; }
        .indent { padding-left: 8px; font-size: 11px; }
        .total { font-size: 14px; font-weight: bold; }
        .diskon { color: #555; }
        @media print {
            body { width: 80mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="center bold" style="font-size:16px">TokoKu POS</div>
    <div class="center" style="font-size:11px">Jl. Contoh No.1, Kota Anda</div>
    <div class="center" style="font-size:11px">Telp: 021-12345678</div>
    <div class="divider"></div>
    <div class="row">
        <span>No. Trx</span>
        <span class="bold"><?php echo e($transaction->no_transaksi); ?></span>
    </div>
    <div class="row">
        <span>Tanggal</span>
        <span><?php echo e($transaction->created_at->format('d/m/Y H:i')); ?></span>
    </div>
    <div class="row">
        <span>Kasir</span>
        <span><?php echo e($transaction->kasir); ?></span>
    </div>
    <div class="divider"></div>

    <?php $__currentLoopData = $transaction->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="bold"><?php echo e($item->nama_produk); ?></div>
    <div class="row indent">
        <span><?php echo e($item->qty); ?> x Rp <?php echo e(number_format($item->harga_satuan, 0, ',', '.')); ?></span>
        <span>Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></span>
    </div>
    <?php if($item->qty >= 10): ?>
    <div class="indent diskon">*Item diskon 5%</div>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="divider"></div>
    <div class="row">
        <span>Subtotal</span>
        <span>Rp <?php echo e(number_format($transaction->subtotal, 0, ',', '.')); ?></span>
    </div>
    <?php if($transaction->diskon_persen > 0): ?>
    <div class="row diskon">
        <span>Diskon <?php echo e($transaction->diskon_persen); ?>%</span>
        <span>- Rp <?php echo e(number_format($transaction->diskon_nominal, 0, ',', '.')); ?></span>
    </div>
    <?php endif; ?>
    <div class="divider"></div>
    <div class="row total">
        <span>TOTAL</span>
        <span>Rp <?php echo e(number_format($transaction->total, 0, ',', '.')); ?></span>
    </div>
    <div class="row">
        <span>Bayar</span>
        <span>Rp <?php echo e(number_format($transaction->bayar, 0, ',', '.')); ?></span>
    </div>
    <div class="row bold">
        <span>Kembalian</span>
        <span>Rp <?php echo e(number_format($transaction->kembalian, 0, ',', '.')); ?></span>
    </div>
    <div class="divider"></div>
    <?php if($transaction->diskon_persen > 0): ?>
    <div class="center" style="font-size:11px;margin:6px 0">
        *** Anda hemat Rp <?php echo e(number_format($transaction->diskon_nominal, 0, ',', '.')); ?> ***
    </div>
    <?php endif; ?>
    <div class="center" style="margin-top:8px;font-size:11px">Terima kasih sudah berbelanja!</div>
    <div class="center" style="font-size:10px;margin-top:4px;color:#555">Barang yang sudah dibeli<br>tidak dapat dikembalikan</div>

    <div class="no-print" style="text-align:center;margin-top:20px">
        <button onclick="window.print()" style="padding:10px 24px;cursor:pointer;font-size:13px">🖨️ Cetak</button>
    </div>
    <script>
        window.onload = () => window.print();
    </script>
</body>
</html>
<?php /**PATH /home/alnitak/Downloads/kasir-laravel/resources/views/kasir/struk.blade.php ENDPATH**/ ?>