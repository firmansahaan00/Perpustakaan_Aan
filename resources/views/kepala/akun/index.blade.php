@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">👥 Daftar Akun</h1>
            <p class="text-gray-500 text-sm">Kelola semua akun pengguna perpustakaan</p>
        </div>
        <a href="{{ route('kepala.akun.create') }}"
           class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl shadow transition">
            + Tambah Akun
        </a>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-700">
                <!-- Head -->
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-4 text-left">#</th>
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-left">Level</th>
                        <th class="p-4 text-left">Identitas</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody class="divide-y bg-white">
                    @foreach($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4 font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4 capitalize">{{ $user->level }}</td>
                        <td class="p-4">
                            @if($user->level == 'anggota' && $user->anggota)
                                NIS: {{ $user->anggota->nis }} / {{ $user->anggota->kelas }}
                            @elseif($user->level == 'petugas' && $user->petugas)
                                NIP: {{ $user->petugas->nip_petugas ?? '-' }}
                            @elseif($user->level == 'kepala' && $user->kepala)
                                NIP: {{ $user->kepala->nip_kepala ?? '-' }}
                            @else
                                -
                            @endif
                        </td>

                        <td class="p-4 text-center space-x-2">
                            <a href="{{ route('kepala.akun.detail', $user->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                                Detail
                            </a>
                            <a href="{{ route('kepala.akun.edit', $user->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg text-xs shadow">
                                Edit
                            </a>
                            <form action="{{ route('kepala.akun.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus akun ini?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs shadow">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
