<?php

namespace App\Http\Controllers\Petugas;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // STATISTIK
        $totalAnggota = User::where('role', 'anggota')->count();
        $totalBuku = Buku::count();
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $bukuDikembalikan = Peminjaman::where('status', 'dikembalikan')->count();

        // PEMINJAMAN TERBARU
        $peminjamanTerbaru = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->limit(10)
            ->get();

        // PENGEMBALIAN TERBARU + DENDA
        $pengembalianTerbaru = Peminjaman::with(['user', 'buku', 'denda'])
            ->where('status', 'dikembalikan')
            ->latest()
            ->limit(10)
            ->get();

        return view('petugas.dashboard', compact(
            'totalAnggota',
            'totalBuku',
            'bukuDipinjam',
            'bukuDikembalikan',
            'peminjamanTerbaru',
            'pengembalianTerbaru'
        ));
    }
}