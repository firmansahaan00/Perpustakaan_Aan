<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Denda;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PembayaranController extends Controller
{
    /**
     * 🔹 Simpan cicilan (partial payment)
     */
    public function storeCicilan(Request $request, $peminjaman_id)
    {
        $request->validate([
            'denda_id'    => 'required|exists:denda,id',
            'total_bayar' => 'required|integer|min:1',
            'metode'      => 'required|in:tunai,transfer',
        ]);

        $denda = Denda::with('pembayaran')->findOrFail($request->denda_id);

        // Validasi relasi
        if ($denda->peminjaman_id != $peminjaman_id) {
            return redirect()->route('petugas.denda.index')
                ->with('error', 'Data tidak valid.');
        }

        // 🔹 Hitung total sebelumnya
        $totalSebelumnya = $denda->pembayaran
            ->where('tipe', 'bayar')
            ->sum('nominal_bayar');

        $sisa = $denda->nominal_tagihan - $totalSebelumnya;

        // ❗ Validasi over bayar
        if ($request->total_bayar > $sisa) {
            return redirect()->route('petugas.denda.index')
                ->with('error', 'Nominal melebihi sisa tagihan!');
        }

        // 🔹 Simpan pembayaran
        Pembayaran::create([
            'denda_id'      => $denda->id,
            'peminjaman_id' => $peminjaman_id,
            'nominal_bayar' => $request->total_bayar,
            'metode'        => $request->metode,
            'tipe'          => 'bayar',
            'tanggal_bayar' => now(),
        ]);

        // 🔹 Hitung ulang setelah bayar
        $totalBaru = $totalSebelumnya + $request->total_bayar;
        $sisaBaru  = $denda->nominal_tagihan - $totalBaru;

        // 🔥 Tentukan status
        if ($sisaBaru <= 0) {
            $status = 'lunas';
        } elseif ($totalBaru > 0) {
            $status = 'sebagian';
        } else {
            $status = 'belum_lunas';
        }

        $denda->update([
            'status_denda' => $status
        ]);

        return redirect()->route('petugas.denda.index')
            ->with('success', 'Pembayaran berhasil. Sisa: Rp ' . number_format(max(0, $sisaBaru)));
    }

    /**
     * 🔹 Simpan pembayaran lunas (full payment)
     */
    public function storeLunas(Request $request, $peminjaman_id)
    {
        $request->validate([
            'denda_id' => 'required|exists:denda,id',
            'metode'   => 'required|in:tunai,transfer',
        ]);

        $denda = Denda::with('pembayaran')->findOrFail($request->denda_id);

        // Validasi relasi
        if ($denda->peminjaman_id != $peminjaman_id) {
            return redirect()->route('petugas.denda.index')
                ->with('error', 'Data tidak valid.');
        }

        // 🔹 Hitung total sebelumnya
        $totalSebelumnya = $denda->pembayaran
            ->where('tipe', 'bayar')
            ->sum('nominal_bayar');

        $sisa = $denda->nominal_tagihan - $totalSebelumnya;

        // ❗ Jika sudah lunas
        if ($sisa <= 0) {
            return redirect()->route('petugas.denda.index')
                ->with('error', 'Denda sudah lunas.');
        }

        // 🔹 Simpan pembayaran lunas
        Pembayaran::create([
            'denda_id'      => $denda->id,
            'peminjaman_id' => $peminjaman_id,
            'nominal_bayar' => $sisa,
            'metode'        => $request->metode,
            'tipe'          => 'bayar',
            'tanggal_bayar' => now(),
        ]);

        // 🔥 Set langsung lunas
        $denda->update([
            'status_denda' => 'lunas'
        ]);

        return redirect()->route('petugas.denda.index')
            ->with('success', 'Pembayaran lunas berhasil. Denda LUNAS!');
    }

    /**
     * 🔹 Riwayat pembayaran per denda
     */
    public function riwayat($denda_id)
    {
        $denda = Denda::with([
            'peminjaman.user',
            'peminjaman.buku',
            'pembayaran' => fn ($q) => $q->orderBy('tanggal_bayar', 'desc')
        ])->findOrFail($denda_id);

        return view('petugas.pembayaran.riwayat', compact('denda'));
    }
}
