<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = Transaksi::with(['user', 'layanan'])->latest();

        if ($status && in_array($status, ['antri', 'dikerjakan', 'selesai', 'batal'])) {
            $query->where('status', $status);
        }

        $transaksis = $query->get();

        return view('transaksi.index', compact('transaksis', 'status'));
    }

    public function create()
    {
        $layanans = Layanan::orderBy('nama')->get();
        $pelanggans = User::where('role', 'pengguna')->orderBy('name')->get();

        return view('transaksi.create', compact('layanans', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'layanan_id' => ['required', 'exists:layanans,id'],
            'kendaraan' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ], [
            'user_id.required' => 'Pelanggan wajib dipilih.',
            'layanan_id.required' => 'Layanan wajib dipilih.',
            'kendaraan.required' => 'Nama kendaraan wajib diisi.',
        ]);

        $layanan = Layanan::findOrFail($data['layanan_id']);

        Transaksi::create([
            'user_id' => $data['user_id'],
            'layanan_id' => $data['layanan_id'],
            'kendaraan' => $data['kendaraan'],
            'catatan' => $data['catatan'] ?? null,
            'status' => 'antri',
            'total' => $layanan->harga,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $status = $request->input('status');

        if (!in_array($status, ['antri', 'dikerjakan', 'selesai', 'batal'])) {
            return back()->with('error', 'Status tidak valid.');
        }

        $transaksi->update(['status' => $status]);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }

    public function pesanan()
    {
        $transaksis = auth()->user()->transaksis()->with('layanan')->latest()->get();

        return view('pesanan.index', compact('transaksis'));
    }

    public function pesananCreate(Request $request)
    {
        $layanans = Layanan::orderBy('nama')->get();
        $pilihan = $request->query('layanan');

        return view('pesanan.create', compact('layanans', 'pilihan'));
    }

    public function pesananStore(Request $request)
    {
        $data = $request->validate([
            'layanan_id' => ['required', 'exists:layanans,id'],
            'kendaraan' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ], [
            'layanan_id.required' => 'Layanan wajib dipilih.',
            'kendaraan.required' => 'Nama kendaraan wajib diisi.',
        ]);

        $layanan = Layanan::findOrFail($data['layanan_id']);

        auth()->user()->transaksis()->create([
            'layanan_id' => $data['layanan_id'],
            'kendaraan' => $data['kendaraan'],
            'catatan' => $data['catatan'] ?? null,
            'status' => 'antri',
            'total' => $layanan->harga,
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat.');
    }
}
