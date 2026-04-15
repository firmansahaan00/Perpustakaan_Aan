@extends('petugas.layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Pengaturan Denda & Peminjaman</h2>
        <a href="{{ route('petugas.pengajuan.index') }}"
            class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm shadow">
            ← Kembali
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="mb-4 p-3 text-green-700 bg-green-100 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM --}}
    <div class="bg-white shadow rounded-2xl p-6">
        <form action="{{ route('petugas.pengaturan.update') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Denda per Hari --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Denda per Hari (Rp)</label>
                <input type="number" name="denda_per_hari" 
                    value="{{ old('denda_per_hari', $pengaturan->denda_per_hari) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            {{-- Maksimal Hari Peminjaman --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Maksimal Hari Peminjaman</label>
                <input type="number" name="max_revisi_hari" 
                    value="{{ old('max_revisi_hari', $pengaturan->max_revisi_hari) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            {{-- BUTTON SUBMIT --}}
            <div class="flex gap-3 mt-4">
                <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                    Simpan
                </button>
                <button type="reset" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow">
                    Reset
                </button>
            </div>

        </form>
    </div>
</div>
@endsection