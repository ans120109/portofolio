@extends('layouts.app')

@section('title', 'Transaksi - SiBengkel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-receipt me-2"></i>Transaksi</h3>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Buat Transaksi</a>
</div>

<div class="mb-3">
    <a href="{{ route('transaksi.index') }}" class="btn btn-sm {{ !$status ? 'btn-dark' : 'btn-outline-dark' }}">Semua</a>
    <a href="{{ route('transaksi.index', ['status' => 'antri']) }}" class="btn btn-sm {{ $status === 'antri' ? 'btn-warning' : 'btn-outline-warning' }}">Antri</a>
    <a href="{{ route('transaksi.index', ['status' => 'dikerjakan']) }}" class="btn btn-sm {{ $status === 'dikerjakan' ? 'btn-primary' : 'btn-outline-primary' }}">Dikerjakan</a>
    <a href="{{ route('transaksi.index', ['status' => 'selesai']) }}" class="btn btn-sm {{ $status === 'selesai' ? 'btn-success' : 'btn-outline-success' }}">Selesai</a>
    <a href="{{ route('transaksi.index', ['status' => 'batal']) }}" class="btn btn-sm {{ $status === 'batal' ? 'btn-danger' : 'btn-outline-danger' }}">Batal</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Kendaraan</th>
                        <th>Catatan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $t)
                        <tr>
                            <td>#{{ $t->id }}</td>
                            <td>{{ $t->user->name }}</td>
                            <td>{{ $t->layanan->nama }}</td>
                            <td>{{ $t->kendaraan }}</td>
                            <td class="text-muted small">{{ $t->catatan ?? '-' }}</td>
                            <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                            <td>@include('partials.status-badge', ['status' => $t->status])</td>
                            <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                            <td class="text-end">
                                @if ($t->status === 'antri')
                                    <form action="{{ route('transaksi.status', $t) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="dikerjakan">
                                        <button type="submit" class="btn btn-sm btn-primary">Proses</button>
                                    </form>
                                    <form action="{{ route('transaksi.status', $t) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="batal">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Batal</button>
                                    </form>
                                @elseif ($t->status === 'dikerjakan')
                                    <form action="{{ route('transaksi.status', $t) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="btn btn-sm btn-success">Selesai</button>
                                    </form>
                                @endif

                                @if (auth()->user()->role === 'admin')
                                    <form action="{{ route('transaksi.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi #{{ $t->id }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
