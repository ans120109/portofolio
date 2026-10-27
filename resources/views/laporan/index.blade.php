@extends('layouts.app')

@section('title', 'Laporan - SiBengkel')

@section('content')
<h3 class="mb-4"><i class="bi bi-bar-chart me-2"></i>Laporan</h3>

<form action="{{ route('laporan.index') }}" method="GET" class="card shadow-sm mb-4">
    <div class="card-body row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label" for="dari">Dari Tanggal</label>
            <input type="date" name="dari" id="dari" class="form-control" value="{{ $dari }}">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="sampai">Sampai Tanggal</label>
            <input type="date" name="sampai" id="sampai" class="form-control" value="{{ $sampai }}">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>
</form>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-bg-secondary shadow-sm">
            <div class="card-body">
                <h5 class="mb-0">{{ $transaksis->count() }}</h5>
                <small>Total Transaksi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-success shadow-sm">
            <div class="card-body">
                <h5 class="mb-0">Rp {{ number_format($transaksis->where('status', 'selesai')->sum('total'), 0, ',', '.') }}</h5>
                <small>Pendapatan (Selesai)</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-warning shadow-sm">
            <div class="card-body">
                <h5 class="mb-0">{{ $transaksis->where('status', 'antri')->count() }}</h5>
                <small>Antri</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-bg-primary shadow-sm">
            <div class="card-body">
                <h5 class="mb-0">{{ $transaksis->where('status', 'dikerjakan')->count() }}</h5>
                <small>Sedang Dikerjakan</small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Rekap per Layanan</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Layanan</th>
                        <th>Jumlah Transaksi</th>
                        <th>Pendapatan (Selesai)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perLayanan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>Rp {{ number_format($item['pendapatan'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
