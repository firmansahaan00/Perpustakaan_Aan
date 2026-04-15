<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    // FORM PENGAJUAN
    public function create($bukuId)
    {
        $buku = Buku::findOrFail($bukuId);
        $pengaturan = Pengaturan::first();

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
    public function store($bukuId)
    {
        $buku = Buku::findOrFail($bukuId);
        $pengaturan = Pengaturan::first();

        if ($buku->stok < 1) {
            return back()->with('error', 'Buku tidak tersedia.');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now(),
            'tanggal_jatuh_tempo' => now()->addDays($pengaturan->max_revisi_hari),
            'status' => 'diproses',
        ]);

        return redirect()->route('anggota.buku.index')
            ->with('success', 'Pengajuan berhasil!');
    }

    // 🔥 PINJAM LAGI (FIXED)
    public function pinjamLagi($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);

        // ❌ HARUS SUDAH DIKEMBALIKAN
        if ($peminjaman->status != 'dikembalikan') {
            return back()->with('error', 'Buku belum dikembalikan.');
        }

        $buku = $peminjaman->buku;
        $pengaturan = Pengaturan::first();

        // ❌ CEK STOK
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }

        // 🔥 BUAT PEMINJAMAN BARU
        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now(),
            'tanggal_jatuh_tempo' => now()->addDays($pengaturan->max_revisi_hari),
            'status' => 'diproses',
        ]);

        return back()->with('success', 'Berhasil pinjam buku lagi!');
    }
}
