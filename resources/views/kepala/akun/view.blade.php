@extends('kepala.layouts.app')

@section('content')
<div class="p-6">

    <!-- Title -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Akun</h2>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 max-w-2xl">

        <!-- Info Utama -->
        <div class="space-y-4">

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">ID</span>
                <span class="text-blue-800">{{ $user->id }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Nama</span>
                <span class="text-gray-800">{{ $user->name }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Email</span>
                <span class="text-gray-800">{{ $user->email }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Role</span>
                <span class="text-blue-600 font-semibold capitalize">{{ $user->role }}</span>
            </div>

            <!-- Anggota -->
            @if($user->role == 'anggota' && $user->anggota)
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">NIS</span>
                <span>{{ $user->anggota->nis }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Kelas</span>
                <span>{{ $user->anggota->kelas }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Alamat</span>
                <span>{{ $user->anggota->alamat ?? '-' }}</span>
            </div>
            @endif

            <!-- Petugas -->
            @if($user->role == 'petugas' && $user->petugas)
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">NIP</span>
                <span>{{ $user->petugas->nip }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">No HP</span>
                <span>{{ $user->petugas->no_hp }}</span>
            </div>
            @endif

            <!-- Kepala -->
            @if($user->role == 'kepala_perpus' && $user->kepalaPerpus)
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">NIP</span>
                <span>{{ $user->kepalaPerpus->nip }}</span>
            </div>
            @endif

        </div>

        <!-- Actions -->
        <div class="flex gap-3 mt-6">

            <a href="{{ route('kepala.akun.edit', $user->id) }}"
               class="px-4 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 transition">
                Edit
            </a>

            <form action="{{ route('kepala.akun.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                    onclick="return confirm('Hapus akun ini?')"
                    class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition">
                    Hapus
                </button>
            </form>

            <a href="{{ route('kepala.akun.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition">
                Kembali
            </a>

        </div>

    </div>
</div>
@endsection