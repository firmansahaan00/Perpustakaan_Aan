<?php

namespace App\Http\Controllers\KepalaPerpus;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pengguna
        $totalPengguna = User::count();

        // Total buku
        $totalBuku = Buku::count();

        // Buku terbaru (misal 5 buku terakhir)
        $bukuTerbaru = Buku::orderBy('created_at', 'desc')->take(5)->get();

        return view('kepala.dashboard', compact('totalPengguna', 'totalBuku', 'bukuTerbaru'));
    }
}