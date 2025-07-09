<?php $__env->startSection('title', 'Daftar Menu'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 fw-bold mb-0">Daftar Menu</h2>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isPenjual()): ?>
                        <a href="<?php echo e(route('penjual.menu.create')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Tambah Menu
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Total Menu:</span>
                        <span id="menuCounter" class="badge bg-primary rounded-pill">
                            <?php echo e($menus->total()); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu List -->
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <?php if($menu->gambar): ?>
                    <div class="position-relative" style="height: 180px; overflow: hidden;">
                        <img src="<?php echo e($menu->photo_url); ?>" class="img-fluid w-100 h-100" alt="<?php echo e($menu->nama_menu); ?>" style="object-fit: cover;">
                    </div>
                <?php else: ?>
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                        <i class="fas fa-utensils fa-4x text-muted"></i>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-1"><?php echo e($menu->nama_menu); ?></h5>
                        <span class="badge bg-primary"><?php echo e($menu->area_kampus); ?></span>
                    </div>
                    <p class="text-muted small mb-2"><?php echo e($menu->nama_warung); ?></p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?php if($i <= $menu->rating): ?>
                                    <i class="fas fa-star text-warning"></i>
                                <?php else: ?>
                                    <i class="far fa-star text-muted"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <span class="small ms-1">(<?php echo e($menu->rating); ?>)</span>
                        </div>
                        <span class="fw-bold">Rp <?php echo e(number_format($menu->harga, 0, ',', '.')); ?></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <?php if($menu->stok > 0): ?>
                            <span class="badge bg-success bg-opacity-10 text-success">Tersedia (<?php echo e($menu->stok); ?>)</span>
                        <?php else: ?>
                            <span class="badge bg-danger bg-opacity-10 text-danger">Habis</span>
                        <?php endif; ?>
                        
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->isPembeli()): ?>
                                <button class="btn btn-sm btn-primary" onclick="addToCart(<?php echo e($menu->id); ?>)">
                                    <i class="fas fa-cart-plus me-1"></i> Pesan
                                </button>
                            <?php elseif(auth()->user()->isPenjual()): ?>
                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('penjual.menu.edit', $menu->id)); ?>" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit Menu">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('penjual.menu.destroy', $menu->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Menu"
                                                onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="alert alert-info mb-0">
                <i class="fas fa-info-circle me-2"></i> Tidak ada menu yang tersedia saat ini.
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($menus->hasPages()): ?>
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <?php echo e($menus->links('pagination::bootstrap-5')); ?>

        </nav>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function addToCart(menuId) {
        // Implementasi fungsi addToCart
        alert('Menambahkan menu ke keranjang: ' + menuId);
    }

    // Function to update menu counter
    function updateMenuCounter(change) {
        const counterElement = document.getElementById('menuCounter');
        if (counterElement) {
            let currentCount = parseInt(counterElement.textContent) || 0;
            currentCount += change;
            counterElement.textContent = currentCount;
        }
    }

    // Handle menu deletion
    document.addEventListener('click', function(e) {
        if (e.target.closest('form[action*="/menu/"]') && 
            e.target.closest('form').getAttribute('action').includes('/menu/') &&
            confirm('Yakin ingin menghapus menu ini?')) {
            // Wait for the form to be submitted and page to reload
            // The counter will be updated on page load
            return true;
        }
    });

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Listen for Livewire events if using Livewire
        if (window.livewire) {
            window.livewire.on('menuAdded', () => updateMenuCounter(1));
            window.livewire.on('menuDeleted', () => updateMenuCounter(-1));
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\NganTeen-main\resources\views/menu/index.blade.php ENDPATH**/ ?>