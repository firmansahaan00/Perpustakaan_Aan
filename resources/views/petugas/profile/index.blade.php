@extends('petugas.layouts.app')

@section('content')
<div class="w-full h-full flex justify-center items-center">

    <div class="w-full max-w-md">

        <div class="bg-white/80 backdrop-blur-lg shadow-xl rounded-2xl p-6 text-center border border-gray-200">

            <!-- AVATAR -->
            <div class="flex justify-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white flex items-center justify-center text-2xl font-bold shadow-lg">
                    {{ $inisial }}
                </div>
            </div>

            <!-- NAMA -->
            <h2 class="mt-4 text-xl font-semibold text-gray-800">
                {{ $petugas->user->name ?? '-' }}
            </h2>

            <p class="text-gray-500 text-sm">
                Petugas Perpustakaan
            </p>

            <!-- BADGE -->
            <div class="mt-2">
                <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full">
                    Active
                </span>
            </div>

            <!-- INFO -->
            <div class="mt-6 space-y-3 text-left">

                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-500">Email</p>
                    <p class="font-medium text-gray-800">
                        {{ $petugas->user->email ?? '-' }}
                    </p>
                </div>

                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-xs text-gray-500">NIP</p>
                    <p class="font-medium text-gray-800">
                        {{ $petugas->nip_petugas ?? '-' }}
                    </p>
                </div>

            </div>

            <!-- BUTTON -->
            @if($petugas)
            <div class="mt-6">
                <a href="{{ route('petugas.profile.edit', $petugas->id) }}"
                   class="w-full inline-block bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-2 rounded-lg shadow hover:scale-105 transition duration-200">
                    Edit Profile
                </a>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection
