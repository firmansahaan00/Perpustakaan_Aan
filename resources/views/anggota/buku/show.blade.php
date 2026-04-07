@extends('anggota.layouts.app')

@section('content')
<div class="p-6 max-w-md mx-auto">

    <h1 class="text-3xl font-bold mb-4">{{ $buku->judul }}</h1>

    <img src="{{ $buku->cover_image ? asset('storage/' . $buku->cover_image) : asset('images/default-cover.png') }}"
        alt="{{ $buku->judul }}" class="mb-4 w-full h-72 object-cover rounded">

    <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
    <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
    <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
    <p><strong>Stok:</strong> {{ $buku->stok }}</p>

    @if(session('error'))
    <div class="bg-red-100 text-red-700 p-2 my-4 rounded">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-2 my-4 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if($buku->stok > 0)
    <form action="{{ route('anggota.peminjaman.store') }}" method="POST" class="mt-6">
        @csrf
        <input type="hidden" name="buku_id" value="{{ $buku->id }}">

        <button type="submit"
            class="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-600 transition w-full">
            Pinjam Buku
        </button>
    </form>
    @else
    <p class="mt-6 text-gray-600">Maaf, stok buku ini sedang habis.</p>
    @endif

</div>
@endsection