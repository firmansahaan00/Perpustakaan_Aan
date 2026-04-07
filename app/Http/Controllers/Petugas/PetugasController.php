<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PetugasController extends Controller
{
    public function index()
    {
        // ambil 1 data petugas (sementara / login user nanti bisa pakai auth)
        $petugas = Petugas::with('user')->first();

        // ambil inisial dari nama
        $inisial = '';
        if ($petugas && $petugas->user) {
            $nama = explode(' ', $petugas->user->name);

            foreach ($nama as $n) {
                $inisial .= strtoupper(substr($n, 0, 1));
            }
        }

        return view('petugas.profile.index', compact('petugas', 'inisial'));
    }

    public function edit($id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        return view('petugas.profile.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::with('user')->findOrFail($id);

        // validasi
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'nip_petugas' => 'required',
        ]); 

        // update user
        $petugas->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // update petugas
        $petugas->update([
            'nip_petugas' => $request->nip_petugas,
        ]);

        return redirect()->route('petugas.profile.index')
            ->with('success', 'Data berhasil diupdate');
    }
}
