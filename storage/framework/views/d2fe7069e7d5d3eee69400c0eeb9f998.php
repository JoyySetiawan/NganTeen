<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2 class="h4 mb-4">
        <i class="bi bi-credit-card me-2"></i> Pembayaran
    </h2>

    <?php if($qrisUrl): ?>
        <div class="text-center">
            <img src="<?php echo e($qrisUrl); ?>" alt="QRIS <?php echo e($seller?->name); ?>" class="img-fluid" style="max-width:300px">
        </div>
        <p class="text-center mt-3">Silakan scan QRIS di atas untuk melakukan pembayaran ke <?php echo e($seller?->name); ?>.</p>
    <?php else: ?>
        <div class="alert alert-warning">
            QRIS belum tersedia untuk toko ini.
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="<?php echo e(route('pembeli.dashboard')); ?>" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="<?php echo e(route('pembeli.orders.index')); ?>" class="btn btn-success">
            <i class="bi bi-check2-circle"></i> Saya Sudah Bayar
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.pembeli', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\NganTeen-main\resources\views/pembeli/payment.blade.php ENDPATH**/ ?>