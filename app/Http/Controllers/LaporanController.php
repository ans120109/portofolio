<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $query = Transaksi::with('layanan');

        if ($dari) {
            $query->whereDate('created_at', '>=', $dari);
        }

        if ($sampai) {
            $query->whereDate('created_at', '<=', $sampai);
        }

        $transaksis = $query->get();

        $perLayanan = $transaksis->groupBy('layanan_id')->map(function ($items) {
            return [
                'nama' => $items->first()->layanan->nama,
                'jumlah' => $items->count(),
                'pendapatan' => $items->where('status', 'selesai')->sum('total'),
            ];
        })->sortByDesc('jumlah')->values();

        return view('laporan.index', compact('transaksis', 'perLayanan', 'dari', 'sampai'));
    }
}
