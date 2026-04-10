<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BukuController extends Controller
{

    public function index()
    {
        $buku = Buku::latest()->get();
        return view('anggota.buku.index', compact('buku'));
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('anggota.buku.show', compact('buku'));
    }
}