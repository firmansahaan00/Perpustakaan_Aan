@extends('petugas.layouts.app')

@section('content')
<div class="w-full h-full flex justify-center items-center">

    <div class="w-full max-w-lg">

        <!-- CARD -->
        <div class="bg-white/80 backdrop-blur-lg shadow-xl rounded-2xl p-6 border border-gray-200">

            <!-- TITLE -->
            <h2 class="text-xl font-semibold text-gray-800 text-center mb-6">
                ✏️ Edit Profile
            </h2>

            <form action="{{ route('petugas.profile.update', $petugas->id) }}" method="POST" class="space-y-5">
                @csrf 
                @method('PUT')

                <!-- NAMA -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nama</label>
                    <input type="text" name="name"
                        value="{{ old('name', $petugas->user->name ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $petugas->user->email ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                </div>

                <!-- NIP -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">NIP</label>
                    <input type="text" name="nip_petugas"
                        value="{{ old('nip_petugas', $petugas->nip_petugas ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3 pt-4">

                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-2 rounded-lg shadow hover:scale-105 transition duration-200">
                        💾 Simpan
                    </button>

                    <a href="{{ route('petugas.profile.index') }}"
                        class="flex-1 text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                        ⬅️ Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection
