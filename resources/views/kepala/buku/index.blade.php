@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">📚 Data Buku</h1>
            <p class="text-gray-500 text-sm">Kelola semua data buku perpustakaan</p>
        </div>

        <a href="{{ route('kepala.buku.create') }}"
           class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl shadow transition">
            + Tambah Buku
        </a>
    </div>

    <!-- ✅ NOTIFIKASI MODERN -->
    @if(session('success'))
    <div id="toast-success"
         class="fixed top-6 right-6 z-50 flex items-center gap-3 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg transform transition-all duration-500">
        <span class="text-lg">✅</span>
        <span class="font-medium">{{ session('success') }}</span>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.classList.add('opacity-0', 'translate-x-10');
                setTimeout(() => toast.remove(), 500);
            }
        }, 4000);
    </script>
    @endif

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-center">Cover</th>
                        <th class="p-4 text-left">Kode</th>
                        <th class="p-4 text-left">Judul</th>
                        <th class="p-4 text-left">Penulis</th>
                        <th class="p-4 text-center">Tahun</th>
                        <th class="p-4 text-center">Stok</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($buku as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">{{ $loop->iteration }}</td>
                        <td class="p-4 text-center">
                            @if($item->cover)
                                <img src="{{ asset('storage/'.$item->cover) }}" class="w-14 h-20 object-cover rounded-lg shadow mx-auto">
                            @else
                                <div class="w-14 h-20 bg-gray-200 rounded flex items-center justify-center text-xs">No Img</div>
                            @endif
                        </td>
                        <td class="p-4 font-mono text-gray-600">{{ $item->kode_buku }}</td>
                        <td class="p-4 font-semibold text-gray-800">{{ $item->judul_buku }}</td>
                        <td class="p-4">{{ $item->penulis }}</td>
                        <td class="p-4 text-center">{{ $item->tahun_terbit }}</td>
                        <td class="p-4 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $item->stok > 5 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                {{ $item->stok }}
                            </span>
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <a href="{{ route('kepala.buku.edit', $item->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs shadow">
                                Edit
                            </a>

                            <button type="button"
                                    data-id="{{ $item->id }}"
                                    class="hapus-btn bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                                Hapus
                            </button>

                            <!-- Form hapus (disembunyikan) -->
                            <form id="delete-form-{{ $item->id }}" action="{{ route('kepala.buku.destroy', $item->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="hapus-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6 text-center">
            <h2 class="text-xl font-semibold mb-4">Konfirmasi Hapus</h2>
            <p class="mb-6">Apakah kamu yakin ingin menghapus buku ini?</p>
            <div class="flex justify-center gap-4">
                <button id="cancel-btn" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg">Batal</button>
                <button id="confirm-btn" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">Hapus</button>
            </div>
        </div>
    </div>

</div>

<script>
let currentFormId = null;

// Tampilkan modal saat klik tombol hapus
document.querySelectorAll('.hapus-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        currentFormId = btn.dataset.id;
        document.getElementById('hapus-modal').classList.remove('hidden');
    });
});

// Tombol batal
document.getElementById('cancel-btn').addEventListener('click', () => {
    currentFormId = null;
    document.getElementById('hapus-modal').classList.add('hidden');
});

// Tombol konfirmasi hapus
document.getElementById('confirm-btn').addEventListener('click', () => {
    if(currentFormId) {
        document.getElementById('delete-form-' + currentFormId).submit();
    }
});
</script>

@endsection
