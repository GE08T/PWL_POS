{{-- This is how the structure would look in Blade --}}
@extends('layouts.layout')

@section('title', 'KasirPro - Sistem Kasir Modern')

@section('content')
<!-- Header -->
<header class="sticky-top bg-white border-bottom">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-shopping-cart text-primary me-2"></i>
                <span class="fw-bold">KasirPro</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('register') }}">Coba Gratis</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<!-- Hero Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="badge bg-primary-subtle text-primary mb-3">Solusi POS Terdepan</div>
                <h1 class="display-4 fw-bold mb-3">Sistem Kasir Modern untuk Bisnis Anda</h1>
                <p class="lead text-muted mb-4">
                    Kelola transaksi, inventori, dan laporan penjualan dengan mudah. 
                    Dibangun dengan Laravel dan Bootstrap untuk performa optimal.
                </p>
                <div class="d-flex gap-3 mb-4">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Mulai Gratis Sekarang</a>
                    <a href="#demo" class="btn btn-outline-secondary btn-lg">Lihat Demo</a>
                </div>
                <div class="d-flex gap-4 text-muted small">
                    <span><i class="fas fa-check-circle text-primary me-1"></i>Gratis 30 hari</span>
                    <span><i class="fas fa-check-circle text-primary me-1"></i>Tanpa kartu kredit</span>
                    <span><i class="fas fa-check-circle text-primary me-1"></i>Setup 5 menit</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section -->
<section id="contact" class="py-5 bg-white border-top">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-3">Hubungi Kami</h2>
                <p class="text-muted mb-4">Punya pertanyaan atau butuh bantuan? Tim kami siap membantu Anda kapan saja.</p>
                <div class="d-flex flex-column flex-md-row justify-content-center gap-4 mb-4">
                    <div>
                        <i class="fas fa-envelope text-primary fa-2x mb-2"></i>
                        <div>Email: <a href="mailto:support@kasirpro.com">support@kasirpro.com</a></div>
                    </div>
                    <div>
                        <i class="fas fa-phone text-primary fa-2x mb-2"></i>
                        <div>Telepon: <a href="tel:+628123456789">+62 812-3456-789</a></div>
                    </div>
                    <div>
                        <i class="fas fa-map-marker-alt text-primary fa-2x mb-2"></i>
                        <div>Alamat: Jl. Contoh No. 123, Surabaya</div>
                    </div>
                </div>
                <a href="mailto:support@kasirpro.com" class="btn btn-primary btn-lg">Kirim Email</a>
            </div>
        </div>
    </div>
</section>
@endsection