@extends('petugas.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    <div class="flex-1 flex flex-col">

        <!-- NAVBAR -->
        <header class="bg-blue-600 shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-white font-bold text-lg">Dashboard Petugas</h1>
        </header>

        <!-- CONTENT -->
        <main class="p-6 space-y-6">

            <!-- CARD -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white p-5 rounded-xl shadow text-center">
                    <h4 class="text-gray-500 text-sm">Total Anggota</h4>
                    <p class="text-2xl font-bold mt-2">{{ $totalAnggota }}</p>
                </div>

                <div class="bg-white p-5 rounded-xl shadow text-center">
                    <h4 class="text-gray-500 text-sm">Total Buku</h4>
                    <p class="text-2xl font-bold mt-2">{{ $totalBuku }}</p>
                </div>

                <div class="bg-white p-5 rounded-xl shadow text-center">
                    <h4 class="text-gray-500 text-sm">Buku Dipinjam</h4>
                    <p class="text-2xl font-bold mt-2 text-yellow-600">{{ $bukuDipinjam }}</p>
                </div>

                <div class="bg-white p-5 rounded-xl shadow text-center">
                    <h4 class="text-gray-500 text-sm">Buku Dikembalikan</h4>
                    <p class="text-2xl font-bold mt-2 text-green-600">{{ $bukuDikembalikan }}</p>
                </div>

            </div>

            <!-- PEMINJAMAN -->
            <div class="bg-white rounded-xl shadow p-5">

                <h3 class="text-lg font-semibold mb-4">Data Peminjaman Terbaru</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-center border rounded-lg overflow-hidden">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3">Nama Anggota</th>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Tanggal Pinjam</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($peminjamanTerbaru as $item)
                                <tr class="border-t hover:bg-gray-50">

                                    <td class="p-3">{{ $item->user->name ?? '-' }}</td>
                                    <td class="p-3">{{ $item->buku->judul_buku ?? '-' }}</td>
                                    <td class="p-3">{{ $item->created_at->format('d-m-Y') }}</td>

                                    <td class="p-3">
                                        @if($item->status == 'dipinjam')
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                                Dikembalikan
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-gray-400">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>

            <!-- PENGEMBALIAN -->
            <div class="bg-white rounded-xl shadow p-5">

                <h3 class="text-lg font-semibold mb-4">Pengembalian Terbaru</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-center border rounded-lg overflow-hidden">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Tanggal Kembali</th>
                                <th class="p-3">Status Denda</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pengembalianTerbaru as $item)

                                @php
                                    $totalDenda = $item->denda->sum('nominal_tagihan');
                                @endphp

                                <tr class="border-t hover:bg-gray-50">

                                    <td class="p-3">{{ $item->user->name ?? '-' }}</td>
                                    <td class="p-3">{{ $item->buku->judul_buku ?? '-' }}</td>
                                    <td class="p-3">{{ $item->updated_at->format('d-m-Y') }}</td>

                                    <td class="p-3">
                                        @if($totalDenda > 0)
                                            <span class="text-red-500 font-semibold">
                                                Ada Denda (Rp {{ number_format($totalDenda, 0, ',', '.') }})
                                            </span>
                                        @else
                                            <span class="text-green-600 font-semibold">
                                                Tidak Ada
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-gray-400">Tidak ada pengembalian</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>

        </main>

    </div>

</div>
@endsection