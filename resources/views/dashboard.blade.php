@extends('layouts.app')

@section('title', 'Dashboard - SiBengkel')

@section('content')
<h3 class="mb-4"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h3>

@if (auth()->user()->role === 'admin')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <i class="bi bi-people fs-3"></i>
                    <h5 class="mt-2 mb-0">{{ $totalPengguna }}</h5>
                    <small>Total Pengguna</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info shadow-sm">
                <div class="card-body">
                    <i class="bi bi-wrench-adjustable fs-3"></i>
                    <h5 class="mt-2 mb-0">{{ $totalLayanan }}</h5>
                    <small>Total Layanan</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-secondary shadow-sm">
                <div class="card-body">
                    <i class="bi bi-receipt fs-3"></i>
                    <h5 class="mt-2 mb-0">{{ $totalTransaksi }}</h5>
                    <small>Total Transaksi</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body">
                    <i class="bi bi-cash-coin fs-3"></i>
                    <h5 class="mt-2 mb-0">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h5>
                    <small>Pendapatan (Selesai)</small>
                </div>
            </div>
        </div>
    </div>
@elseif (auth()->user()->role === 'operator')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-bg-warning shadow-sm">
                <div class="card-body">
                    <i class="bi bi-hourglass-split fs-3"></i>
                    <h5 class="mt-2 mb-0">{{ $totalAntri }}</h5>
                    <small>Antri</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <i class="bi bi-gear fs-3"></i>
                    <h5 class="mt-2 mb-0">{{ $totalDikerjakan }}</h5>
                    <small>Sedang Dikerjakan</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body">
                    <i class="bi bi-check-circle fs-3"></i>
                    <h5 class="mt-2 mb-0">{{ $totalSelesai }}</h5>
                    <small>Selesai</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-dark shadow-sm">
                <div class="card-body">
                    <i class="bi bi-cash-coin fs-3"></i>
                    <h5 class="mt-2 mb-0">Rp {{ number_format($pendapatan, 0, ',', '.') }}</h5>
                    <small>Pendapatan (Selesai)</small>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary shadow-sm">
                <div class="card-body">
                    <i class="bi bi-receipt fs-3"></i>
                    <h5 class="mt-2 mb-0">{{ $totalTransaksi }}</h5>
                    <small>Total Pesanan</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body">
                    <i class="bi bi-wallet2 fs-3"></i>
                    <h5 class="mt-2 mb-0">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h5>
                    <small>Total Belanja (Selesai)</small>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Transaksi Terbaru</h5>
        @if (in_array(auth()->user()->role, ['admin', 'operator']))
            <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        @else
            <a href="{{ route('pesanan.create') }}" class="btn btn-sm btn-primary">Pesan Baru</a>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        @if (auth()->user()->role !== 'pengguna')
                            <th>Pelanggan</th>
                        @endif
                        <th>Layanan</th>
                        <th>Kendaraan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $t)
                        <tr>
                            <td>#{{ $t->id }}</td>
                            @if (auth()->user()->role !== 'pengguna')
                                <td>{{ $t->user->name }}</td>
                            @endif
                            <td>{{ $t->layanan->nama }}</td>
                            <td>{{ $t->kendaraan }}</td>
                            <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                            <td>@include('partials.status-badge', ['status' => $t->status])</td>
                            <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
