@extends('petugas.layouts.app')

@section('content')
<div class="p-6 max-w-6xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-800 mb-6">Manajemen Denda</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg shadow">
            {{ session('error') }}
        </div>
    @endif

    {{-- TAB --}}
    <div class="flex border-b mb-4">
        <button class="tab-btn px-4 py-2 font-medium text-blue-600 border-b-2 border-blue-600" data-tab="nunggak">
            🔴 Denda Nunggak
        </button>
        <button class="tab-btn px-4 py-2 font-medium text-gray-500" data-tab="lunas">
            🟢 Denda Lunas
        </button>
    </div>

    {{-- ================= NUNGGAK ================= --}}
    <div id="nunggak" class="tab-content">
        <div class="overflow-x-auto bg-white rounded-2xl shadow">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-3 text-left">User</th>
                        <th class="p-3 text-left">Buku</th>
                        <th class="p-3">Jenis</th>
                        <th class="p-3">Tagihan</th>
                        <th class="p-3">Dibayar</th>
                        <th class="p-3">Sisa</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($nunggak as $d)

                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3">{{ $d->peminjaman->user->name }}</td>
                            <td class="p-3">{{ $d->peminjaman->buku->judul_buku }}</td>
                            <td class="p-3 capitalize">{{ $d->jenis }}</td>

                            <td class="p-3 font-semibold">
                                Rp {{ number_format($d->nominal_tagihan) }}
                            </td>

                            <td class="p-3 text-green-600">
                                Rp {{ number_format($d->total_bayar) }}
                            </td>

                            <td class="p-3 text-red-600">
                                Rp {{ number_format($d->sisa) }}
                            </td>

                            <td class="p-3">
                                @if($d->status_text == 'Lunas')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Lunas</span>
                                @elseif($d->status_text == 'Sebagian')
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Sebagian</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Belum</span>
                                @endif
                            </td>

                            <td class="p-3 space-y-1">
                                <button onclick="openModal('bayar{{ $d->id }}')"
                                    class="w-full bg-green-600 text-white px-2 py-1 rounded text-xs hover:bg-green-700">
                                    Bayar
                                </button>

                                @if($d->jenis == 'hilang')
                                    <button onclick="openModal('revisi{{ $d->id }}')"
                                        class="w-full bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700">
                                        Revisi
                                    </button>
                                @endif
                            </td>
                        </tr>

                        {{-- ================= MODAL BAYAR ================= --}}
                        <div id="bayar{{ $d->id }}" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                            <div class="bg-white rounded-2xl w-full max-w-md p-6">

                                <h3 class="font-semibold text-lg mb-3">Bayar Denda</h3>

                                <form method="POST" action="{{ route('petugas.pembayaran.cicilan', $d->peminjaman_id) }}">
                                    @csrf

                                    <input type="hidden" name="denda_id" value="{{ $d->id }}">

                                    <p>Total: <b>Rp {{ number_format($d->nominal_tagihan) }}</b></p>
                                    <p class="text-green-600">Sudah: Rp {{ number_format($d->total_bayar) }}</p>
                                    <p class="text-red-600 mb-3">Sisa: Rp {{ number_format($d->sisa) }}</p>

                                    <input type="number" name="total_bayar"
                                        class="w-full border border-gray-300 rounded-lg p-2 mb-2"
                                        placeholder="Nominal" required>

                                    <select name="metode"
                                        class="w-full border border-gray-300 rounded-lg p-2 mb-3">
                                        <option value="tunai">Tunai</option>
                                        <option value="transfer">Transfer</option>
                                    </select>

                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="closeModal('bayar{{ $d->id }}')"
                                            class="px-3 py-1 bg-gray-300 rounded-lg">Batal</button>

                                        <button type="submit"
                                            class="px-3 py-1 bg-green-600 text-white rounded-lg">
                                            Bayar
                                        </button>
                                    </div>
                                </form>

                                {{-- LUNAS SEKALIGUS --}}
                                <form method="POST" action="{{ route('petugas.pembayaran.lunas', $d->peminjaman_id) }}" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="denda_id" value="{{ $d->id }}">
                                    <input type="hidden" name="metode" value="tunai">

                                    <button class="w-full bg-blue-600 text-white py-1 rounded text-xs hover:bg-blue-700">
                                        Lunaskan Sekaligus
                                    </button>
                                </form>

                            </div>
                        </div>

                        {{-- ================= MODAL REVISI ================= --}}
                        <div id="revisi{{ $d->id }}" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
                            <div class="bg-white rounded-2xl w-full max-w-md p-6">

                                <h3 class="font-semibold text-lg mb-3">Revisi Denda</h3>

                                <form method="POST" action="{{ route('petugas.denda.revisi', $d->id) }}">
                                    @csrf

                                    <p>User: {{ $d->peminjaman->user->name }}</p>
                                    <p>Buku: {{ $d->peminjaman->buku->judul_buku }}</p>

                                    <input type="number" name="nominal_baru"
                                        class="w-full border border-gray-300 rounded-lg p-2 my-2"
                                        placeholder="Nominal Baru" required>

                                    <textarea name="keterangan"
                                        class="w-full border border-gray-300 rounded-lg p-2 mb-3"
                                        placeholder="Keterangan"></textarea>

                                    <div class="flex justify-end gap-2">
                                        <button type="button" onclick="closeModal('revisi{{ $d->id }}')"
                                            class="px-3 py-1 bg-gray-300 rounded-lg">Batal</button>

                                        <button class="px-3 py-1 bg-red-600 text-white rounded-lg">
                                            Simpan
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-4 text-gray-500">
                                Tidak ada denda
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= LUNAS ================= --}}
    <div id="lunas" class="tab-content hidden">
        <div class="overflow-x-auto bg-white rounded-2xl shadow">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-3 text-left">User</th>
                        <th class="p-3 text-left">Buku</th>
                        <th class="p-3">Jenis</th>
                        <th class="p-3">Tagihan</th>
                        <th class="p-3">Dibayar</th>
                        <th class="p-3">Sisa</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lunas as $d)
                        <tr>
                            <td class="p-3">{{ $d->peminjaman->user->name }}</td>
                            <td class="p-3">{{ $d->peminjaman->buku->judul_buku }}</td>
                            <td class="p-3 capitalize">{{ $d->jenis }}</td>

                            <td class="p-3 font-semibold">
                                Rp {{ number_format($d->nominal_tagihan) }}
                            </td>

                            <td class="p-3 text-green-600">
                                Rp {{ number_format($d->total_bayar) }}
                            </td>

                            <td class="p-3 text-red-600">Rp 0</td>

                            <td class="p-3">
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                    Lunas
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-4 text-gray-500">
                                Tidak ada denda lunas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- JS --}}
<script>
function openModal(id){
    document.getElementById(id).classList.remove('hidden');
}
function closeModal(id){
    document.getElementById(id).classList.add('hidden');
}

document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {

        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('text-blue-600','border-b-2','border-blue-600');
            b.classList.add('text-gray-500');
        });

        btn.classList.add('text-blue-600','border-b-2','border-blue-600');

        const tab = btn.getAttribute('data-tab');

        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.getElementById(tab).classList.remove('hidden');
    });
});
</script>
@endsection
