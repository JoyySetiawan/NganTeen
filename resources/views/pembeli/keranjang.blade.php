@extends('layouts.pembeli')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h4 mb-4">
                <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
            </h2>
            
            @if($keranjang->count() > 0)
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center"></th>
                                        <th>Menu</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($keranjang as $item)
                                        <tr class="checkout-item" data-price="{{ $item->menu->harga }}" data-user-id="{{ $item->menu->user_id }}">
                                            <td class="text-center align-middle">
                                                <input type="checkbox" name="menu_ids[]" value="{{ $item->id }}" onchange="updateCheckoutItem(this)">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        @if($item->menu->gambar)
                                                            <img src="{{ Storage::url($item->menu->gambar) }}" alt="{{ $item->menu->nama_menu }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                                <i class="bi bi-image text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ $item->menu->nama_menu }}</h6>
                                                        <small class="text-muted">{{ $item->menu->nama_warung }}</small>
                                                        <div class="small text-muted">Stok: {{ $item->menu->stok }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                Rp {{ number_format($item->menu->harga, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center align-middle">
                                                <form action="{{ route('pembeli.cart.update', $item->id) }}" method="POST" class="d-flex align-items-center justify-content-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm" style="width: 120px;">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="this.form.querySelector('input[type=number]').stepDown(); this.form.submit()">-</button>
                                                        <input type="number" name="jumlah" class="form-control text-center" value="{{ $item->jumlah }}" min="1" max="{{ $item->menu->stok }}" onchange="this.form.submit()">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="this.form.querySelector('input[type=number]').stepUp(); this.form.submit()">+</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-end align-middle fw-bold">
                                                Rp {{ number_format($item->menu->harga * $item->jumlah, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end align-middle">
                                                <form action="{{ route('pembeli.cart.destroy', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Yakin ingin menghapus item ini?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                        <i class="bi bi-trash-fill fs-5"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Ringkasan Belanja</h5>
                            <div id="total-price" class="h4 mb-0 fw-bold text-primary">
                                Rp {{ number_format($total, 0, ',', '.') }}

                            </div>
                        </div>
                        



                        <form id="checkout-form" action="{{ url('/pembeli/payment') }}" method="GET" data-base-action="{{ url('/pembeli/payment') }}">
                            @csrf
                            <button id="checkout-button" type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-credit-card me-2"></i>Lanjut ke Pembayaran
                            </button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('pembeli.menu.index') }}" class="text-decoration-none">
                                <i class="bi bi-arrow-left me-1"></i> Lanjutkan Belanja
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-cart-x display-1 text-muted"></i>
                        </div>
                        <h3 class="h4 mb-3">Keranjang Belanja Kosong</h3>
                        <p class="text-muted mb-4">Belum ada item di keranjang Anda. Ayo mulai belanja!</p>
                        <a href="{{ route('pembeli.menu.index') }}" class="btn btn-primary">
                            <i class="bi bi-shop me-1"></i> Lihat Menu
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Helper: format number as 1.234 with Indonesian locale
function formatNumber(value) {
    return value.toLocaleString('id-ID');
}
// Helper: prefix number with 'Rp '
function formatRupiah(value) {
    return 'Rp ' + formatNumber(value);
}
// Simple quantity update handler
function updateQuantity(input, menuId) {
    const value = parseInt(input.value);
    const max = parseInt(input.getAttribute('max'));
    
    // Validate input
    if (isNaN(value) || value < 1) {
        input.value = 1;
    } else if (value > max) {
        input.value = max;
    }
    
    updateOrderSummary();
}

// Update order summary (total items and price)
function updateOrderSummary() {
    let totalItems = 0;
    let totalPrice = 0;
    let hasSelectedItems = false;
    
        const allCheckboxes = document.querySelectorAll('input[type="checkbox"][name^="menu_ids"]');
    const useSelection = allCheckboxes.length > 0;

    document.querySelectorAll('.checkout-item').forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
        if (!useSelection || (checkbox && checkbox.checked)) {
            hasSelectedItems = true;
            const quantity = parseInt(item.querySelector('input[type="number"]').value);
            const price = parseFloat(item.dataset.price);
            totalItems += quantity;
            totalPrice += price * quantity;
        }
    });
    
    // Update total price display
    const totalPriceEl = document.getElementById('total-price');
    if (totalPriceEl) totalPriceEl.textContent = formatRupiah(totalPrice);
    
    // Toggle checkout button state based on selection
    const checkoutBtn = document.getElementById('checkout-button');
    if (checkoutBtn) {
        checkoutBtn.disabled = !hasSelectedItems;
    }
}

// Wrapper function to keep backward compatibility with legacy calls
function updateCheckoutItem(_checkbox) {
    // Simply recompute the totals whenever a checkbox state changes
    updateOrderSummary();
}

// Validate form before submission
function validateCheckout() {
    // Allow checkout if cart uses no selection checkboxes
    const allCheckboxes = document.querySelectorAll('input[type="checkbox"][name^="menu_ids"]');
    if (allCheckboxes.length === 0) {
        return true;
    }
        const checked = document.querySelectorAll('input[type="checkbox"][name^="menu_ids"]:checked');
    if (checked.length === 0) {
                const msg = document.getElementById('no-items-selected');
        if (msg) msg.classList.remove('hidden');
        return false;
    }
    return true;
}

// Initialize the checkout page
// Handle form submission with SweetAlert2
function handleCheckout(e) {
    const form = e.target;
    // If SweetAlert (Swal) not available, submit immediately
    if (typeof Swal === 'undefined') {
        return form.submit();
    }
    e.preventDefault();
    
    if (!validateCheckout()) return false;
    
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonContent = submitButton.innerHTML;
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.innerHTML = '<div class="spinner"></div> Memproses...';
    
    // Get selected items for confirmation
    const selectedItems = [];
    let totalQuantity = 0;
    let totalPrice = 0;

    const allCheckboxes = document.querySelectorAll('input[type="checkbox"][name^="menu_ids"]');
    const useSelection = allCheckboxes.length > 0;

    document.querySelectorAll('.checkout-item').forEach(item => {
        const checkbox = item.querySelector('input[type="checkbox"]');
        if (!useSelection || (checkbox && checkbox.checked)) {
            const nameEl = item.querySelector('label span:first-child') || item.querySelector('h6');
            const name = nameEl ? nameEl.textContent.trim() : 'Item';
            const quantity = parseInt(item.querySelector('input[type="number"]').value);
            const price = parseFloat(item.dataset.price) * quantity;

            selectedItems.push({ name, quantity, price });
            totalQuantity += quantity;
            totalPrice += price;
        }
    });
    
    // Format the confirmation message with better styling
    const confirmationHTML = `
        <div class="text-left">
            <div class="mb-4">
                <div class="flex items-center text-green-600 mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-medium">${selectedItems.length} item dipilih (${totalQuantity} total)</span>
                </div>
                <div class="text-sm text-gray-600">Silakan periksa kembali pesanan Anda sebelum melanjutkan.</div>
            </div>
            
            <div class="max-h-60 overflow-y-auto custom-scrollbar border rounded-lg p-3 mb-4">
                ${selectedItems.map((item, index) => `
                    <div class="mb-3 pb-3 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0 animate-fadeInUp" style="animation-delay: ${index * 0.05}s">
                        <div class="font-medium text-gray-800">${item.name}</div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-sm text-gray-600">${item.quantity} × Rp ${formatNumber(item.price / item.quantity)}</span>
                            <span class="font-medium text-gray-800">Rp ${formatNumber(item.price)}</span>
                        </div>
                    </div>
                `).join('')}
            </div>
            
            <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded-r">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-orange-700">
                            Pembayaran dilakukan langsung di kantin setelah pesanan siap diambil.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex justify-between items-center text-lg font-semibold">
                    <span>Total Pembayaran</span>
                    <div class="flex items-center">
                        <span class="text-2xl text-orange-600">Rp ${formatNumber(totalPrice)}</span>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Show confirmation dialog with better styling
    Swal.fire({
        title: 'Konfirmasi Pesanan',
        html: confirmationHTML,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10B981',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Lanjutkan Pembayaran',
        cancelButtonText: 'Periksa Kembali',
        reverseButtons: true,
        allowOutsideClick: false,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve) => {
                // Add a small delay to show the loading state
                setTimeout(() => {
                    resolve();
                }, 500);
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form
            form.submit();
        } else {
            // Reset button state
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonContent;
        }
    });
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Update order summary on page load
    updateOrderSummary();
    
    // Add event listeners to all checkboxes
    document.querySelectorAll('input[type="checkbox"][name^="menu_ids"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateCheckoutItem(this);
        });
    });
    
    // Add select all functionality

    
    // Prevent form submission on Enter key in quantity inputs
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    });
    
    // Add form submit handler
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', handleCheckout);
    }
});
</script>
@endpush
@endsection