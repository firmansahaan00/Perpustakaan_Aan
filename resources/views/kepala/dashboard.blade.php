@extends('kepala.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- NAVBAR -->
        <header class="bg-blue-600 shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-white font-bold text-lg md:text-xl">Dashboard Petugas Perpustakaan</h1>
        </header>

        <!-- CONTENT -->
        <main class="p-6 space-y-6">

            <!-- CARD STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Total Pengguna -->
                <div class="bg-blue-500 text-white p-5 rounded-xl shadow-xl flex flex-col items-center justify-center hover:scale-105 transform transition">
                    <h4 class="text-white text-sm uppercase tracking-wider">Total Pengguna</h4>
                    <p class="text-3xl font-bold mt-2">{{ $totalPengguna }}</p>
                </div>

                <!-- Total Buku -->
                <div class="bg-green-500 text-white p-5 rounded-xl shadow-xl flex flex-col items-center justify-center hover:scale-105 transform transition">
                    <h4 class="text-white text-sm uppercase tracking-wider">Total Buku</h4>
                    <p class="text-3xl font-bold mt-2">{{ $totalBuku }}</p>
                </div>

                <!-- Transaksi -->
                <div class="bg-yellow-500 text-white p-5 rounded-xl shadow-xl flex flex-col items-center justify-center hover:scale-105 transform transition">
                    <h4 class="text-white text-sm uppercase tracking-wider">Transaksi</h4>
                    <p class="text-3xl font-bold mt-2">-</p> <!-- nanti diisi -->
                </div>

            </div>

            <!-- TABEL BUKU TERBARU -->
            <div class="bg-white rounded-xl shadow p-5">
                <h3 class="text-lg font-semibold mb-4">Buku Terbaru</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-center border text-gray-800">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="p-3">Kode</th>
                                <th class="p-3">Judul</th>
                                <th class="p-3">Penulis</th>
                                <th class="p-3">Stok</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-700">
                            @foreach ($bukuTerbaru as $buku)
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="p-3">{{ $buku->kode_buku }}</td>
                                    <td class="p-3">{{ $buku->judul_buku }}</td>
                                    <td class="p-3">{{ $buku->penulis }}</td>
                                    <td class="p-3">{{ $buku->stok }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>
@endsection