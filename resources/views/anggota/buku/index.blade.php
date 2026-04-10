@extends('anggota.layouts.app')

@section('content')
<div class="p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📚 Cari Buku</h2>
        <p class="text-sm text-gray-500">Temukan buku favorit kamu</p>
    </div>

    <!-- SEARCH -->
    <form method="GET" action="{{ route('anggota.buku.index') }}"
        class="mb-8 max-w-md flex gap-2">

        <input type="text" name="q" value="{{ request('q') }}"
            placeholder="Cari judul atau penulis..."
            class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm
                   focus:ring-2 focus:ring-blue-500 outline-none">

        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow">
            🔍
        </button>
    </form>

    <!-- GRID BUKU -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">

        @forelse ($buku as $item)

        <!-- CARD -->
        <a href="{{ route('anggota.buku.show', $item->id) }}"
           class="group">

            <div class="bg-white rounded-2xl shadow hover:shadow-xl transition duration-300 overflow-hidden">

                <!-- COVER -->
                <div class="h-40 overflow-hidden">
                    <img src="{{ $item->cover 
                        ? Storage::url($item->cover) 
                        : asset('images/default-book.png') }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>

                <!-- CONTENT -->
                <div class="p-3">

                    <!-- JUDUL -->
                    <h3 class="text-sm font-semibold text-gray-800 leading-tight line-clamp-2">
                        {{ $item->judul_buku }}
                    </h3>

                    <!-- PENULIS -->
                    <p class="text-xs text-gray-500 mt-1">
                        {{ Str::limit($item->penulis, 25) }}
                    </p>

                    <!-- STATUS -->
                    <div class="mt-2">
                        @if($item->stok > 0)
                            <span class="text-xs px-2 py-1 bg-green-100 text-green-600 rounded-full">
                                Tersedia
                            </span>
                        @else
                            <span class="text-xs px-2 py-1 bg-red-100 text-red-600 rounded-full">
                                Habis
                            </span>
                        @endif
                    </div>

                </div>

            </div>

        </a>

        @empty

        <!-- EMPTY STATE -->
        <div class="col-span-full flex flex-col items-center justify-center mt-10">
            <img src="{{ asset('images/no-book.png') }}" class="w-24 mb-4 opacity-70">
            <p class="text-gray-500">Buku tidak ditemukan</p>
        </div>

        @endforelse

    </div>

</div>
@endsection