@extends('anggota.layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">

    <h2 class="text-3xl font-bold text-gray-800 mb-6">
        Riwayat Peminjaman
    </h2>

    {{-- NOTIF --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow">
            {{ session('error') }}
        </div>
    @endif



    <div class="mb-10">
        <h3 class="text-xl font-semibold mb-3 text-green-600">Dipinjam</h3>

        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="w-full text-center text-left">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="p-3">Buku</th>
                        <th class="p-3">Tanggal Pinjam</th>
                        <th class="p-3">Jatuh Tempo</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dipinjam as $item)
                    <tr class="border-b">
                        <td class="p-3">{{ $item->buku->judul_buku }}</td>
                        <td class="p-3">{{ $item->tanggal_pinjam }}</td>
                        <td class="p-3">{{ $item->tanggal_jatuh_tempo ?? '-' }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">
                                Dipinjam
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


   
    <div class="mb-10">
        <h3 class="text-xl font-semibold mb-3 text-blue-600">Dikembalikan</h3>

        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="w-full text-center text-left">
                <thead class="bg-blue-600 text-white text-center">
                    <tr>
                        <th class="p-3">Buku</th>
                        <th class="p-3">Pinjam</th>
                        <th class="p-3">Kembali</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dikembalikan as $item)
                    <tr class="border-b">
                        <td class="p-3">{{ $item->buku->judul_buku }}</td>
                        <td class="p-3">{{ $item->tanggal_pinjam }}</td>
                        <td class="p-3">{{ $item->tanggal_kembali }}</td>
                        <td class="p-3">

                            <form action="{{ route('anggota.pinjam.lagi', $item->id) }}" method="POST">
                                @csrf
                                <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                    Pinjam Lagi
                                </button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



<div class="mb-10">
    <h3 class="text-xl font-semibold mb-3 text-red-600">Denda</h3>

    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="w-full text-center text-left">
            <thead class="bg-red-600 text-white text-center">
                <tr>
                    <th class="p-3">Buku</th>
                    <th class="p-3">Total Denda</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($denda as $item)
                    <tr class="border-b">
                        <td class="p-3">
                            {{ $item->buku->judul_buku ?? '-' }}
                        </td>

                        <td class="p-3">
                            Rp {{ number_format($item->denda_sum_nominal_tagihan ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="p-3">
                            @if(($item->denda_sum_nominal_tagihan ?? 0) > 0)
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">
                                    Ada Denda
                                </span>
                            @else
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                    Tidak Ada Denda
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-3 text-center text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
        
<div class="mb-10">
    <h3 class="text-xl font-semibold mb-3 text-red-700">
        Ditolak
    </h3>

    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="w-full text-center text-left">
            <thead class="bg-red-700 text-white text-center">
                <tr>
                    <th class="p-3">Buku</th>
                    <th class="p-3">Tanggal Pengajuan</th>
                    <th class="p-3">Alasan Tolak</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($ditolak as $item)
                    <tr class="border-b">
                        <td class="p-3">
                            {{ $item->buku->judul_buku ?? '-' }}
                        </td>

                        <td class="p-3">
                            {{ $item->created_at->format('d-m-Y') }}
                        </td>


                        <td class="p-3">
                            {{ $item->catatan }}
                        </td>

                        <td class="p-3">
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">
                                Ditolak
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-3 text-center text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>
@endsection
