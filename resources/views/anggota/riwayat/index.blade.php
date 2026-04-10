@extends('anggota.layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">

    <h2 class="text-3xl font-bold text-gray-800 mb-6">
        📚 Riwayat Peminjaman
    </h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($data as $item)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-5 border">

            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                {{ $item->judul_buku }}
            </h3>

            <p class="text-sm text-gray-500">
                📅 Pinjam: {{ $item->tanggal_pinjam }}
            </p>

            <p class="text-sm text-gray-500 mb-3">
                🔄 Kembali: {{ $item->tanggal_kembali ?? '-' }}
            </p>

            <span class="inline-block px-3 py-1 text-xs rounded-full 
                {{ $item->status == 'dipinjam' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                {{ $item->status }}
            </span>

            <form action="{{ route('pinjam.lagi', $item->id) }}" method="POST" class="mt-4">
                @csrf
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg transition">
                    🔁 Pinjam Lagi
                </button>
            </form>

        </div>
        @empty
        <div class="col-span-3 text-center text-gray-500">
            Belum ada riwayat peminjaman
        </div>
        @endforelse

    </div>

</div>
@endsection