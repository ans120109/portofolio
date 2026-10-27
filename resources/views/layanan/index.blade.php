@extends('layouts.app')

@section('title', 'Kelola Layanan - SiBengkel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><i class="bi bi-wrench-adjustable me-2"></i>Kelola Layanan</h3>
    <a href="{{ route('layanan.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Layanan</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($layanans as $layanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $layanan->nama }}</td>
                            <td><span class="badge text-bg-secondary">{{ $layanan->kategori }}</span></td>
                            <td>Rp {{ number_format($layanan->harga, 0, ',', '.') }}</td>
                            <td class="text-muted small">{{ $layanan->deskripsi }}</td>
                            <td class="text-end">
                                <a href="{{ route('layanan.edit', $layanan) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('layanan.destroy', $layanan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus layanan {{ $layanan->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
