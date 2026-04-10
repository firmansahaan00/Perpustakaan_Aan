<?php

namespace App\Http\Controllers\Petugas;

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
        $bukudipinjam = Buku::count();

        // Buku terbaru (misal 5 buku terakhir)
        $bukudikembalikan = Buku::orderBy('created_at', 'desc')->take(5)->get();

        return view('petugas.dashboard', compact('totalPengguna', 'bukudipinjam', 'bukudikembalikan'));
    }
}