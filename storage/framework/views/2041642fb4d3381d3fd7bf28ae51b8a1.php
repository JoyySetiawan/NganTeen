<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Menu</h5>
                    <a href="<?php echo e(route('penjual.menu.index')); ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('penjual.menu.update', $menu->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label for="nama_menu" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" id="nama_menu" name="nama_menu" 
                                   value="<?php echo e(old('nama_menu', $menu->nama_menu)); ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" id="harga" name="harga" 
                                       value="<?php echo e(old('harga', $menu->harga)); ?>" min="1000" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label">Stok Tersedia</label>
                                <input type="number" class="form-control" id="stok" name="stok" 
                                       value="<?php echo e(old('stok', $menu->stok)); ?>" min="0" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="area_kampus" class="form-label">Area Kampus <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['area_kampus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="area_kampus" name="area_kampus" required>
                                <option value="" disabled>Pilih Area Kampus</option>
                                <?php $__currentLoopData = ['Kampus A', 'Kampus B', 'Kampus C']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($area); ?>" <?php echo e(old('area_kampus', $menu->area_kampus) == $area ? 'selected' : ''); ?>><?php echo e($area); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['area_kampus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori Menu</label>
                            <div class="d-flex flex-wrap gap-3">
                                <?php $__currentLoopData = ['Makanan', 'Minuman', 'Snack', 'Paket', 'Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kategori" 
                                               id="kategori_<?php echo e($kategori); ?>" value="<?php echo e($kategori); ?>"
                                               <?php echo e(old('kategori', $menu->kategori) == $kategori ? 'checked' : ''); ?> required>
                                        <label class="form-check-label" for="kategori_<?php echo e($kategori); ?>">
                                            <?php echo e($kategori); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Menu</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo e(old('deskripsi', $menu->deskripsi)); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="nama_warung" class="form-label">Nama Warung</label>
                            <input type="text" class="form-control" id="nama_warung" name="nama_warung" 
                                   value="<?php echo e(old('nama_warung', $menu->nama_warung)); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="gambar" class="form-label">Gambar Menu</label>
                            <?php if($menu->gambar): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e(Storage::url($menu->gambar)); ?>" alt="<?php echo e($menu->nama_menu); ?>" 
                                         class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="<?php echo e(route('penjual.menu.index')); ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.penjual', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\NganTeen-main\resources\views/penjual/menu/edit.blade.php ENDPATH**/ ?>