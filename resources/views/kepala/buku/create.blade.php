@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-xl rounded-2xl w-full max-w-4xl p-8">

        <h1 class="text-2xl font-bold mb-6 text-gray-700">Tambah Buku</h1>

        <form action="{{ route('kepala.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Kiri -->
                <div>
                    <label class="text-sm text-gray-600">Kode Buku</label>
                    <input type="text" name="kode_buku"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Judul Buku</label>
                    <input type="text" name="judul_buku"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Penulis</label>
                    <input type="text" name="penulis"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tahun Terbit</label>
                    <input type="int" name="tahun_terbit"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Stok</label>
                    <input type="number" name="stok"
                        class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Cover Buku</label>
                    <input type="file" name="cover"
                        class="w-full mt-1 p-2 border rounded-lg bg-gray-50">
                </div>

            </div>

            <!-- Full width -->
            <div class="mt-6">
                <label class="text-sm text-gray-600">Sinopsis</label>
                <textarea name="sinopsis"
                    class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400"
                    rows="4"></textarea>
            </div>

            <div class="mt-6 flex justify-end">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg shadow">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>
@endsection
