@extends('anggota.layouts.app')

@section('content')
<div class="w-full min-h-screen flex justify-center items-center bg-gray-100">

    <div class="w-full max-w-lg">

        <!-- CARD -->
        <div class="bg-white/80 backdrop-blur-lg shadow-xl rounded-2xl p-6 border border-gray-200">

            <!-- TITLE -->
            <h2 class="text-xl font-semibold text-gray-800 text-center mb-6">
            Edit Profile Anggota
            </h2>

            <form action="{{ route('anggota.profile.update', $anggota->id) }}" method="POST" class="space-y-5">
                @csrf 
                @method('PUT')

                <!-- NAMA -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nama</label>
                    <input type="text" name="name"
                        value="{{ old('name', $anggota->user->name ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none transition">
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $anggota->user->email ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none transition">
                </div>

                <!-- NIS -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">NIS</label>
                    <input type="text" name="nis"
                        value="{{ old('nis', $anggota->nis ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none transition">
                </div>

                <!-- KELAS -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Kelas</label>
                    <input type="text" name="kelas"
                        value="{{ old('kelas', $anggota->kelas ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none transition">
                </div>

                <!-- ERROR VALIDATION -->
                @if ($errors->any())
                    <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- BUTTON -->
                <div class="flex gap-3 pt-4">

                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2 rounded-lg shadow hover:scale-105 transition duration-200">
                        Simpan
                    </button>

                    <a href="{{ route('anggota.profile.index') }}"
                        class="flex-1 text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection