<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuan = Peminjaman::with(['user', 'buku'])
            ->where('status', 'diproses')
            ->latest()
            ->get();

        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        return view('petugas.pengajuan.index', compact('pengajuan', 'peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status'  => 'required|in:dipinjam,dibatalkan',
            'catatan' => 'nullable|string|max:255',
        ]);

        try {

            DB::beginTransaction();

            // ambil data
            $peminjaman = Peminjaman::with('buku')->findOrFail($id);

            $buku = Buku::lockForUpdate()->findOrFail($peminjaman->buku_id);

            // ================= RULE STATUS =================
            if ($request->status === 'dipinjam') {

                if ($buku->stok <= 0) {
                    throw new \Exception('Stok buku habis!');
                }

                $buku->decrement('stok');
            }

            // update peminjaman
            $peminjaman->update([
                'status'  => $request->status,
                'catatan' => $request->catatan,
            ]);

            DB::commit();

            // ================= NOTIF =================
            $judul = $peminjaman->buku->judul_buku ?? 'Buku';

            $pesan = match ($request->status) {
                'dipinjam' => "Peminjaman buku '{$judul}' Disetujui",
                default    => "Peminjaman buku '{$judul}' Ditolak",
            };

            if ($request->status === 'dibatalkan' && $request->catatan) {
                $pesan .= " (Alasan: {$request->catatan})";
            }

            Notifikasi::create([
                'user_id' => $peminjaman->user_id,
                'pesan'   => $pesan,
                'is_read' => false
            ]);

            return back()->with('success',
                $request->status === 'dipinjam'
                    ? 'Pengajuan diterima.'
                    : 'Pengajuan ditolak.'
            );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}