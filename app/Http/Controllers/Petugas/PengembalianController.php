<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianController extends Controller
{
   public function index()
{
    // 🔥 AMBIL DATA YANG SUDAH DIKEMBALIKAN
    $peminjaman = Peminjaman::with(['user', 'buku'])
        ->where('status', 'dikembalikan')
        ->latest()
        ->get();

    return view('petugas.pengembalian.index', compact('peminjaman'));
}

    // 🔥 FORM RETUR
    public function form($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);

        $today = Carbon::now();
        $jatuhTempo = Carbon::parse($peminjaman->tanggal_kembali);

        $telat = 0;

        if ($today->gt($jatuhTempo)) {
            $telatHari = $jatuhTempo->diffInDays($today);
            $telat = $telatHari * 2000;
        }

        return view('petugas.pengembalian.form', compact('peminjaman', 'telat'));
    }

    // 🔥 PROSES (INI YANG DIPAKAI FORM)
    public function proses(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $pinjam = Peminjaman::findOrFail($id);
            $buku = Buku::findOrFail($pinjam->buku_id);

            $today = Carbon::now();
            $jatuhTempo = Carbon::parse($pinjam->tanggal_kembali);

            // 🔥 HITUNG TELAT
            $telatHari = 0;
            $dendaTelat = 0;

            if ($today->gt($jatuhTempo)) {
                $telatHari = $jatuhTempo->diffInDays($today);
                $dendaTelat = $telatHari * 2000;
            }

            // 🔥 INPUT DARI FORM
            $dendaLain = $request->denda_lain;
            $nominalLain = $request->nominal_lain ?? 0;

            $totalDenda = $dendaTelat + $nominalLain;

            // 🔥 CEK BIAR TIDAK DOUBLE
            $cek = Denda::where('peminjaman_id', $pinjam->id)->first();

            if (!$cek && $totalDenda > 0) {
                Denda::create([
                    'peminjaman_id' => $pinjam->id,
                    'jenis' => $dendaLain ?? 'terlambat',
                    'nominal_tagihan' => $totalDenda,
                    'status_denda' => $request->aksi == 'simpan_bayar_sekarang'
                        ? 'lunas'
                        : 'belum_lunas'
                ]);
            }

            // 🔥 UPDATE STATUS
            $pinjam->update([
                'status' => 'dikembalikan',
                'tanggal_dikembalikan' => $today,
            ]);

            // 🔥 KEMBALIKAN STOK
            $buku->increment('stok');

            DB::commit();

            return redirect()->route('petugas.pengembalian.index')
                ->with('success', 'Pengembalian berhasil');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
