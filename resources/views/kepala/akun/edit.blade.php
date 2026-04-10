@extends('kepala.layouts.app')

@section('content')

<div class="max-w-4xl mx-auto p-6">

```
<!-- Card -->
<div class="bg-white shadow-xl rounded-2xl p-6">
    
    <!-- Header -->
    <div class="mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">
            Edit Akun
        </h2>
        <p class="text-gray-500 text-sm">
            {{ $user->name }}
        </p>
    </div>

    <form action="{{ route('kepala.akun.update', $user->id) }}" method="POST" class="space-y-6">
        @method('PUT')
        @csrf

        <!-- Role -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Role</label>
            <input type="text" value="{{ ucfirst($user->role) }}"
                class="w-full px-4 py-2 bg-gray-100 border rounded-lg text-gray-500" disabled>
            <p class="text-xs text-gray-400 mt-1">Role tidak bisa diubah</p>
        </div>

        <!-- Nama -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Nama *</label>
            <input type="text" name="name"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none @error('name') border-red-500 @enderror"
                value="{{ old('name', $user->name) }}">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Email *</label>
            <input type="email" name="email"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none @error('email') border-red-500 @enderror"
                value="{{ old('email', $user->email) }}">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Divider -->
        <div class="border-t pt-4"></div>

        <!-- Anggota -->
        @if($user->role == 'anggota' && $user->anggota)
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Data Anggota</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">NIS *</label>
                    <input type="text" name="nis"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 @error('nis') border-red-500 @enderror"
                        value="{{ old('nis', $user->anggota->nis) }}">
                    @error('nis')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Kelas *</label>
                    <input type="text" name="kelas"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 @error('kelas') border-red-500 @enderror"
                        value="{{ old('kelas', $user->anggota->kelas) }}">
                    @error('kelas')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <label class="text-sm text-gray-600">Alamat</label>
                <input type="text" name="alamat"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                    value="{{ old('alamat', $user->anggota->alamat) }}">
            </div>
        </div>
        @endif

        <!-- Petugas -->
        @if($user->role == 'petugas' && $user->petugas)
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Data Petugas</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">NIP</label>
                    <input type="text" name="nip_petugas"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 @error('nip_petugas') border-red-500 @enderror"
                        value="{{ old('nip_petugas', $user->petugas->nip_petugas) }}">
                    @error('nip_petugas')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">No HP</label>
                    <input type="text" name="no_hp"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                        value="{{ old('no_hp', $user->petugas->no_hp) }}">
                </div>
            </div>
        </div>
        @endif

        <!-- Kepala -->
        @if($user->role == 'kepala' && $user->kepala)
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Data Kepala Perpus</h3>

            <div>
                <label class="text-sm text-gray-600">NIP</label>
                <input type="text" name="nip_kepala"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 @error('nip_kepala') border-red-500 @enderror"
                    value="{{ old('nip_kepala', $user->kepala->nip_kepala) }}">
                @error('nip_kepala')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>
        @endif

        <!-- Buttons -->
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('kepala.akun.index') }}"
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700">
               Batal
            </a>
            <button type="submit"
                class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow">
                Update
            </button>
        </div>

    </form>
</div>
```

</div>
@endsection
