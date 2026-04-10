<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PengembalianController extends Controller
{
    public function index()
    {
        // Ambil peminjaman yang sudah dikembalikan
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dikembalikan')
            ->get();

        return view('petugas.pengembalian.index', compact('peminjaman'));
    }
}