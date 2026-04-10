<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProcReturController extends Controller
{
    public function show($id)
    {
        $peminjaman = Peminjaman::with('user','buku')->findOrFail($id);
        $pengaturan = Pengaturan::first();

        // hitung telat
        $telat = 0;
        if(now()->gt($peminjaman->tanggal_jatuh_tempo)) {
            $hari_telat = now()->diffInDays($peminjaman->tanggal_jatuh_tempo);
            $telat = $hari_telat * ($pengaturan->denda_per_hari ?? 1000);
        }

        return view('petugas.pengembalian.proc_retur', compact('peminjaman','telat'));
    }

    public function store(Request $request, $id)
{
    $request->validate([
        'aksi' => 'required|in:simpan_bayar_sekarang,simpan_bayar_nanti,langsung_kembali'
    ]);

    $peminjaman = Peminjaman::findOrFail($id);
    $pengaturan = Pengaturan::first();

    // Hitung telat
    $telat = 0;
    if(now()->gt($peminjaman->tanggal_jatuh_tempo)) {
        $hari_telat = now()->diffInDays($peminjaman->tanggal_jatuh_tempo);
        $telat = $hari_telat * ($pengaturan->denda_per_hari ?? 1000);
    }

    // Denda lain
    $denda_lain = 0;
    $jenis = null;

    if($request->denda_lain === 'hilang' || $request->denda_lain === 'rusak') {
        $denda_lain = $request->nominal_lain ?? 0;
        $jenis = $request->denda_lain;
    }

    $total = $telat + $denda_lain;

    $denda = null;

    if($total > 0) {
        $denda = Denda::create([
            'peminjaman_id' => $peminjaman->id,
            'jenis' => $jenis ?? 'telat',
            'nominal_tagihan' => $total,
            'keterangan' => '-',
            'status_denda' => 'belum_lunas'
        ]);
    }

    // Update peminjaman
    $peminjaman->update([
        'status' => 'dikembalikan',
        'tanggal_kembali' => now()
    ]);

    // ✅ BAYAR SEKARANG → ke halaman pembayaran (GET)
    if($request->aksi == 'simpan_bayar_sekarang' && $denda) {
        return redirect()->route('petugas.pembayaran.index', $peminjaman->id);
    }

    // ✅ BAYAR NANTI
    if($request->aksi == 'simpan_bayar_nanti') {
        return redirect()->route('petugas.denda.index')
            ->with('success', 'Denda disimpan, bayar nanti.');
    }

    // ✅ TANPA DENDA
    return redirect()->route('petugas.pengembalian.index')
        ->with('success','Buku berhasil dikembalikan.');
}

   public function proses(Request $request, $id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $pengaturan = Pengaturan::first();

    $tanggal_kembali = now();
    $totalDenda = 0;

    // 🔹 TELAT
    if ($tanggal_kembali->gt($peminjaman->tanggal_jatuh_tempo)) {
        $hariTelat = $tanggal_kembali->diffInDays($peminjaman->tanggal_jatuh_tempo);
        $nominalTelat = $hariTelat * ($pengaturan->denda_per_hari ?? 1000);

        Denda::create([
            'peminjaman_id' => $peminjaman->id,
            'jenis' => 'telat',
            'nominal_tagihan' => $nominalTelat,
            'status_denda' => 'belum_lunas',
            'keterangan' => "Terlambat $hariTelat hari",
        ]);

        $totalDenda += $nominalTelat;
    }

    // 🔹 DENDA LAIN
    if (in_array($request->denda_lain, ['hilang','rusak'])) {
        $nominalLain = $request->nominal_lain ?? 0;

        Denda::create([
            'peminjaman_id' => $peminjaman->id,
            'jenis' => $request->denda_lain,
            'nominal_tagihan' => $nominalLain,
            'status_denda' => 'belum_lunas',
            'keterangan' => ucfirst($request->denda_lain),
        ]);

        $totalDenda += $nominalLain;
    }

    // update peminjaman
    $peminjaman->update([
        'status' => 'dikembalikan',
        'tanggal_kembali' => $tanggal_kembali
    ]);

    // 🔥 TANPA DENDA
    if ($totalDenda == 0) {
        return redirect()->route('petugas.pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan tanpa denda');
    }

    // 🔥 BAYAR SEKARANG → ke halaman pembayaran
    if ($request->aksi == 'simpan_bayar_sekarang') {
        return redirect()->route('petugas.pembayaran.lunas', $peminjaman->id);
    }

    // 🔥 BAYAR NANTI
    return redirect()->route('petugas.pengembalian.index')
        ->with('success', 'Buku dikembalikan, pembayaran nanti');
}
}