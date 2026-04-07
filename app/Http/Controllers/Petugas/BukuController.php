<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        // Menampilkan semua buku
        $buku = Buku::latest()->get();
        return view('petugas.buku.index',[
            "buku"   =>   $buku
        ]);
    }

    public function create()
    {
        return view('petugas.buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku'    => 'required|unique:buku,kode_buku',
            'judul_buku'   => 'required',
            'penulis'      => 'required',
            'sinopsis'     => 'nullable',
            'tahun_terbit' => 'required|integer',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar cover jika ada
        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($validated);

        return redirect()->route('petugas.buku.index')
            ->with('success', 'Data buku berhasil ditambahkan');
    }

    public function edit(Buku $buku)
    {
        return view('petugas.buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kode_buku'    => 'required|unique:buku,kode_buku,' . $buku->id,
            'judul_buku'   => 'required',
            'penulis'      => 'required',
            'tahun_terbit' => 'required|integer',
            'sinopsis'     => 'nullable',
            'stok'         => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hapus cover lama jika ada dan upload cover baru
        if ($request->hasFile('cover')) {
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($validated);

        return redirect()->route('petugas.buku.index')
            ->with('success', 'Data buku berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {
        // Hapus cover jika ada
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        // Hapus buku
        $buku->delete();

        return redirect()->route('petugas.buku.index')
            ->with('success', 'Data buku berhasil dihapus');
    }
}