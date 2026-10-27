<?php

namespace Database\Seeders;

use App\Models\Layanan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Operator Bengkel',
            'email' => 'operator@bengkel.test',
            'password' => 'password',
            'role' => 'operator',
        ]);

        User::create([
            'name' => 'Budi Pelanggan',
            'email' => 'pengguna@bengkel.test',
            'password' => 'password',
            'role' => 'pengguna',
        ]);

        $layanans = [
            ['nama' => 'Servis Ringan', 'kategori' => 'Servis', 'harga' => 75000, 'deskripsi' => 'Pengecekan menyeluruh komponen ringan motor.'],
            ['nama' => 'Servis Berat', 'kategori' => 'Servis', 'harga' => 250000, 'deskripsi' => 'Turun mesin dan perbaikan komponen utama.'],
            ['nama' => 'Tune Up', 'kategori' => 'Servis', 'harga' => 125000, 'deskripsi' => 'Penyetelan mesin, karburator/injeksi, dan kelistrikan.'],
            ['nama' => 'Ganti Oli Mesin', 'kategori' => 'Oli', 'harga' => 65000, 'deskripsi' => 'Penggantian oli mesin lengkap dengan pengecekan filter.'],
            ['nama' => 'Variasi Motor', 'kategori' => 'Variasi', 'harga' => 200000, 'deskripsi' => 'Pemasangan aksesoris dan modifikasi tampilan motor.'],
            ['nama' => 'Tambal Ban', 'kategori' => 'Ban', 'harga' => 15000, 'deskripsi' => 'Penambalan ban tubeless maupun ban dalam.'],
            ['nama' => 'Tambah Angin Ban', 'kategori' => 'Ban', 'harga' => 5000, 'deskripsi' => 'Pengisian tekanan angin ban sesuai standar.'],
            ['nama' => 'Ganti Kampas Rem', 'kategori' => 'Servis', 'harga' => 45000, 'deskripsi' => 'Penggantian kampas rem depan atau belakang.'],
            ['nama' => 'Cuci Motor', 'kategori' => 'Perawatan', 'harga' => 20000, 'deskripsi' => 'Pencucian motor lengkap dengan pengeringan.'],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}
