@extends('layouts.pembeli')

@section('content')
<div class="container py-4">
    <h2 class="h4 mb-4">
        <i class="bi bi-credit-card me-2"></i> Pembayaran
    </h2>

    @if($qrisUrl)
        <div class="text-center">
            <img src="{{ $qrisUrl }}" alt="QRIS {{ $seller?->name }}" class="img-fluid" style="max-width:300px">
        </div>
        <p class="text-center mt-3">Silakan scan QRIS di atas untuk melakukan pembayaran ke {{ $seller?->name }}.</p>
    @else
        <div class="alert alert-warning">
            QRIS belum tersedia untuk toko ini.
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('pembeli.dashboard') }}" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('pembeli.orders.index') }}" class="btn btn-success">
            <i class="bi bi-check2-circle"></i> Saya Sudah Bayar
        </a>
    </div>
</div>
@endsection
