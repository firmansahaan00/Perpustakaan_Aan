<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Denda;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DendaController extends Controller
{
    /**
     * 🔹 TAMPILKAN HALAMAN MANAJEMEN DENDA
     */
    public function index(Request $request)
    {
        // ── NUNGGAK (belum_lunas & sebagian) ──────────────────────────────
        $queryNunggak = Denda::with(['peminjaman.user', 'peminjaman.buku', 'pembayaran'])
            ->whereIn('status_denda', ['belum_lunas', 'sebagian']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $queryNunggak->whereHas('peminjaman.user', fn($q) => $q->where('name', 'like', "%$search%"))
                         ->orWhereHas('peminjaman.buku', fn($q) => $q->where('judul_buku', 'like', "%$search%"));
        }

        // Filter jenis
        if ($request->filled('jenis')) {
            $queryNunggak->where('jenis', $request->jenis);
        }

        $semuaNunggak = $queryNunggak->get();

        // Hitung sisa & total_bayar secara in-memory (hindari N+1)
        $nunggak = $semuaNunggak->map(function ($denda) {
            $totalBayar      = $denda->pembayaran->where('tipe', 'bayar')->sum('nominal_bayar');
            $denda->total_bayar = $totalBayar;
            $denda->sisa        = $denda->nominal_tagihan - $totalBayar;
            return $denda;
        })->filter(fn($denda) => $denda->sisa > 0)->values();

        // ── LUNAS ──────────────────────────────────────────────────────────
        $queryLunas = Denda::with(['peminjaman.user', 'peminjaman.buku', 'pembayaran'])
            ->where('status_denda', 'lunas');

        if ($request->filled('search')) {
            $search = $request->search;
            $queryLunas->whereHas('peminjaman.user', fn($q) => $q->where('name', 'like', "%$search%"))
                       ->orWhereHas('peminjaman.buku', fn($q) => $q->where('judul_buku', 'like', "%$search%"));
        }

        if ($request->filled('jenis')) {
            $queryLunas->where('jenis', $request->jenis);
        }

        $lunas = $queryLunas->latest()->get()->map(function ($denda) {
            $totalBayar         = $denda->pembayaran->where('tipe', 'bayar')->sum('nominal_bayar');
            $denda->total_bayar = $totalBayar;
            $denda->sisa        = max(0, $denda->nominal_tagihan - $totalBayar);
            return $denda;
        });

        // ── SUMMARY CARDS ──────────────────────────────────────────────────
        $summary = [
            'total_nunggak'    => $nunggak->count(),
            'total_tagihan'    => $nunggak->sum('nominal_tagihan'),
            'total_terkumpul'  => $nunggak->sum('total_bayar'),
            'total_sisa'       => $nunggak->sum('sisa'),
            'total_lunas'      => $lunas->count(),
        ];

        return view('petugas.denda.index', compact('nunggak', 'lunas', 'summary'));
    }

    /**
     * 🔹 DETAIL DENDA + RIWAYAT PEMBAYARAN
     */
    public function show($id)
    {
        $denda = Denda::with([
            'peminjaman.user',
            'peminjaman.buku',
            'pembayaran' => fn($q) => $q->orderBy('tanggal_bayar', 'desc'),
        ])->findOrFail($id);

        $totalBayar      = $denda->pembayaran->where('tipe', 'bayar')->sum('nominal_bayar');
        $denda->total_bayar = $totalBayar;
        $denda->sisa        = max(0, $denda->nominal_tagihan - $totalBayar);

        return view('petugas.denda.show', compact('denda'));
    }

    /**
     * 🔹 REVISI DENDA (UNTUK BUKU HILANG)
     */
    public function revisi(Request $request, $id)
    {
        $request->validate([
            'nominal_baru' => 'required|integer|min:0',
            'keterangan'   => 'nullable|string|max:255',
        ]);

        $denda = Denda::with('pembayaran')->findOrFail($id);

        // Hanya denda jenis 'hilang' yang boleh direvisi
        if ($denda->jenis !== 'hilang') {
            return redirect()->route('petugas.denda.index')
                ->with('error', 'Hanya denda buku hilang yang dapat direvisi.');
        }

        $nominalLama = $denda->nominal_tagihan;
        $nominalBaru = (int) $request->nominal_baru;

        // Hitung total yang sudah dibayar (exclude refund)
        $totalBayar = $denda->pembayaran->where('tipe', 'bayar')->sum('nominal_bayar');

        // Update nominal tagihan & keterangan
        $denda->update([
            'nominal_tagihan' => $nominalBaru,
            'keterangan'      => $request->keterangan,
        ]);

        // Tentukan status baru setelah revisi
        $selisih = 0;

        if ($totalBayar >= $nominalBaru) {
            $denda->update(['status_denda' => 'lunas']);

            // Catat refund jika kelebihan bayar
            $selisih = $totalBayar - $nominalBaru;
            if ($selisih > 0) {
                Pembayaran::create([
                    'denda_id'      => $denda->id,
                    'peminjaman_id' => $denda->peminjaman_id,
                    'nominal_bayar' => $selisih,
                    'metode'        => 'refund',
                    'tipe'          => 'refund',
                    'tanggal_bayar' => now(),
                ]);
            }
        } elseif ($totalBayar > 0) {
            $denda->update(['status_denda' => 'sebagian']);
        } else {
            $denda->update(['status_denda' => 'belum_lunas']);
        }

        $pesan = "Revisi berhasil: Rp " . number_format($nominalLama) . " → Rp " . number_format($nominalBaru);

        if ($selisih > 0) {
            $pesan .= " · Refund Rp " . number_format($selisih);
        }

        return redirect()->route('petugas.denda.index')
            ->with('success', $pesan);
    }
}