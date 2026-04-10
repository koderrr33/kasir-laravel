<?php $__env->startSection('title', 'Riwayat Transaksi'); ?>

<?php $__env->startSection('content'); ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <span style="font-family:'Space Mono',monospace;font-size:12px;color:var(--accent)">
                            <?php echo e($trx->no_transaksi); ?>

                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:12px">
                        <?php echo e($trx->created_at->format('d M Y H:i')); ?>

                    </td>
                    <td>
                        <span style="background:var(--surface);border:1px solid var(--border);padding:3px 10px;border-radius:99px;font-size:12px">
                            <?php echo e($trx->items->count()); ?> item
                        </span>
                    </td>
                    <td style="font-family:'Space Mono',monospace;font-size:13px">
                        Rp <?php echo e(number_format($trx->subtotal, 0, ',', '.')); ?>

                    </td>
                    <td>
                        <?php if($trx->diskon_persen > 0): ?>
                            <span style="color:var(--green);font-size:12px;font-weight:700">
                                <?php echo e($trx->diskon_persen); ?>%
                            </span>
                        <?php else: ?>
                            <span style="color:var(--muted)">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span style="font-family:'Space Mono',monospace;font-weight:700;font-size:14px;color:var(--accent)">
                            Rp <?php echo e(number_format($trx->total, 0, ',', '.')); ?>

                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:13px"><?php echo e($trx->kasir); ?></td>
                    <td>
                        <a href="<?php echo e(route('kasir.detail', $trx)); ?>" class="btn btn-ghost btn-sm">
                            <i class="fa fa-eye"></i> Detail
                        </a>
                        <a href="<?php echo e(route('kasir.struk', $trx)); ?>" target="_blank" class="btn btn-ghost btn-sm">
                            <i class="fa fa-print"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" style="text-align:center;color:var(--muted);padding:40px">
                        <i class="fa fa-receipt" style="font-size:32px;opacity:.3;display:block;margin-bottom:12px"></i>
                        Belum ada transaksi
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($transactions->hasPages()): ?>
    <div style="padding:16px 20px;border-top:1px solid var(--border)">
        <?php echo e($transactions->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alnitak/Downloads/kasir-laravel/resources/views/kasir/riwayat.blade.php ENDPATH**/ ?>