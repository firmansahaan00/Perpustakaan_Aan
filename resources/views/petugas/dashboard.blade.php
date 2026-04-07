@extends('petugas.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- NAVBAR -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold">Dashboard Petugas</h1>

            <div class="flex items-center gap-3">
                <span class="text-gray-600">Halo, Petugas</span>
                <div class="w-8 h-8 bg-green-500 text-white flex items-center justify-center rounded-full">
                    P
                </div>
            </div>
        </header>


        <!-- CONTENT -->
        <main class="p-6 space-y-6">

            <!-- CARD STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white p-5 rounded-xl shadow">
                    <h4 class="text-gray-500 text-sm">Total Anggota</h4>
                    <p class="text-2xl font-bold mt-2">120</p>
                </div>

                <div class="bg-white p-5 rounded-xl shadow">
                    <h4 class="text-gray-500 text-sm">Buku Dipinjam</h4>
                    <p class="text-2xl font-bold mt-2">45</p>
                </div>

                <div class="bg-white p-5 rounded-xl shadow">
                    <h4 class="text-gray-500 text-sm">Buku Dikembalikan</h4>
                    <p class="text-2xl font-bold mt-2">30</p>
                </div>

            </div>


            <!-- TABEL PEMINJAMAN -->
            <div class="bg-white rounded-xl shadow p-5">

                <h3 class="text-lg font-semibold mb-4">Data Peminjaman Terbaru</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3">Kode</th>
                                <th class="p-3">Nama Anggota</th>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Tanggal Pinjam</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="border-t">
                                <td class="p-3">TRX001</td>
                                <td class="p-3">Andi</td>
                                <td class="p-3">Laravel Dasar</td>
                                <td class="p-3">01-04-2026</td>
                                <td class="p-3 text-green-600">Dipinjam</td>
                            </tr>

                            <tr class="border-t">
                                <td class="p-3">TRX002</td>
                                <td class="p-3">Siti</td>
                                <td class="p-3">PHP OOP</td>
                                <td class="p-3">30-03-2026</td>
                                <td class="p-3 text-blue-600">Dikembalikan</td>
                            </tr>
                        </tbody>

                    </table>
                </div>

            </div>


            <!-- TABEL PENGEMBALIAN -->
            <div class="bg-white rounded-xl shadow p-5">

                <h3 class="text-lg font-semibold mb-4">Pengembalian Terbaru</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3">Nama</th>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Tanggal Kembali</th>
                                <th class="p-3">Denda</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="border-t">
                                <td class="p-3">Budi</td>
                                <td class="p-3">Basis Data</td>
                                <td class="p-3">02-04-2026</td>
                                <td class="p-3 text-red-500">Rp 5.000</td>
                            </tr>

                            <tr class="border-t">
                                <td class="p-3">Rina</td>
                                <td class="p-3">UI/UX Design</td>
                                <td class="p-3">01-04-2026</td>
                                <td class="p-3 text-green-600">Tidak Ada</td>
                            </tr>
                        </tbody>

                    </table>
                </div>

            </div>

        </main>

    </div>

</div>
@endsection
