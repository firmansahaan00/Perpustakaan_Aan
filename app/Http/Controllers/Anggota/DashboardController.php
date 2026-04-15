<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Notifikasi;
use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ================= USER =================
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $userId = $user->id;

        // ================= NOTIF =================
        $notifikasi = Notifikasi::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // ================= STATISTIK =================
        $dipinjam = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();

        $dikembalikan = Peminjaman::where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->count();

        $totalDenda = Denda::whereHas('peminjaman', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->sum('nominal_tagihan') ?? 0;

        // ================= TABLE: PEMINJAMAN AKTIF =================
        $peminjamanAktif = Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->orderBy('created_at', 'desc')
            ->get();

        // ================= TABLE: DENDA LIST =================
        $dendaList = Denda::with(['peminjaman.buku'])
            ->whereHas('peminjaman', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // ================= RETURN VIEW =================
        return view('anggota.dashboard', compact(
            'notifikasi',
            'dipinjam',
            'dikembalikan',
            'totalDenda',
            'peminjamanAktif',
            'dendaList'
        ));
    }
}