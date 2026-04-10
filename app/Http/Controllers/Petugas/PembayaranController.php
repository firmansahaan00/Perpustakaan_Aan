<?php
namespace App\Http\Controllers\Petugas;

use App\Models\Denda;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PembayaranController extends Controller
{
    /**
     * Simpan cicilan (partial payment)
     */
    public function storeCicilan(Request $request, $peminjaman_id)
    {
        $request->validate([
            'denda_id'    => 'required|exists:denda,id',
            'total_bayar' => 'required|integer|min:1',
            'metode'      => 'required|in:tunai,transfer',
        ]);

        $denda = Denda::with('pembayaran')->findOrFail($request->denda_id);

        if ($denda->peminjaman_id != $peminjaman_id) {
            return redirect()->route('petugas.denda.index')->with('error', 'Data tidak valid.');
        }

        $totalBayarSebelumnya = $denda->pembayaran
            ->where('tipe', 'bayar')
            ->sum('nominal_bayar');

        $sisa = $denda->nominal_tagihan - $totalBayarSebelumnya;

        if ($request->total_bayar > $sisa) {
            return redirect()->route('petugas.denda.index')
                ->with('error', 'Nominal bayar melebihi sisa tagihan (Rp ' . number_format($sisa) . ').');
        }

        // Simpan pembayaran cicilan
        Pembayaran::create([
            'denda_id'      => $denda->id,
            'peminjaman_id' => $peminjaman_id,
            'nominal_bayar' => $request->total_bayar,
            'metode'        => $request->metode,
            'tipe'          => 'bayar',
            'tanggal_bayar' => now(),
        ]);

        $sisaBaru = $sisa - $request->total_bayar;
        $denda->update(['status_denda' => $sisaBaru > 0 ? 'sebagian' : 'lunas']);

        $pesan = $sisaBaru > 0
            ? 'Pembayaran cicilan berhasil. Sisa: Rp ' . number_format($sisaBaru)
            : 'Pembayaran cicilan berhasil. Denda LUNAS!';

        return redirect()->route('petugas.denda.index')->with('success', $pesan);
    }

    /**
     * Simpan pembayaran lunas (full payment)
     */
    public function storeLunas(Request $request, $peminjaman_id)
    {
        $request->validate([
            'denda_id' => 'required|exists:denda,id',
            'metode'   => 'required|in:tunai,transfer',
        ]);

        $denda = Denda::with('pembayaran')->findOrFail($request->denda_id);

        if ($denda->peminjaman_id != $peminjaman_id) {
            return redirect()->route('petugas.denda.index')->with('error', 'Data tidak valid.');
        }

        $totalBayarSebelumnya = $denda->pembayaran
            ->where('tipe', 'bayar')
            ->sum('nominal_bayar');

        $sisa = $denda->nominal_tagihan - $totalBayarSebelumnya;

        if ($sisa <= 0) {
            return redirect()->route('petugas.denda.index')->with('error', 'Denda sudah lunas.');
        }

        // Simpan pembayaran lunas
        Pembayaran::create([
            'denda_id'      => $denda->id,
            'peminjaman_id' => $peminjaman_id,
            'nominal_bayar' => $sisa,
            'metode'        => $request->metode,
            'tipe'          => 'bayar',
            'tanggal_bayar' => now(),
        ]);

        $denda->update(['status_denda' => 'lunas']);

        return redirect()->route('petugas.denda.index')->with('success', 'Pembayaran lunas berhasil. Denda LUNAS!');
    }

    /**
     * Riwayat pembayaran per denda
     */
    public function riwayat($denda_id)
    {
        $denda = Denda::with([
            'peminjaman.user',
            'peminjaman.buku',
            'pembayaran' => fn($q) => $q->orderBy('tanggal_bayar', 'desc')
        ])->findOrFail($denda_id);

        return view('petugas.pembayaran.riwayat', compact('denda'));
    }
}