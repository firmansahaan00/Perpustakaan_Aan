@extends('anggota.layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Buku Saya</h1>

    <!-- Search -->
    <div class="mb-6">
        <form method="GET" action="{{ route('anggota.buku.index') }}">
            <input type="text" name="search" placeholder="Cari buku..."
                class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
                value="{{ request('search') }}">
        </form>
    </div>

    <!-- Grid Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse ($bukus as $buku)
        <a href="{{ route('anggota.buku.show', $buku->id) }}" class="block border rounded-lg shadow-sm p-4 hover:shadow-lg transition flex flex-col">
            <!-- Cover Buku -->
            <img src="{{ $buku->cover_image ? asset('storage/' . $buku->cover_image) : asset('images/default-cover.png') }}"
                alt="{{ $buku->judul }}"
                class="h-48 w-full object-cover rounded mb-4">

            <!-- Judul Buku -->
            <h3 class="text-center font-semibold mb-2">{{ $buku->judul }}</h3>

            <!-- Stok -->
            <p class="text-center mb-4">
                <span class="px-2 py-1 rounded 
                    {{ $buku->stok > 0 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    Stok: {{ $buku->stok }}
                </span>
            </p>

            <!-- Tombol Baca (jika stok tersedia) -->
            @if($buku->stok > 0)
            <button
                class="mt-auto bg-teal-500 text-white py-2 rounded hover:bg-teal-600 transition w-full">
                Pinjam Buku
            </button>
            @else
            <button disabled
                class="mt-auto bg-gray-300 text-gray-600 py-2 rounded cursor-not-allowed w-full">
                Tidak tersedia
            </button>
            @endif
        </a>
        @empty
        <div class="col-span-full text-center text-gray-500">
            Data buku tidak ditemukan
        </div>
        @endforelse

    </div>
</div>
@endsection