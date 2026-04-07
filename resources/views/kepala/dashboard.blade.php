@extends('layouts.app')

@section('content')
<div class="p-4">

    <!-- UCAPAN -->
    <div class="mb-4 p-3 rounded shadow-sm bg-light">
        <h5 class="mb-0">
            Selamat Datang, <strong>{{ Auth::user()->name ?? 'Kembali' }}</strong> 👋
        </h5>
    </div>

    <!-- CARD STATISTIK -->
    <div class="row text-white mb-4">

        <!-- Total Anggota -->
        <div class="col-md-4 mb-3">
            <div class="p-4 rounded shadow text-center" style="background-color:#16a34a;">
                <h2 class="fw-bold">{{ $totalAnggota ?? 0 }}</h2>
                <small>Total Anggota</small>
            </div>
        </div>

        <!-- Total Buku -->
        <div class="col-md-4 mb-3">
            <div class="p-4 rounded shadow text-center" style="background-color:#eab308;">
                <h2 class="fw-bold">{{ $totalBuku ?? 0 }}</h2>
                <small>Total Buku</small>
            </div>
        </div>

        <!-- Total Denda -->
        <div class="col-md-4 mb-3">
            <div class="p-4 rounded shadow text-center" style="background-color:#dc2626;">
                <h2 class="fw-bold">{{ $totalDenda ?? 0 }}</h2>
                <small>Total Denda</small>
            </div>
        </div>

    </div>

    <!-- INFO TAMBAHAN -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5>Informasi</h5>
            <p class="text-muted mb-0">
                Selamat datang di sistem E-Perpustakaan. Anda dapat memantau data anggota, buku, dan laporan denda di sini.
            </p>
        </div>
    </div>

</div>
@endsection
