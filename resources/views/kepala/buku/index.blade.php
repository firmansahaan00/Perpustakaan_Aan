@extends('kepala.layouts.app')

@section('content')
<div class="min-h-screen w-full p-4">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">📚 Data Buku</h1>
            <p class="text-gray-500 text-sm">Kelola semua data buku perpustakaan</p>
        </div>

        <a href="{{ route('kepala.buku.create') }}"
           class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Tambah Buku
        </a>
    </div>

    <!-- GRID BOX BOOK COMPACT -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

        @foreach($buku as $item)
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition overflow-hidden">

            <!-- Cover -->
            <div class="h-40 bg-gray-100 flex items-center justify-center">
                @if($item->cover)
                    <img src="{{ asset('storage/'.$item->cover) }}"
                         class="w-full h-full object-cover">
                @else
                    <span class="text-gray-400 text-xs">No Image</span>
                @endif
            </div>

            <!-- Content -->
            <div class="p-3">

                <h3 class="font-semibold text-gray-800 text-sm truncate">
                    {{ $item->judul_buku }}
                </h3>

                <p class="text-xs text-gray-500 mb-1">
                    {{ $item->penulis }}
                </p>

                <div class="text-xs text-gray-500 space-y-0.5">
                    <p>Kode: <span class="font-mono">{{ $item->kode_buku }}</span></p>
                    <p>Tahun: {{ $item->tahun_terbit }}</p>
                </div>

                <!-- Stok -->
                <div class="mt-1 mb-2">
                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                        {{ $item->stok > 5 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        Stok: {{ $item->stok }}
                    </span>
                </div>

                <!-- Action buttons -->
                <div class="flex gap-1">
                    <a href="{{ route('kepala.buku.edit', $item->id) }}"
                       class="flex-1 text-center bg-yellow-400 hover:bg-yellow-500 text-white py-1 rounded-lg text-xs">
                        Edit
                    </a>

                    <button type="button"
                            data-id="{{ $item->id }}"
                            class="hapus-btn flex-1 bg-red-500 hover:bg-red-600 text-white py-1 rounded-lg text-xs">
                        Hapus
                    </button>

                    <form id="delete-form-{{ $item->id }}"
                          action="{{ route('kepala.buku.destroy', $item->id) }}"
                          method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>

            </div>
        </div>
        @endforeach

    </div>

</div>

<!-- Modal Hapus -->
<div id="hapus-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl shadow-lg w-80 p-6 text-center">
        <h2 class="text-lg font-semibold mb-3">Konfirmasi</h2>
        <p class="mb-4 text-gray-600">Hapus buku ini?</p>

        <div class="flex justify-center gap-3">
            <button id="cancel-btn"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                Batal
            </button>

            <button id="confirm-btn"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
let currentFormId = null;

document.querySelectorAll('.hapus-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        currentFormId = btn.dataset.id;
        document.getElementById('hapus-modal').classList.remove('hidden');
    });
});

document.getElementById('cancel-btn').addEventListener('click', () => {
    currentFormId = null;
    document.getElementById('hapus-modal').classList.add('hidden');
});

document.getElementById('confirm-btn').addEventListener('click', () => {
    if(currentFormId){
        document.getElementById('delete-form-' + currentFormId).submit();
    }
});
</script>

@endsection