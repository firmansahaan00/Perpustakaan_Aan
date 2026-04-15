@extends('kepala.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    <div class="flex-1 flex flex-col">

        <!-- NAVBAR -->
        <header class="bg-blue-600 shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-white font-semibold text-lg md:text-xl">
                Dashboard Perpustakaan
            </h1>
        </header>

        <!-- CONTENT -->
        <main class="p-6 space-y-6">

            <!-- STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- TOTAL PENGGUNA -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-5 rounded-2xl shadow-lg hover:scale-[1.02] transition">
                    <p class="text-sm opacity-80">Total Pengguna</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $totalPengguna }}</h2>
                </div>

                <!-- TOTAL BUKU -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-5 rounded-2xl shadow-lg hover:scale-[1.02] transition">
                    <p class="text-sm opacity-80">Total Buku</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $totalBuku }}</h2>
                </div>

            </div>

            <!-- TABEL BUKU -->
            <div class="bg-white rounded-2xl shadow overflow-hidden">

                <!-- HEADER -->
                <div class="p-4 border-b flex justify-between items-center">
                    <h3 class="font-semibold text-gray-700">Buku Terbaru</h3>
                </div>

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        <thead class="bg-gray-100 text-gray-600 text-left">
                            <tr>
                                <th class="p-3">Kode</th>
                                <th class="p-3">Judul</th>
                                <th class="p-3">Penulis</th>
                                <th class="p-3">Stok</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            @forelse ($bukuTerbaru as $buku)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3">{{ $buku->kode_buku }}</td>
                                    <td class="p-3 font-medium">{{ $buku->judul_buku }}</td>
                                    <td class="p-3">{{ $buku->penulis }}</td>

                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $buku->stok > 0 
                                                ? 'bg-green-100 text-green-700' 
                                                : 'bg-red-100 text-red-700' }}">
                                            {{ $buku->stok }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-400">
                                        Tidak ada data buku
                                    </td>
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