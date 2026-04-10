<?php $__env->startSection('title', 'Tambah Produk'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:560px">
    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-ghost btn-sm" style="margin-bottom:20px">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>

    <div class="card">
        <div class="card-header">
            <span><i class="fa fa-plus" style="color:var(--accent)"></i> Tambah Produk Baru</span>
        </div>
        <div style="padding:24px">
            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul style="margin:0;padding-left:18px">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <form action="<?php echo e(route('products.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form-group">
                        <label>Kode Produk</label>
                        <input type="text" name="kode" value="<?php echo e(old('kode')); ?>" placeholder="MNM001" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <input type="text" name="kategori" value="<?php echo e(old('kategori')); ?>" placeholder="Minuman" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="nama" value="<?php echo e(old('nama')); ?>" placeholder="Nama lengkap produk" required>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" value="<?php echo e(old('harga')); ?>" placeholder="0" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" value="<?php echo e(old('stok', 0)); ?>" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Satuan</label>
                        <select name="satuan">
                            <?php $__currentLoopData = ['pcs','botol','bungkus','kaleng','kotak','buah','tube','kg','liter']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e(old('satuan') == $s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                    <i class="fa fa-save"></i> Simpan Produk
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/alnitak/Downloads/kasir-laravel/resources/views/products/create.blade.php ENDPATH**/ ?>