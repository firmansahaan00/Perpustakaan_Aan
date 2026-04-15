@extends('kepala.layouts.app')

@section('content')

<div class="w-full px-2 md:px-6 py-4">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">👥 Daftar Akun</h1>
            <p class="text-gray-500 text-sm">Kelola semua akun pengguna perpustakaan</p>
        </div>

        <a href="{{ route('kepala.akun.create') }}"
           class="mt-3 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
            + Tambah Akun
        </a>
    </div>

    <!-- NOTIF -->
    @if(session('success'))
    <div id="toast-success"
         class="fixed top-5 right-5 z-50 px-5 py-3 rounded-lg shadow-lg text-white
         {{ str_contains(session('success'), 'hapus') ? 'bg-red-500' : 'bg-green-500' }}">

        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            let toast = document.getElementById('toast-success');
            if (toast) toast.remove();
        }, 3000);
    </script>
    @endif

    <!-- TABLE -->
    <div class="bg-white shadow-lg rounded-xl w-full">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-700">

                <thead class="bg-blue-600 text-xs uppercase text-white">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Level</th>
                        <th class="p-3 text-left">Identitas</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($users as $i => $user)
                    <tr class="hover:bg-gray-100">
                        <td class="p-3">{{ $i + 1 }}</td>
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3 capitalize">{{ $user->role }}</td>

                        <td class="p-3">
                            @if($user->role == 'anggota' && $user->anggota)
                                NIS: {{ $user->anggota->nis }} ({{ $user->anggota->kelas }})
                            @elseif($user->role == 'petugas' && $user->petugas)
                                NIP: {{ $user->petugas->nip_petugas ?? '-' }}
                            @elseif($user->role == 'kepala' && $user->kepala)
                                NIP: {{ $user->kepala->nip_kepala ?? '-' }}
                            @else
                                -
                            @endif
                        </td>

                        <td class="p-3 text-center space-x-1">

                            <a href="{{ route('kepala.akun.show', $user->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
                                Detail
                            </a>

                            <a href="{{ route('kepala.akun.edit', $user->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                                Edit
                            </a>

                            <form id="delete-form-{{ $user->id }}"
                                  action="{{ route('kepala.akun.destroy', $user->id) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    onclick="openModal({{ $user->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
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

<!-- MODAL -->
<div id="deleteModal"
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">

    <div class="bg-white rounded-xl shadow-lg p-6 w-80 text-center">
        <h2 class="font-bold mb-2">Konfirmasi</h2>
        <p class="text-gray-600 mb-4">Hapus akun ini?</p>

        <div class="flex justify-center gap-3">
            <button onclick="closeModal()"
                class="px-4 py-2 bg-gray-300 rounded">
                Batal
            </button>

            <button id="confirmDelete"
                class="px-4 py-2 bg-red-500 text-white rounded">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
let deleteId = null;

function openModal(id) {
    deleteId = id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('confirmDelete').addEventListener('click', function () {
    if (deleteId) {
        document.getElementById('delete-form-' + deleteId).submit();
    }
});
</script>

@endsection
