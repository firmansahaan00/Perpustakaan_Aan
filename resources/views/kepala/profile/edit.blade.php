@extends('kepala.layouts.app')

@section('content')
<div class="w-full min-h-screen flex justify-center items-center bg-gray-100">

    <div class="w-full max-w-lg">

        <!-- CARD -->
        <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200">

            <!-- TITLE -->
            <h2 class="text-xl font-semibold text-gray-800 text-center mb-6">
            Edit Profile Kepala Perpustakaan
            </h2>

            <form action="{{ route('kepala.profile.update', $kepala->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- NAMA -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nama</label>
                    <input type="text" name="name"
                        value="{{ old('name', $kepala->user->name ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email', $kepala->user->email ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- NIP -->
                <div>
                    <label class="block text-sm text-gray-600 mb-1">NIP</label>
                    <input type="text" name="nip_kepala"
                        value="{{ old('nip_kepala', $kepala->nip_kepala ?? '') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3 pt-4">

                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                        Simpan
                    </button>

                    <a href="{{ route('kepala.profile.index') }}"
                        class="flex-1 text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection