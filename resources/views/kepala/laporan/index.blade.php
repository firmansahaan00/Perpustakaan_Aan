@extends('kepala.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">

    <!-- TITLE -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Laporan Perpustakaan</h1>
        <p class="text-gray-500 text-sm">Rekap data peminjaman, pengembalian, penolakan, dan denda</p>
    </div>

    <!-- FILTER -->
    <form method="GET" class="bg-white p-4 rounded-xl shadow flex flex-wrap items-center gap-3">

        <input type="month" name="bulan" value="{{ request('bulan') }}"
            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">

        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            Filter
        </button>

        <a href="{{ route('kepala.laporan.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow">
            Reset
        </a>

    </form>

    <!-- ================= PEMINJAMAN ================= -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-4 border-b font-semibold bg-green-600 text-white">
            Data Peminjaman
        </div>

        <table class="w-full text-sm">
            <thead class="bg-green-100 text-green-800 text-left">
                <tr>
                    <th class="p-3">User</th>
                    <th class="p-3">Buku</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Tanggal Pinjam</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($peminjaman as $p)
                <tr class="hover:bg-gray-50">
                    <td class="p-3">{{ $p->user->name }}</td>
                    <td class="p-3">{{ $p->buku->judul_buku }}</td>
                    <td class="p-3">
                        @if($p->status == 'dipinjam')
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Dipinjam</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="p-3 text-gray-600">
                        {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d-m-Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-400">Data kosong</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ================= PENGEMBALIAN ================= -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-4 border-b font-semibold bg-yellow-500 text-white">
            Pengembalian
        </div>

        <table class="w-full text-sm">

            <thead class="bg-yellow-100 text-yellow-800 text-left">
                <tr>
                    <th class="p-3">User</th>
                    <th class="p-3">Buku</th>
                    <th class="p-3">Tanggal Kembali</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($pengembalian as $p)
                <tr class="hover:bg-gray-50">
                    <td class="p-3">{{ $p->user->name }}</td>
                    <td class="p-3">{{ $p->buku->judul_buku }}</td>
                    <td class="p-3 text-gray-600">
                        {{ $p->tanggal_kembali ? \Carbon\Carbon::parse($p->tanggal_kembali)->format('d-m-Y') : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-400">Data kosong</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- ================= PENOLAKAN (MAROON) ================= -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-4 border-b font-semibold bg-red-900 text-white">
            Penolakan
        </div>

        <table class="w-full text-sm">

            <thead class="bg-red-100 text-red-800 text-left">
                <tr>
                    <th class="p-3">User</th>
                    <th class="p-3">Buku</th>
                    <th class="p-3">Tanggal</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($ditolak as $p)
                <tr class="hover:bg-gray-50">
                    <td class="p-3">{{ $p->user->name }}</td>
                    <td class="p-3">{{ $p->buku->judul_buku }}</td>
                    <td class="p-3 text-gray-600">
                        {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d-m-Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-400">Data kosong</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- ================= DENDA ================= -->
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-4 border-b font-semibold bg-red-600 text-white">
            Denda
        </div>

        <table class="w-full text-sm">

            <thead class="bg-red-100 text-red-800 text-left">
                <tr>
                    <th class="p-3">User</th>
                    <th class="p-3">Buku</th>
                    <th class="p-3">Jumlah</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Tanggal</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($denda as $d)
                <tr class="hover:bg-gray-50">

                    <td class="p-3">{{ $d->peminjaman->user->name ?? '-' }}</td>
                    <td class="p-3">{{ $d->peminjaman->buku->judul_buku ?? '-' }}</td>

                    <td class="p-3 font-medium text-red-600">
                        Rp {{ number_format((int)$d->nominal_tagihan,0,',','.') }}
                    </td>

                    <td class="p-3">
                        @if($d->status_denda == 'lunas')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Lunas</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Belum</span>
                        @endif
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $d->created_at->format('d-m-Y') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-400">Data kosong</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection