<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Kelola Pesanan
                    </h4>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2">
                            Total Pendapatan: Rp<?php echo e(number_format($totalRevenue)); ?>

                        </span>
                        <span class="badge bg-secondary">
                            <?php echo e($orders->total()); ?> Pesanan
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="GET" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Status Pesanan</label>
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                                        <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>Diproses</option>
                                        <option value="siap_diambil" <?php echo e(request('status') == 'siap_diambil' ? 'selected' : ''); ?>>Siap Diambil</option>
                                        <option value="selesai" <?php echo e(request('status') == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                                        <option value="batal" <?php echo e(request('status') == 'batal' ? 'selected' : ''); ?>>Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Dari Tanggal</label>
                                    <input type="date" name="from_date" value="<?php echo e(request('from_date')); ?>" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Sampai Tanggal</label>
                                    <input type="date" name="to_date" value="<?php echo e(request('to_date')); ?>" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Cari Nama Pembeli</label>
                                    <div class="input-group">
                                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Nama pembeli...">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="<?php echo e(route('penjual.orders.index')); ?>" class="btn btn-outline-secondary">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php if($orders->isEmpty()): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada pesanan ditemukan</h5>
                            <p class="text-muted">Coba ubah filter pencarian Anda</p>
                            <a href="<?php echo e(route('penjual.orders.index')); ?>" class="btn btn-primary mt-3">
                                <i class="fas fa-sync me-2"></i>Reset Filter
                            </a>
                        </div>
                    <?php else: ?>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">
                                            <i class="fas fa-receipt me-2"></i>Pesanan #<?php echo e($order->id); ?>

                                        </h5>
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span class="badge bg-secondary">
                                                <i class="far fa-calendar-alt me-1"></i><?php echo e($order->created_at->format('d M Y, H:i')); ?>

                                            </span>
                                            <span class="badge bg-light text-dark">
                                                <i class="fas fa-user me-1"></i><?php echo e($order->user->name); ?>

                                            </span>
                                            <?php if($order->payment_method): ?>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-credit-card me-1"></i><?php echo e(ucfirst($order->payment_method)); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php
                                            $statusClasses = [
                                                'pending' => 'bg-warning text-dark',
                                                'processing' => 'bg-info text-white',
                                                'siap_diambil' => 'bg-primary text-white',
                                                'selesai' => 'bg-success text-white',
                                                'batal' => 'bg-danger text-white',
                                                'cancelled' => 'bg-danger text-white',
                                            ];
                                            $statusTexts = [
                                                'pending' => 'Menunggu Konfirmasi',
                                                'processing' => 'Sedang Diproses',
                                                'siap_diambil' => 'Siap Diambil',
                                                'selesai' => 'Selesai',
                                                'batal' => 'Dibatalkan',
                                                'cancelled' => 'Dibatalkan',
                                            ];
                                        ?>
                                        <span class="badge <?php echo e($statusClasses[$order->status] ?? 'bg-secondary'); ?> px-3 py-2">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                            <?php echo e($statusTexts[$order->status] ?? $order->status); ?>

                                        </span>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <!-- Order Items -->
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50%;">Menu</th>
                                                    <th class="text-end" style="width: 15%;">Harga</th>
                                                    <th class="text-center" style="width: 10%;">Jumlah</th>
                                                    <th class="text-end" style="width: 25%;">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $orderTotal = 0;
                                                ?>
                                                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $subtotal = $item->menu->harga * $item->quantity;
                                                        $orderTotal += $subtotal;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <?php if($item->menu->gambar): ?>
                                                                    <img src="<?php echo e(asset('storage/' . $item->menu->gambar)); ?>" 
                                                                         alt="<?php echo e($item->menu->nama_menu); ?>" 
                                                                         class="img-thumbnail me-3" 
                                                                         style="width: 64px; height: 64px; object-fit: cover;">
                                                                <?php else: ?>
                                                                    <div class="bg-light d-flex align-items-center justify-content-center me-3" 
                                                                         style="width: 64px; height: 64px;">
                                                                        <i class="fas fa-utensils fa-2x text-muted"></i>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div>
                                                                    <h6 class="mb-1"><?php echo e($item->menu->nama_menu); ?></h6>
                                                                    <div class="d-flex flex-wrap gap-2">
                                                                        <span class="badge bg-light text-dark">
                                                                            <i class="fas fa-tag me-1"></i><?php echo e($item->menu->kategori); ?>

                                                                        </span>
                                                                        <?php if($item->menu->is_available): ?>
                                                                            <span class="badge bg-success">
                                                                                <i class="fas fa-check-circle me-1"></i>Tersedia
                                                                            </span>
                                                                        <?php else: ?>
                                                                            <span class="badge bg-danger">
                                                                                <i class="fas fa-times-circle me-1"></i>Habis
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">Rp<?php echo e(number_format($item->menu->harga, 0, ',', '.')); ?></td>
                                                        <td class="text-center">
                                                            <span class="badge bg-primary rounded-pill">
                                                                <?php echo e($item->quantity); ?>

                                                            </span>
                                                        </td>
                                                        <td class="text-end fw-bold">
                                                            Rp<?php echo e(number_format($subtotal, 0, ',', '.')); ?>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Order Summary -->
                                    <div class="row justify-content-end mt-3">
                                        <div class="col-md-4">
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td class="border-0">Subtotal</td>
                                                            <td class="text-end border-0">Rp<?php echo e(number_format($orderTotal, 0, ',', '.')); ?></td>
                                                        </tr>
                                                        <?php if($order->ongkir > 0): ?>
                                                            <tr>
                                                                <td class="border-0">Ongkos Kirim</td>
                                                                <td class="text-end border-0">Rp<?php echo e(number_format($order->ongkir, 0, ',', '.')); ?></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                        <?php if($order->diskon > 0): ?>
                                                            <tr>
                                                                <td class="border-0">Diskon</td>
                                                                <td class="text-end border-0 text-danger">-Rp<?php echo e(number_format($order->diskon, 0, ',', '.')); ?></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                        <tr class="table-light">
                                                            <td class="border-0"><strong>Total</strong></td>
                                                            <td class="text-end border-0">
                                                                <strong>Rp<?php echo e(number_format($order->total_harga, 0, ',', '.')); ?></strong>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notes and Actions -->
                                    <?php if($order->catatan || $order->cancellation_reason): ?>
                                        <div class="alert <?php echo e($order->cancellation_reason ? 'alert-danger' : 'alert-info'); ?> mt-3">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i class="fas <?php echo e($order->cancellation_reason ? 'fa-exclamation-triangle' : 'fa-sticky-note'); ?> me-2"></i>
                                                </div>
                                                <div>
                                                    <?php if($order->cancellation_reason): ?>
                                                        <strong>Alasan Pembatalan:</strong>
                                                        <p class="mb-0"><?php echo e($order->cancellation_reason); ?></p>
                                                    <?php else: ?>
                                                        <strong>Catatan Pesanan:</strong>
                                                        <p class="mb-0"><?php echo e($order->catatan); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php if($order->status === 'pending'): ?>
                                                <form action="<?php echo e(route('penjual.orders.update-status', $order)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-check me-1"></i> Proses Pesanan
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if($order->status === 'processing'): ?>
                                                <form action="<?php echo e(route('penjual.orders.update-status', $order)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <input type="hidden" name="status" value="siap_diambil">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check-double me-1"></i> Tandai Siap Diambil
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if($order->status === 'siap_diambil'): ?>
                                                <form action="<?php echo e(route('penjual.orders.update-status', $order)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-check-circle me-1"></i> Tandai Selesai
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if(in_array($order->status, ['pending', 'processing'])): ?>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#cancelOrderModal<?php echo e($order->id); ?>">
                                                    <i class="fas fa-times me-1"></i> Batalkan
                                                </button>

                                                <!-- Cancel Order Modal -->
                                                <div class="modal fade" id="cancelOrderModal<?php echo e($order->id); ?>" tabindex="-1" 
                                                     aria-labelledby="cancelOrderModalLabel<?php echo e($order->id); ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="cancelOrderModalLabel<?php echo e($order->id); ?>">
                                                                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Batalkan Pesanan #<?php echo e($order->id); ?>

                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="<?php echo e(route('penjual.orders.update-status', $order)); ?>" method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="status" value="batal">
                                                                    <div class="mb-3">
                                                                        <label for="cancellation_reason" class="form-label">
                                                                            <i class="fas fa-comment-dots me-1"></i>Alasan Pembatalan
                                                                        </label>
                                                                        <textarea class="form-control" id="cancellation_reason" 
                                                                                  name="cancellation_reason" rows="3" required
                                                                                  placeholder="Masukkan alasan pembatalan pesanan"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                        <i class="fas fa-times me-1"></i> Tutup
                                                                    </button>
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="fas fa-ban me-1"></i> Batalkan Pesanan
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="text-muted small">
                                            <i class="far fa-clock me-1"></i> <?php echo e($order->created_at->diffForHumans()); ?>

                                            <?php if($order->updated_at != $order->created_at): ?>
                                                <span class="ms-2" data-bs-toggle="tooltip" 
                                                      data-bs-placement="top" 
                                                      title="Terakhir diperbarui: <?php echo e($order->updated_at->format('d M Y, H:i')); ?>">
                                                    <i class="fas fa-sync-alt me-1"></i>Diperbarui
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="d-flex justify-content-center mt-4">
                            <?php echo e($orders->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.penjual', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\NganTeen-main\resources\views/penjual/orders/index.blade.php ENDPATH**/ ?>