@extends('layouts.app')

@section('title', 'SiBengkel - Bengkel Motor Terpercaya')

@section('content')
<div class="text-center py-5 bg-white rounded-3 shadow-sm mb-4">
    <h1 class="fw-bold display-5"><i class="bi bi-tools text-primary"></i> SiBengkel</h1>
    <p class="lead text-muted">Servis, Tune Up, Variasi Motor, Ganti Oli, Tambal Ban, Tambah Angin Ban, dan banyak lagi.</p>
    @guest
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Daftar &amp; Pesan Servis</a>
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Masuk</a>
    @else
        @if (auth()->user()->role === 'pengguna')
            <a href="{{ route('pesanan.create') }}" class="btn btn-primary btn-lg">Pesan Servis Sekarang</a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Buka Dashboard</a>
        @endif
    @endauth
</div>

<h4 class="mb-3">Daftar Layanan</h4>
<div class="row g-3">
    @forelse ($layanans as $layanan)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <span class="badge text-bg-secondary mb-2">{{ $layanan->kategori }}</span>
                    <h5 class="card-title">{{ $layanan->nama }}</h5>
                    <p class="card-text text-muted small">{{ $layanan->deskripsi }}</p>
                    <h6 class="text-primary fw-bold">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</h6>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    @auth
                        @if (auth()->user()->role === 'pengguna')
                            <a href="{{ route('pesanan.create', ['layanan' => $layanan->id]) }}" class="btn btn-sm btn-primary w-100">Pesan</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary w-100">Masuk untuk Memesan</a>
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada layanan yang tersedia.</p>
    @endforelse
</div>
@endsection
