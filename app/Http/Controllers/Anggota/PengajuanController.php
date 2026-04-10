<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    // FORM PENGAJUAN
    public function create($bukuId)
    {
        $buku = Buku::findOrFail($bukuId);
        $pengaturan = Pengaturan::first();

        // Tanggal otomatis dari server
        $tanggalPinjam = now()->toDateString();
        $tanggalJatuhTempo = now()->addDays($pengaturan->max_revisi_hari)->toDateString();

        return view('anggota.buku.pengajuan', compact(
            'buku', 
            'pengaturan', 
            'tanggalPinjam', 
            'tanggalJatuhTempo'
        ));
    }

    // SIMPAN PENGAJUAN
    public function store(Request $request, $bukuId)
    {
        $buku = Buku::findOrFail($bukuId);
        $pengaturan = Pengaturan::first();

        // Validasi stok
        if ($buku->stok < 1) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        $tanggalPinjam = now();
        $tanggalJatuhTempo = now()->addDays($pengaturan->max_revisi_hari);

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $buku->id,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
            'status' => 'diproses',
        ]);

        return redirect()->route('anggota.buku.index')
            ->with('success', 'Pengajuan berhasil!');
    }
}