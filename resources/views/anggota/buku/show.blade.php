@extends('anggota.layouts.app')

@section('content')
<div class="p-6 max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Detail Buku • {{ $buku->judul_buku }}
        </h2>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row gap-6">

        {{-- COVER --}}
        <div class="md:w-1/3">
            <div class="rounded-xl overflow-hidden bg-gray-100 h-72">
                <img src="{{ $buku->cover 
                    ? Storage::url($buku->cover) 
                    : asset('images/default-book.png') }}" 
                    alt="{{ $buku->judul_buku }}"
                    class="w-full h-full object-cover">
            </div>
        </div>

        {{-- DETAIL --}}
        <div class="md:w-2/3 flex flex-col">

            {{-- Judul & Penulis --}}
            <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ $buku->judul_buku }}</h2>
            <p class="text-gray-500 mb-4">{{ $buku->penulis }} • {{ $buku->tahun_terbit }}</p>

            {{-- Status & Stok --}}
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium 
                    {{ $buku->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                    {{ $buku->stok > 0 ? 'Tersedia' : 'Stok Habis' }}
                </span>

                <span class="inline-block px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800 border">
                    Stok: {{ $buku->stok }}
                </span>
            </div>

            {{-- Sinopsis --}}
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Sinopsis</h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $buku->sinopsis ?? 'Tidak ada sinopsis tersedia.' }}
                </p>
            </div>

            {{-- BUTTON --}}
            <div class="mt-auto flex flex-wrap gap-3">
                <a href="{{ route('anggota.buku.index') }}"
                   class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                    Kembali
                </a>

                <a href="{{ route('anggota.pengajuan.create', $buku->id) }}"
                   class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow transition
                   {{ $buku->stok < 1 ? 'opacity-50 pointer-events-none' : '' }}">
                    Ajukan
                </a>
            </div>

        </div>

    </div>

</div>

@endsection