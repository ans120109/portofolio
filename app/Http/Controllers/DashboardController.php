<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return view('dashboard', [
                'totalPengguna' => User::count(),
                'totalLayanan' => Layanan::count(),
                'totalTransaksi' => Transaksi::count(),
                'pendapatan' => Transaksi::where('status', 'selesai')->sum('total'),
                'transaksis' => Transaksi::with(['user', 'layanan'])->latest()->take(10)->get(),
            ]);
        }

        if ($user->role === 'operator') {
            return view('dashboard', [
                'totalAntri' => Transaksi::where('status', 'antri')->count(),
                'totalDikerjakan' => Transaksi::where('status', 'dikerjakan')->count(),
                'totalSelesai' => Transaksi::where('status', 'selesai')->count(),
                'pendapatan' => Transaksi::where('status', 'selesai')->sum('total'),
                'transaksis' => Transaksi::with(['user', 'layanan'])->latest()->take(10)->get(),
            ]);
        }

        return view('dashboard', [
            'transaksis' => $user->transaksis()->with('layanan')->latest()->get(),
            'totalTransaksi' => $user->transaksis()->count(),
            'totalBelanja' => $user->transaksis()->where('status', 'selesai')->sum('total'),
        ]);
    }
}
