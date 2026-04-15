<?php

namespace App\Http\Controllers\KepalaPerpus;

use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;

        $peminjaman = Peminjaman::with(['user','buku']);
        $pengembalian = Peminjaman::with(['user','buku'])
                            ->where('status','dikembalikan');
        $ditolak = Peminjaman::with(['user','buku'])
                            ->where('status','ditolak');

        // ✅ FIX DENDA
        $denda = Denda::with('peminjaman.user','peminjaman.buku')
                    ->whereHas('peminjaman');

        if ($bulan) {
            [$tahun, $bulanAngka] = explode('-', $bulan);

            $start = Carbon::create($tahun, $bulanAngka, 1)->startOfMonth();
            $end   = Carbon::create($tahun, $bulanAngka, 1)->endOfMonth();

            $peminjaman->whereBetween('tanggal_pinjam', [$start, $end]);
            $pengembalian->whereBetween('tanggal_kembali', [$start, $end]);
            $ditolak->whereBetween('tanggal_pinjam', [$start, $end]);

            // ✅ FILTER DENDA
            $denda->whereBetween('created_at', [$start, $end]);
        }

        return view('kepala.laporan.index', [
            'peminjaman' => $peminjaman->orderBy('tanggal_pinjam','desc')->get(),
            'pengembalian' => $pengembalian->orderBy('tanggal_kembali','desc')->get(),
            'ditolak' => $ditolak->orderBy('tanggal_pinjam','desc')->get(),
            'denda' => $denda->latest()->get(),
        ]);
    }
}