@extends('anggota.layouts.app')

@section('content')
<div class="w-full min-h-screen flex justify-center items-center bg-gray-100 p-4">

    <div class="w-full max-w-sm">

        <!-- CARD PROFILE -->
        <div class="bg-white/70 backdrop-blur-md shadow-xl rounded-2xl p-5 text-center border border-gray-200 transition hover:scale-[1.02] duration-300">

            <!-- AVATAR -->
            <div class="flex justify-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-blue-500 to-blue-600 text-white flex items-center justify-center text-2xl font-bold shadow-md ring-2 ring-white">
                    {{ $inisial }}
                </div>
            </div>

            <!-- NAMA -->
            <h2 class="mt-3 text-xl font-semibold text-gray-900">
                {{ $anggota->user->name ?? '-' }}
            </h2>

            <p class="text-gray-500 text-xs mt-1">
                Anggota Perpustakaan
            </p>

            <!-- STATUS -->
            <div class="mt-2">
                <span class="bg-blue-100 text-blue-700 text-[11px] font-semibold px-3 py-1 rounded-full">
                    Active Member
                </span>
            </div>

            <!-- INFO DETAIL -->
            <div class="mt-4 space-y-3 text-left">

                <!-- EMAIL -->
                <div class="bg-white/60 p-2.5 rounded-lg shadow-sm">
                    <p class="text-[11px] text-gray-500 uppercase">Email</p>
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $anggota->user->email ?? '-' }}
                    </p>
                </div>

                <!-- NIS -->
                <div class="bg-white/60 p-2.5 rounded-lg shadow-sm">
                    <p class="text-[11px] text-gray-500 uppercase">NIS</p>
                    <p class="text-sm font-medium text-gray-900">
                        {{ $anggota->nis ?? '-' }}
                    </p>
                </div>

                <!-- KELAS -->
                <div class="bg-white/60 p-2.5 rounded-lg shadow-sm">
                    <p class="text-[11px] text-gray-500 uppercase">Kelas</p>
                    <p class="text-sm font-medium text-gray-900">
                        {{ $anggota->kelas ?? '-' }}
                    </p>
                </div>

            </div>

            <!-- BUTTON EDIT -->
            @if($anggota)
            <div class="mt-5">
                <a href="{{ route('anggota.profile.edit', $anggota->id) }}"
                   class="w-full inline-block bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2 rounded-lg shadow hover:scale-[1.02] transition font-medium text-sm">
                    Edit Profile
                </a>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection