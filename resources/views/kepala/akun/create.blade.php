@extends('kepala.layouts.app')

@section('content')

<div class="max-w-3xl mx-auto mt-6">

    <!-- CARD -->
    <div class="bg-white shadow-xl rounded-2xl p-6">

        <!-- HEADER -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Akun</h2>
            <p class="text-gray-500 text-sm">Isi data sesuai role pengguna</p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('kepala.akun.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- LEVEL -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
            <select name="role" id="role"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                required>
                <option value="" disabled selected>-- Pilih Level --</option>
                <option value="anggota">Anggota</option>
                <option value="petugas">Petugas</option>
                <option value="kepala">Kepala</option>
            </select>
        </div>

        <!-- USER -->
        <div>
            <label class="block text-sm text-gray-700 mb-1">Nama</label>
            <input type="text" name="name"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                required>
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Email</label>
            <input type="email" name="email"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                    required>
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
                    required>
            </div>
        </div>

        <!-- ANGGOTA -->
        <div id="anggota" class="hidden border-t pt-4">
            <h4 class="font-semibold text-gray-700 mb-2">📘 Data Anggota</h4>

            <input type="text" name="nis" placeholder="NIS"
                class="w-full mb-2 border rounded-lg px-3 py-2" disabled>

            <input type="text" name="kelas" placeholder="Kelas"
                class="w-full mb-2 border rounded-lg px-3 py-2" disabled>

            <input type="text" name="alamat" placeholder="Alamat"
                class="w-full border rounded-lg px-3 py-2" disabled>
        </div>

        <!-- PETUGAS -->
        <div id="petugas" class="hidden border-t pt-4">
            <h4 class="font-semibold text-gray-700 mb-2">🧑‍💼 Data Petugas</h4>

            <input type="text" name="nip_petugas" placeholder="NIP Petugas"
                class="w-full mb-2 border rounded-lg px-3 py-2" disabled>

            <input type="text" name="no_hp" placeholder="No HP"
                class="w-full border rounded-lg px-3 py-2" disabled>
        </div>

        <!-- KEPALA -->
        <div id="kepala" class="hidden border-t pt-4">
            <h4 class="font-semibold text-gray-700 mb-2">👨‍💼 Data Kepala</h4>

            <input type="text" name="nip_kepala" placeholder="NIP Kepala"
                class="w-full border rounded-lg px-3 py-2" disabled>
        </div>

        <!-- BUTTON -->
        <div class="flex justify-between pt-4">
            <a href="{{ route('kepala.akun.index') }}"
               class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                Batal
            </a>

            <button type="submit"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow">
                Simpan
            </button>
        </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const level = document.getElementById('role');
    const anggota = document.getElementById('anggota');
    const petugas = document.getElementById('petugas');
    const kepala  = document.getElementById('kepala');

    function resetAll() {
        anggota.classList.add('hidden');
        petugas.classList.add('hidden');
        kepala.classList.add('hidden');

        document.querySelectorAll('#anggota input, #petugas input, #kepala input')
            .forEach(el => {
                el.disabled = true;
                el.required = false;
            });
    }

    function toggleField() {
        resetAll();

        if (level.value === 'anggota') {
            anggota.classList.remove('hidden');
            anggota.querySelectorAll('input').forEach(el => el.disabled = false);

            document.querySelector('[name="nis"]').required = true;
            document.querySelector('[name="kelas"]').required = true;

        } else if (level.value === 'petugas') {
            petugas.classList.remove('hidden');
            petugas.querySelectorAll('input').forEach(el => el.disabled = false);

        } else if (level.value === 'kepala') {
            kepala.classList.remove('hidden');
            kepala.querySelectorAll('input').forEach(el => el.disabled = false);
        }
    }

    level.addEventListener('change', toggleField);
});
</script>
@endpush
