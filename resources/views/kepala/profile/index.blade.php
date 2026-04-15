@extends('kepala.layouts.app')

@section('content')
<div class="w-full min-h-screen flex justify-center items-center bg-gray-100">

    <div class="w-full max-w-md">

        <!-- Card Profil -->
        <div class="bg-white/70 backdrop-blur-md shadow-2xl rounded-3xl p-6 text-center border border-gray-200 hover:scale-105 transform transition duration-300">

            <!-- AVATAR -->
            <div class="flex justify-center">
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center text-3xl font-extrabold shadow-lg ring-4 ring-white">
                    {{ $inisial }}
                </div>
            </div>

            <!-- NAMA -->
            <h2 class="mt-4 text-2xl font-semibold text-gray-900">
                {{ $kepala->user->name ?? '-' }}
            </h2>

            <p class="text-gray-500 text-sm mt-1 tracking-wide">
                Kepala Perpustakaan
            </p>

            <!-- BADGE STATUS -->
            <div class="mt-3">
                <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                    Active
                </span>
            </div>

            <!-- INFO DETAIL -->
            <div class="mt-6 space-y-4 text-left">

                <div class="bg-white/60 p-3 rounded-xl shadow-sm flex flex-col">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Email</p>
                    <p class="font-medium text-gray-900 truncate">
                        {{ $kepala->user->email ?? '-' }}
                    </p>
                </div>

                <div class="bg-white/60 p-3 rounded-xl shadow-sm flex flex-col">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">NIP</p>
                    <p class="font-medium text-gray-900 truncate">
                        {{ $kepala->nip_kepala ?? '-' }}
                    </p>
                </div>

            </div>

            <!-- BUTTON EDIT -->
            @if($kepala)
            <div class="mt-6">
                <a href="{{ route('kepala.profile.edit', $kepala->id) }}"
                   class="w-full inline-block bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-2 rounded-xl shadow-lg hover:scale-105 transform transition duration-300 font-medium">
                     Edit Profile
                </a>
            </div>
            @endif

        </div>

    </div>

</div>
@endsection