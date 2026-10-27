@extends('layouts.app')

@section('title', 'Buat Transaksi - SiBengkel')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-4">Buat Transaksi (Pelanggan Walk-in)</h4>

                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="user_id">Pelanggan</label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->id }}" @selected(old('user_id') == $pelanggan->id)>{{ $pelanggan->name }} ({{ $pelanggan->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="layanan_id">Layanan</label>
                        <select name="layanan_id" id="layanan_id" class="form-select @error('layanan_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Layanan --</option>
                            @foreach ($layanans as $layanan)
                                <option value="{{ $layanan->id }}" @selected(old('layanan_id') == $layanan->id)>{{ $layanan->nama }} - Rp {{ number_format($layanan->harga, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                        @error('layanan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="kendaraan">Kendaraan</label>
                        <input type="text" name="kendaraan" id="kendaraan" class="form-control @error('kendaraan') is-invalid @enderror" value="{{ old('kendaraan') }}" placeholder="Contoh: Honda Beat 2019 - B 1234 XYZ" required>
                        @error('kendaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="catatan">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control @error('catatan') is-invalid @enderror" placeholder="Contoh: ganti oli sekalian cek rem">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
