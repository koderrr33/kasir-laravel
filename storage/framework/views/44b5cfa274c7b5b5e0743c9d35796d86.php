<?php $__env->startSection('title', 'Data Produk'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:20px;font-weight:800">Data Produk (<?php echo e($products->total()); ?>)</h2>
    <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">
        <i class="fa fa-plus"></i> Tambah Produk
    </a>
</div>

<div class="card">
    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th style="text-align:right">Harga</th>
                    <th style="text-align:center">Stok</th>
                    <th>Satuan</th>
                    <th style="text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="color:var(--muted)"><?php echo e($products->firstItem() + $i); ?></td>
                    <td>
                        <span style="font-family:'Space Mono',monospace;font-size:12px;color:var(--accent)">
                            <?php echo e($p->kode); ?>

                        </span>
                    </td>
                    <td style="font-weight:600"><?php echo e($p->nama); ?></td>
                    <td>
                        <span style="background:var(--surface);border:1px solid var(--border);padding:3px 10px;border-radius:99px;font-size:11px;color:var(--muted)">
                            <?php echo e($p->kategori); ?>

                        </span>
                    </td>
                    <td style="text-align:right;font-family:'Space Mono',monospace;font-size:13px;font-weight:700">
                        Rp <?php echo e(number_format($p->harga, 0, ',', '.')); ?>

                    </td>
                    <td style="text-align:center">
                        <span style="font-weight:700;color:<?php echo e($p->stok == 0 ? 'var(--red)' : ($p->stok <= 10 ? 'var(--accent2)' : 'var(--green)')); ?>">
                            <?php echo e($p->stok); ?>

                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:13px"><?php echo e($p->satuan); ?></td>
                    <td style="text-align:center">
                        <a href="<?php echo e(route('products.edit', $p)); ?>" class="btn btn-ghost btn-sm">
                            <i class="fa fa-pen"></i>
                        </a>
                        <form action="<?php echo e(route('products.destroy', $p)); ?>" method="POST" style="display:inline"
                              onsubmit="return confirm('Hapus produk <?php echo e($p->nama); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:var(--muted)">Belum ada produk</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($products->hasPages()): ?>
    <div style="padding:16px 20px;border-top:1px solid var(--border)"><?php echo e($products->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alnitak/Downloads/kasir-laravel/resources/views/products/index.blade.php ENDPATH**/ ?>