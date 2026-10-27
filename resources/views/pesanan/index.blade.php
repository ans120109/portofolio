@extends('layouts.app')

@section('title', 'Pesanan Saya - SiBengkel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-bag-check me-2"></i>Pesanan Saya</h3>
    <a href="{{ route('pesanan.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Pesan Baru</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Layanan</th>
                        <th>Kendaraan</th>
                        <th>Catatan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $t)
                        <tr>
                            <td>#{{ $t->id }}</td>
                            <td>{{ $t->layanan->nama }}</td>
                            <td>{{ $t->kendaraan }}</td>
                            <td class="text-muted small">{{ $t->catatan ?? '-' }}</td>
                            <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                            <td>@include('partials.status-badge', ['status' => $t->status])</td>
                            <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada pesanan. Yuk pesan servis pertama kamu!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
