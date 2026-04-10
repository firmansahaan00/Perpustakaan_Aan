@extends('anggota.layouts.app')

@section('content')
<div class="p-6 max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            Ajukan Peminjaman • {{ $buku->judul_buku }}
        </h2>

        <a href="{{ route('anggota.buku.show', $buku->id) }}"
           class="text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg px-3 py-1 text-sm transition">
            ← Kembali
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row gap-6">

        {{-- COVER --}}
        <div class="md:w-1/3">
            <div class="rounded-xl overflow-hidden bg-gray-100 h-64">
                <img src="{{ $buku->cover 
                    ? Storage::url($buku->cover) 
                    : asset('images/default-book.png') }}" 
                    alt="{{ $buku->judul_buku }}"
                    class="w-full h-full object-cover">
            </div>
        </div>

        {{-- FORM --}}
        <div class="md:w-2/3">
            <form action="{{ route('anggota.pengajuan.store', $buku->id) }}" method="POST">
                @csrf

                {{-- Tanggal Pinjam --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" readonly
                        value="{{ $tanggalPinjam }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Tanggal Jatuh Tempo --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                    <input type="date" name="tanggal_jatuh_tempo" readonly
                        value="{{ $tanggalJatuhTempo }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- INFO DENDA --}}
                <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-lg text-sm">
                    📌 Lama pinjam: <b>{{ $pengaturan->max_revisi_hari }} hari</b><br>
                    💰 Denda telat: <b>Rp {{ number_format($pengaturan->denda_per_hari) }}/hari</b>
                </div>

                {{-- STATUS --}}
                <div class="mb-4">
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                        Status: Menunggu Persetujuan
                    </span>
                </div>

                {{-- BUTTON --}}
                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow transition disabled:bg-gray-300"
                        {{ $buku->stok < 1 ? 'disabled' : '' }}>
                        Ajukan Sekarang
                    </button>

                    <a href="{{ route('anggota.buku.index') }}"
                       class="border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>

</div>

{{-- STYLE TAMBAHAN --}}
<style>
/* Optional: smooth shadow hover */
form button:disabled {
    cursor: not-allowed;
}
</style>
@endsection