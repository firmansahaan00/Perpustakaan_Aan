@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">Edit Buku</h1>

    <form action="{{ route('kepala.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="kode_buku" value="{{ $buku->kode_buku }}"
            class="w-full border p-2 mb-3" required>

        <input type="text" name="judul_buku" value="{{ $buku->judul_buku }}"
            class="w-full border p-2 mb-3" required>

        <input type="text" name="penulis" value="{{ $buku->penulis }}"
            class="w-full border p-2 mb-3" required>

        <input type="int" name="tahun_terbit" value="{{ $buku->tahun_terbit }}"
            class="w-full border p-2 mb-3" required>

        <input type="number" name="stok" value="{{ $buku->stok }}"
            class="w-full border p-2 mb-3" required>

        <textarea name="sinopsis"
            class="w-full border p-2 mb-3">{{ $buku->sinopsis }}</textarea>

        @if($buku->cover)
            <img src="{{ asset('storage/'.$buku->cover) }}"
                 class="w-24 mb-3">
        @endif

        <input type="file" name="cover"
            class="w-full border p-2 mb-3">

        <button class="bg-yellow-500 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>

</div>
@endsection
