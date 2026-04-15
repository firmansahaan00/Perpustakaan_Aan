@extends('petugas.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow-lg">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Proses Retur: {{ $peminjaman->buku->judul_buku ?? 'Buku tidak ditemukan' }}
    </h2>

    <form action="{{ route('petugas.pengembalian.proses', $peminjaman->id) }}" method="POST">
        @csrf

        {{-- PEMINJAM --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Peminjam:</label>
            <input type="text"
                   class="w-full border rounded-lg px-3 py-2 bg-gray-100"
                   value="{{ $peminjaman->user->name ?? 'User tidak ditemukan' }}"
                   disabled>
        </div>

        {{-- DENDA TELAT --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Denda Telat:</label>
            <input type="text"
                   class="w-full border rounded-lg px-3 py-2 bg-gray-100"
                   value="Rp {{ number_format($telat ?? 0, 0, ',', '.') }}"
                   disabled>
        </div>

        {{-- DENDA LAIN --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Denda Lain:</label>

            <select name="denda_lain" id="denda_lain"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">

                <option value="">Tidak Ada</option>
                <option value="hilang">Hilang</option>
                <option value="rusak">Rusak</option>

            </select>
        </div>

        {{-- NOMINAL --}}
        <div class="mb-4 hidden" id="nominal_lain_container">
            <label class="block text-gray-700 font-medium mb-1">
                Nominal Denda Lain (Rp):
            </label>

            <input type="number"
                   name="nominal_lain"
                   class="w-full border rounded-lg px-3 py-2"
                   min="0"
                   value="">
        </div>

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3">

            @if (($telat ?? 0) > 0)
                <button type="submit" name="aksi" value="simpan_bayar_sekarang"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Simpan & Bayar Sekarang
                </button>

                <button type="submit" name="aksi" value="simpan_bayar_nanti"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan & Bayar Nanti
                </button>
            @else
                <button type="submit" name="aksi" value="langsung_kembali"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Kembalikan Buku
                </button>
            @endif

        </div>

    </form>
</div>

{{-- SCRIPT AMAN --}}
<script>
const dendaSelect = document.getElementById('denda_lain');
const nominalContainer = document.getElementById('nominal_lain_container');

function updateUI() {
    const value = dendaSelect.value;

    if (value === 'hilang' || value === 'rusak') {
        nominalContainer.classList.remove('hidden');
    } else {
        nominalContainer.classList.add('hidden');

        // reset value supaya tidak terkirim tanpa sengaja
        const input = nominalContainer.querySelector('input');
        if (input) input.value = '';
    }
}

dendaSelect.addEventListener('change', updateUI);
</script>
@endsection