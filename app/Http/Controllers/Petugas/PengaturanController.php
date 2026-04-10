<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();

        // auto buat jika belum ada
        if (!$pengaturan) {
            $pengaturan = Pengaturan::create([
                'denda_per_hari' => 1000,
                'max_revisi_hari' => 7
            ]);
        }

        return view('petugas.pengajuan.pengaturan', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'denda_per_hari' => 'required|numeric',
            'max_revisi_hari' => 'required|numeric',
        ]);

        $pengaturan = Pengaturan::first();

        $pengaturan->update([
            'denda_per_hari' => $request->denda_per_hari,
            'max_revisi_hari' => $request->max_revisi_hari,
        ]);

        return redirect()->route('petugas.pengajuan.index')
                     ->with('success', 'Pengaturan berhasil diupdate!');
    }
}