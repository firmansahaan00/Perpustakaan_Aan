@extends('petugas.layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            📚 Manajemen Pengajuan Buku
        </h2>

        <a href="{{ route('petugas.pengaturan.index') }}"
            class="flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-xl text-sm shadow">
            ⚙️ Pengaturan
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-4 p-3 text-green-700 bg-green-100 rounded-xl shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= BELUM DIPROSES ================= --}}
    <div class="mb-10">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">
            ⏳ Pengajuan Belum Diproses
        </h3>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-3">No</th>
                        <th class="p-3 text-left">Anggota</th>
                        <th class="p-3 text-left">Buku</th>
                        <th class="p-3 text-center">Pinjam</th>
                        <th class="p-3 text-center">Jatuh Tempo</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($pengajuan as $item)
                    <tr class="border-t hover:bg-gray-50 transition">

                        <td class="p-3">{{ $loop->iteration }}</td>

                        <td class="p-3 font-medium text-gray-800">
                            {{ $item->user->name }}
                        </td>

                        <td class="p-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $item->buku->cover ? Storage::url($item->buku->cover) : asset('images/default-book.png') }}"
                                    class="w-10 h-14 object-cover rounded-lg shadow">
                                <span class="font-medium">
                                    {{ $item->buku->judul_buku }}
                                </span>
                            </div>
                        </td>

                        <td class="p-3 text-center">{{ $item->tanggal_pinjam }}</td>
                        <td class="p-3 text-center">{{ $item->tanggal_jatuh_tempo }}</td>

                        <td class="p-3 text-center">
                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                                Menunggu
                            </span>
                        </td>

                        <td class="p-3 space-y-2">

                            {{-- TERIMA --}}
                            <form action="{{ route('petugas.pengajuan.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="dipinjam">

                                <button class="w-full flex items-center justify-center gap-1 bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded-lg shadow">
                                    ✔ Terima
                                </button>
                            </form>

                            {{-- TOLAK --}}
                            <button data-modal-target="modal-tolak-{{ $item->id }}"
                                class="w-full flex items-center justify-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded-lg shadow open-modal">
                                ✖ Tolak
                            </button>

                            {{-- MODAL --}}
                            <div id="modal-tolak-{{ $item->id }}" 
                                 class="fixed inset-0 bg-black/40 flex items-center justify-center hidden z-50">
                                <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">

                                    <h3 class="text-lg font-semibold mb-4">Tolak Pengajuan</h3>

                                    <form action="{{ route('petugas.pengajuan.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="status" value="dibatalkan">

                                        <textarea name="catatan" placeholder="Alasan penolakan..." required
                                            class="w-full border rounded-lg p-2 mb-4 focus:ring-2 focus:ring-red-500"></textarea>

                                        <div class="flex justify-end gap-2">
                                            <button type="button" data-modal-close
                                                class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                                                Batal
                                            </button>

                                            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                Tolak
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-6 text-gray-500">
                            Belum ada pengajuan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= SUDAH DIPROSES ================= --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-700 mb-3">
            ✅ Pengajuan Sudah Diproses
        </h3>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-3">No</th>
                        <th class="p-3 text-left">Anggota</th>
                        <th class="p-3 text-left">Buku</th>
                        <th class="p-3 text-center">Pinjam</th>
                        <th class="p-3 text-center">Jatuh Tempo</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($peminjaman as $p)
                    <tr class="border-t hover:bg-gray-50">

                        <td class="p-3">{{ $loop->iteration }}</td>

                        <td class="p-3 font-medium">
                            {{ $p->user->name }}
                        </td>

                        <td class="p-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $p->buku->cover ? Storage::url($p->buku->cover) : asset('images/default-book.png') }}"
                                    class="w-10 h-14 object-cover rounded-lg shadow">
                                <span class="font-medium">
                                    {{ $p->buku->judul_buku }}
                                </span>
                            </div>
                        </td>

                        <td class="p-3 text-center">{{ $p->tanggal_pinjam }}</td>
                        <td class="p-3 text-center">{{ $p->tanggal_jatuh_tempo }}</td>

                        <td class="p-3 text-center">
                            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>

                        <td class="p-3 text-center">

                            {{-- 🔥 FIX: kalau ini nanti update status → pakai FORM --}}
                            <form action="{{ route('petugas.pengembalian.proses', $p->id) }}" method="GET">
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-xs shadow">
                                    Kembalikan
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-6 text-gray-500">
                            Belum ada peminjaman
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.open-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-modal-target');
            document.getElementById(target).classList.remove('hidden');
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.closest('.fixed').classList.add('hidden');
        });
    });

});
</script>

@endsection