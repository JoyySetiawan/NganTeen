<?php $__env->startSection('title', 'Tambah Menu Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h2 class="h5 mb-0">Tambah Menu Baru</h2>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('penjual.menu.store')); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label for="nama_menu" class="form-label">Nama Menu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nama_menu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="nama_menu" name="nama_menu" value="<?php echo e(old('nama_menu')); ?>" required>
                            <?php $__errorArgs = ['nama_menu'];
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="harga" name="harga" value="<?php echo e(old('harga')); ?>" min="100" required>
                                </div>
                                <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="stok" name="stok" value="<?php echo e(old('stok', 1)); ?>" min="0" required>
                                <?php $__errorArgs = ['stok'];
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
unset($__errorArgs, $__bag); ?>" 
                                    id="area_kampus" name="area_kampus" required>
                                <option value="" disabled selected>Pilih Area Kampus</option>
                                <option value="Kampus A" <?php echo e(old('area_kampus') == 'Kampus A' ? 'selected' : ''); ?>>Kampus A</option>
                                <option value="Kampus B" <?php echo e(old('area_kampus') == 'Kampus B' ? 'selected' : ''); ?>>Kampus B</option>
                                <option value="Kampus C" <?php echo e(old('area_kampus') == 'Kampus C' ? 'selected' : ''); ?>>Kampus C</option>
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
                            <label for="nama_warung" class="form-label">Nama Warung <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nama_warung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="nama_warung" name="nama_warung" value="<?php echo e(old('nama_warung')); ?>" required>
                            <?php $__errorArgs = ['nama_warung'];
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

                        <div class="mb-4">
                            <label for="gambar" class="form-label">Foto Menu</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="gambar" name="gambar" accept="image/*">
                            <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                            <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            
                            <div class="mt-2" id="image-preview" style="display: none;">
                                <img id="preview" src="#" alt="Preview Gambar" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('penjual.menu.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Image preview
function readURL(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('image-preview');
            
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('gambar').addEventListener('change', function() {
    readURL(this);
});

// Form validation
(function () {
    'use strict'
    
    const forms = document.querySelectorAll('.needs-validation')
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.penjual', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\NganTeen-main\resources\views/penjual/menu/create.blade.php ENDPATH**/ ?>