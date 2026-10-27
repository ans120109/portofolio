@extends('layouts.app')

@section('title', 'Kelola Pengguna - SiBengkel')

@section('content')
<h3 class="mb-4"><i class="bi bi-people me-2"></i>Kelola Pengguna</h3>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }} @if ($user->id === auth()->id())<span class="badge text-bg-info">Anda</span>@endif</td>
                            <td>{{ $user->email }}</td>
                            <td>@include('partials.status-badge', ['status' => $user->role])</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('users.role', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                            @foreach (['admin', 'operator', 'pengguna'] as $role)
                                                <option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst($role) }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
