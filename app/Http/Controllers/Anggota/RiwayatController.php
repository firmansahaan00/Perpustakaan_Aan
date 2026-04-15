<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $dipinjam = Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        $dikembalikan = Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->latest()
            ->get();

        // FIX DENDA (PAKAI SUM BIAR LANGSUNG MASUK)
        $denda = Peminjaman::with(['buku', 'denda'])
            ->withSum('denda', 'nominal_tagihan')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $ditolak = Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->where('status', 'dibatalkan')
            ->latest()
            ->get();

        return view('anggota.riwayat.index', compact(
            'dipinjam',
            'dikembalikan',
            'denda',
            'ditolak'
        ));
    }
}
