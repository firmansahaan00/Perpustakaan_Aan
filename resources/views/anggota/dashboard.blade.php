@extends('anggota.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    <div class="flex-1 flex flex-col">

        
        <header class="bg-blue-600 shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-white font-bold">Dashboard Anggota</h1>

            <div class="flex items-center gap-4">

                <div x-data="{ open: false }" class="relative">

    @php
        $notifikasi = $notifikasi ?? collect();
        $unread = $notifikasi->where('is_read', false)->count();
    @endphp

   
    <div @click="open = !open"
        class="bg-white p-2 rounded-full shadow-sm cursor-pointer border relative">

        
        <i data-feather="bell" class="w-3 h-3 text-[#004d4d]"></i>

       
        <span class="absolute top-0 right-0 bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full border-2 border-white
            {{ $unread == 0 ? 'hidden' : '' }}">
            {{ $unread }}
        </span>

    </div>

    
    <div x-show="open"
         x-transition
         @click.outside="open = false"
         class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-lg border z-[999] overflow-hidden">

        <div class="p-4 border-b font-semibold">
            Notifikasi
        </div>

        <div class="max-h-80 overflow-y-auto">

            @forelse($notifikasi as $notif)

                @php
                    $icon = 'bell';
                    $color = 'text-blue-500';

                    if (str_contains($notif->pesan, 'Disetujui')) {
                        $icon = 'check-circle';
                        $color = 'text-green-500';
                    } elseif (str_contains($notif->pesan, 'Ditolak')) {
                        $icon = 'x-circle';
                        $color = 'text-red-500';
                    } elseif (str_contains($notif->pesan, 'jatuh tempo')) {
                        $icon = 'clock';
                        $color = 'text-yellow-500';
                    }
                @endphp

                <a href="{{ url('/notif/read/'.$notif->id) }}"
                   class="block p-4 border-b text-sm flex items-start gap-3 hover:bg-gray-50
                   {{ $notif->is_read ? 'opacity-50' : '' }}">

                    <!-- FEATHER ICON (DYNAMIC) -->
                    <i data-feather="{{ $icon }}" class="w-5 h-5 {{ $color }} mt-1"></i>

                    <div>
                        <span class="font-medium text-[#004d4d]">
                            {{ $notif->pesan }}
                        </span>

                        <div class="text-xs text-gray-400 mt-1">
                            {{ $notif->created_at->diffForHumans() }}
                        </div>
                    </div>

                </a>

            @empty
                <div class="p-4 text-sm text-gray-400 text-center">
                    Tidak ada notifikasi
                </div>
            @endforelse

        </div>

    </div>

</div>

            </div>
        </header>

    
        <main class="p-6 space-y-8">

   
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-green-700 p-5 rounded-xl shadow">
                    <h4 class="text-white text-center">Sedang Dipinjam</h4>
                    <p class="text-center text-white font-bold mt-2 text-xl">
                        {{ $dipinjam ?? 0 }}
                    </p>
                </div>

                <div class="bg-yellow-700 p-5 rounded-xl shadow">
                    <h4 class="text-white text-center">Sudah Dikembalikan</h4>
                    <p class="text-center text-white font-bold mt-2 text-xl">
                        {{ $dikembalikan ?? 0 }}
                    </p>
                </div>

                <div class="bg-red-700 p-5 rounded-xl shadow">
                    <h4 class="text-white text-center">Total Denda</h4>
                    <p class="text-center font-bold mt-2 text-white text-xl">
                        Rp {{ number_format($totalDenda ?? 0) }}
                    </p>
                </div>

            </div>

         
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="p-4 border-b font-semibold text-[#004d4d]">
                    Buku Sedang Dipinjam
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-blue-600 text-white text-center">
                            <tr>
                                <th class="p-3">No</th>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Tanggal Pinjam</th>
                                <th class="p-3">Jatuh Tempo</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($peminjamanAktif ?? [] as $i => $pinjam)
                                <tr class="border-b">
                                    <td class="p-3">{{ $i + 1 }}</td>
                                    <td class="p-3 font-medium">
                                        {{ $pinjam->buku->judul ?? '-' }}
                                    </td>
                                    <td class="p-3">
                                        {{ $pinjam->tanggal_pinjam ?? '-' }}
                                    </td>
                                    <td class="p-3">
                                        {{ $pinjam->jatuh_tempo ?? '-' }}
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                            Dipinjam
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-400">
                                        Tidak ada buku yang sedang dipinjam
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

          
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="p-4 border-b font-semibold text-[#004d4d]">
                    Buku Kena Denda
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-red-600 text-white text-center">
                            <tr>
                                <th class="p-3">No</th>
                                <th class="p-3">Judul Buku</th>
                                <th class="p-3">Terlambat</th>
                                <th class="p-3">Denda</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($dendaList ?? [] as $i => $denda)
                                <tr class="border-b">
                                    <td class="p-3">{{ $i + 1 }}</td>
                                    <td class="p-3 font-medium">
                                        {{ $denda->peminjaman->buku->judul ?? '-' }}
                                    </td>
                                    <td class="p-3">
                                        {{ $denda->hari_terlambat ?? 0 }} hari
                                    </td>
                                    <td class="p-3">
                                        Rp {{ number_format($denda->jumlah ?? 0) }}
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                            Kena Denda
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-400">
                                        Tidak ada denda
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

<script src="//unpkg.com/alpinejs" defer></script>
@endsection