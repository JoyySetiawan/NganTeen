<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Daftar Menu</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo e(route('penjual.menu.create')); ?>" class="btn btn-primary">
                Tambah Menu
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Warung</th>
                            <th>Area</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($menu->gambar): ?>
                                    <img src="<?php echo e(Storage::url($menu->gambar)); ?>" alt="<?php echo e($menu->nama_menu); ?>" width="50">
                                <?php else: ?>
                                    <span class="text-muted">No img</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($menu->nama_menu); ?></td>
                            <td>Rp <?php echo e(number_format($menu->harga, 0, ',', '.')); ?></td>
                            <td><?php echo e($menu->stok); ?></td>
                            <td><?php echo e($menu->nama_warung); ?></td>
                            <td><?php echo e($menu->area_kampus); ?></td>
                            <td>
                                <a href="<?php echo e(route('penjual.menu.edit', $menu->id)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="<?php echo e(route('penjual.menu.destroy', $menu->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus menu?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.penjual', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\NganTeen-main\resources\views/penjual/menu/index.blade.php ENDPATH**/ ?>