<?php

namespace App\Http\Controllers\Anggota;

use App\Models\anggota;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnggotaController extends Controller
{
    public function index()
    {
        // ambil data anggota login (atau first jika belum auth spesifik)
        $anggota = anggota::with('user')->first();

        // ambil inisial dari nama
        $inisial = '';
        if ($anggota && $anggota->user) {
            $nama = explode(' ', $anggota->user->name);

            foreach ($nama as $n) {
                $inisial .= strtoupper(substr($n, 0, 1));
            }
        }

        return view('anggota.profile.index', compact('anggota', 'inisial'));
    }

    public function edit($id)
    {
        $anggota = anggota::with('user')->findOrFail($id);

        return view('anggota.profile.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = anggota::with('user')->findOrFail($id);

        // validasi
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'nis'   => 'required',
            'kelas' => 'required',
        ]);

        // update user
        $anggota->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // update anggota
        $anggota->update([
            'nis'   => $request->nis,
            'kelas' => $request->kelas,
        ]);

        return redirect()
            ->route('anggota.profile.index')
            ->with('success', 'Data berhasil diupdate');
    }
}