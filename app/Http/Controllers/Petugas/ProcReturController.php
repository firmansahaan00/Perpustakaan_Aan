<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Models\Buku;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcReturController extends Controller
{
    /**
     * ================= FORM =================
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with('user', 'buku')->findOrFail($id);
        $pengaturan = Pengaturan::first();

        $telat = 0;

        if ($peminjaman->tanggal_jatuh_tempo) {

            $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);

            if (now()->gt($jatuhTempo)) {

                $hari_telat = ceil($jatuhTempo->diffInHours(now()) / 24);
                $denda_per_hari = max(0, $pengaturan->denda_per_hari ?? 1000);

                $telat = max(0, $hari_telat * $denda_per_hari);
            }
        }

        return view('petugas.pengembalian.proc_retur', compact('peminjaman', 'telat'));
    }

    /**
     * ================= PROSES =================
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:simpan_bayar_sekarang,simpan_bayar_nanti,langsung_kembali'
        ]);

        try {

            DB::beginTransaction();

            $peminjaman = Peminjaman::with('buku')
                ->lockForUpdate()
                ->findOrFail($id);

            $pengaturan = Pengaturan::first();

            if ($peminjaman->status === 'dikembalikan') {
                throw new \Exception('Buku sudah dikembalikan!');
            }

            // ================= HITUNG DENDA =================
            $telat = 0;

            if ($peminjaman->tanggal_jatuh_tempo) {

                $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);

                if (now()->gt($jatuhTempo)) {

                    $hari_telat = ceil($jatuhTempo->diffInHours(now()) / 24);
                    $denda_per_hari = max(0, $pengaturan->denda_per_hari ?? 1000);

                    $telat = max(0, $hari_telat * $denda_per_hari);
                }
            }

            // ================= DENDA LAIN =================
            $denda_lain = 0;
            $jenis = 'telat';

            if ($request->filled('denda_lain') && in_array($request->denda_lain, ['hilang', 'rusak'])) {
                $denda_lain = max(0, (int) $request->nominal_lain);
                $jenis = $request->denda_lain;
            }

            // ================= TOTAL =================
            $total = max(0, $telat + $denda_lain);

            $dendaResult = null;

            if ($total > 0) {
                $dendaResult = Denda::create([
                    'peminjaman_id'   => $peminjaman->id,
                    'jenis'           => $jenis,
                    'nominal_tagihan' => $total,
                    'keterangan'      => 'Denda keterlambatan / kerusakan',
                    'status_denda'    => 'belum_lunas'
                ]);
            }

            // ================= UPDATE STOK =================
            $buku = Buku::find($peminjaman->buku_id);

            if ($buku) {
                $buku->increment('stok');
            }

            // ================= UPDATE PEMINJAMAN =================
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()
            ]);

            DB::commit();

            // ================= NOTIFIKASI =================
            $pesan = "Buku '{$peminjaman->buku->judul_buku}' berhasil dikembalikan";

            if ($dendaResult && $dendaResult->nominal_tagihan > 0) {
                $pesan .= " dengan denda Rp " . number_format($dendaResult->nominal_tagihan);
            }

            Notifikasi::create([
                'user_id' => $peminjaman->user_id,
                'pesan'   => $pesan,
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        // ================= REDIRECT =================
        if ($request->aksi === 'simpan_bayar_sekarang' && isset($dendaResult)) {
            return redirect()->route('petugas.denda.index')
                ->with('success', 'Denda dibuat, silakan bayar sekarang.');
        }

        if ($request->aksi === 'simpan_bayar_nanti') {
            return redirect()->route('petugas.denda.index')
                ->with('success', 'Denda masuk ke daftar NUNGGAK.');
        }

        return redirect()->route('petugas.pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
}