<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PengajuanController extends Controller
{
    // LIST PENGAJUAN
    public function index()
    {
        // Data pengajuan baru (misal status = 'pending')
        $pengajuan = Peminjaman::with(['user','buku'])
        ->where('status','diproses') // hanya yang sudah diproses
        ->latest()
        ->get();
    
         $peminjaman = Peminjaman::with(['user','buku'])
        ->where('status','dipinjam') // hanya yang sedang dipinjam
        ->latest()
        ->get();
    
    return view('petugas.pengajuan.index', compact('pengajuan','peminjaman'));

       
    }

    // UPDATE STATUS
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dipinjam,dibatalkan',
            'catatan' => 'nullable|string|max:255', // catatan opsional tapi bisa diisi saat tolak
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        // Update status dan catatan
        $peminjaman->update([
            'status' => $request->status,
            'catatan' => $request->catatan ?? null,
        ]);

        $message = $request->status == 'dipinjam' ? 'Pengajuan diterima.' : 'Pengajuan ditolak.';

        return redirect()->back()->with('success', $message);
    }
}