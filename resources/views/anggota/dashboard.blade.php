@extends('anggota.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    
    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- NAVBAR -->
        <header class="bg-blue-600 shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-white font-bold">Dashboard Anggota</h1>
        </header>


        <!-- CONTENT -->
        <main class="p-6 space-y-6">

            <!-- CARD STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-green-700 p-5 rounded-xl shadow">
                    <h4 class="text-white text-center">Sedang Dipinjam</h4>
                    <p class="text-center text-white font-bold mt-2 text-xl">2</p>
                </div>

                <div class="bg-yellow-700 p-5 rounded-xl shadow">
                    <h4 class="text-white text-center">Sudah Dikembalikan</h4>
                    <p class="text-center text-white font-bold mt-2 text-xl">10</p>
                </div>

                <div class="bg-red-700 p-5 rounded-xl shadow">
                    <h4 class="text-white text-center">Total Denda</h4>
                    <p class="text-center font-bold mt-2 text-white text-xl">Rp 5.000</p>
                </div>

            </div>


            <!-- BUKU YANG SEDANG DIPINJAM -->
            <div class="bg-white rounded-xl shadow p-5">

                <h3 class="text-lg font-semibold mb-4">Buku Sedang Dipinjam</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border">

                        <thead class="bg-blue-600 text-white ">
                            <tr>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Tanggal Pinjam</th>
                                <th class="p-3">Batas Kembali</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="border-t">
                                <td class="p-3">Laravel Dasar</td>
                                <td class="p-3">01-04-2026</td>
                                <td class="p-3">08-04-2026</td>
                                <td class="p-3 text-green-600">Dipinjam</td>
                            </tr>

                            <tr class="border-t">
                                <td class="p-3">PHP OOP</td>
                                <td class="p-3">30-03-2026</td>
                                <td class="p-3">06-04-2026</td>
                                <td class="p-3 text-yellow-500">Hampir Jatuh Tempo</td>
                            </tr>
                        </tbody>

                    </table>
                </div>

            </div>


            <!-- RIWAYAT PEMINJAMAN -->
            <div class="bg-white rounded-xl shadow p-5">

                <h3 class="text-lg font-semibold mb-4">Riwayat Peminjaman</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border">

                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Tanggal Pinjam</th>
                                <th class="p-3">Tanggal Kembali</th>
                                <th class="p-3">Denda</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="border-t">
                                <td class="p-3">Basis Data</td>
                                <td class="p-3">20-03-2026</td>
                                <td class="p-3">27-03-2026</td>
                                <td class="p-3 text-red-500">Rp 5.000</td>
                            </tr>

                            <tr class="border-t">
                                <td class="p-3">UI/UX Design</td>
                                <td class="p-3">10-03-2026</td>
                                <td class="p-3">17-03-2026</td>
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