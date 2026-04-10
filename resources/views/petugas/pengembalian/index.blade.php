@extends('petugas.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow-lg">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Riwayat Pengembalian Buku
    </h2>

    @if (session('success'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-2 text-left">Anggota</th>
                    <th class="px-4 py-2 text-left">Buku</th>
                    <th class="px-4 py-2 text-center">Tanggal Pinjam</th>
                    <th class="px-4 py-2 text-center">Jatuh Tempo</th>
                    <th class="px-4 py-2 text-center">Tanggal Kembali</th>
                    <th class="px-4 py-2 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($peminjaman as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $p->user->name }}</td>
                        <td class="px-4 py-2">{{ $p->buku->judul_buku }}</td>
                        <td class="px-4 py-2 text-center">{{ $p->tanggal_pinjam }}</td>
                        <td class="px-4 py-2 text-center">{{ $p->tanggal_jatuh_tempo }}</td>
                        <td class="px-4 py-2 text-center">{{ $p->tanggal_kembali }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                Dikembalikan
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            Tidak ada data pengembalian
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection