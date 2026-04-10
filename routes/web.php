<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLER IMPORT
|--------------------------------------------------------------------------
*/

// Auth
use App\Http\Controllers\AuthController;

// Kepala Perpus
use App\Http\Controllers\KepalaPerpus\DashboardController;
use App\Http\Controllers\KepalaPerpus\AkunController;
use App\Http\Controllers\KepalaPerpus\BukuController as KepalaBukuController;
use App\Http\Controllers\KepalaPerpus\KepalaPerpusController;

// Petugas
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Petugas\PengajuanController as PetugasPengajuanController;
use App\Http\Controllers\Petugas\PengaturanController;
use App\Http\Controllers\Petugas\ProcReturController;
use App\Http\Controllers\Petugas\DendaController;
use App\Http\Controllers\Petugas\PembayaranController;
use App\Http\Controllers\Petugas\PengembalianController;

// Anggota
use App\Http\Controllers\Anggota\BukuController as AnggotaBukuController;
use App\Http\Controllers\Anggota\PengajuanController as AnggotaPengajuanController;


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/', fn() => redirect()->route('login'));

    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');

    Route::get('/register', 'showRegister');
    Route::post('/register', 'register');

    Route::post('/logout', 'logout')->name('logout');
});


/*
|--------------------------------------------------------------------------
| ROLE BASED ROUTE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | KEPALA PERPUSTAKAAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('kepala')->name('kepala.')->middleware('role:kepala_perpus')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::controller(KepalaPerpusController::class)->prefix('profile')->name('profile.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });

        // Akun
        Route::controller(AkunController::class)->prefix('akun')->name('akun.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}', 'detail')->name('detail');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
        });

        // Buku
        Route::controller(KepalaBukuController::class)->prefix('buku')->name('buku.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{buku}/edit', 'edit')->name('edit');
            Route::put('/{buku}', 'update')->name('update');
            Route::delete('/{buku}', 'destroy')->name('destroy');
        });

    });


    /*
    |--------------------------------------------------------------------------
    | PETUGAS
    |--------------------------------------------------------------------------
    */
    Route::prefix('petugas')->name('petugas.')->middleware('role:petugas')->group(function () {

        Route::view('/dashboard', 'petugas.dashboard')->name('dashboard');

        // Profile
        Route::controller(PetugasController::class)->prefix('profile')->name('profile.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });

        // Buku
        Route::controller(PetugasBukuController::class)->prefix('buku')->name('buku.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{buku}/edit', 'edit')->name('edit');
            Route::put('/{buku}', 'update')->name('update');
            Route::delete('/{buku}', 'destroy')->name('destroy');
        });

        // Pengajuan
        Route::get('/pengajuan', [PetugasPengajuanController::class, 'index'])->name('pengajuan.index');
        Route::put('/pengajuan/{id}', [PetugasPengajuanController::class, 'update'])->name('pengajuan.update');

        // Pengaturan
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

        // Pengembalian
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');

        // Proses Retur
        Route::get('/pengembalian/{id}/proses', [ProcReturController::class, 'show'])->name('pengembalian.proses.form');
        Route::post('/pengembalian/{id}/proses', [ProcReturController::class, 'store'])->name('pengembalian.proses');

        // Denda
        Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
        Route::post('/denda/{id}/revisi', [DendaController::class, 'revisi'])->name('denda.revisi');

        // Pembayaran
        Route::get('/pembayaran/{id}', [DendaController::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran/{id}/cicilan', [PembayaranController::class, 'storeCicilan'])->name('pembayaran.cicilan');
        Route::post('/pembayaran/{id}/lunas', [PembayaranController::class, 'storeLunas'])->name('pembayaran.lunas');

    });


    /*
    |--------------------------------------------------------------------------
    | ANGGOTA
    |--------------------------------------------------------------------------
    */
    Route::prefix('anggota')->name('anggota.')->middleware('role:anggota')->group(function () {

        Route::view('/dashboard', 'anggota.dashboard')->name('dashboard');

        // Buku
        Route::get('/buku', [AnggotaBukuController::class, 'index'])->name('buku.index');
        Route::get('/buku/{id}', [AnggotaBukuController::class, 'show'])->name('buku.show');

        // Pengajuan
        Route::get('/pengajuan/{bukuId}/create', [AnggotaPengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan/{bukuId}', [AnggotaPengajuanController::class, 'store'])->name('pengajuan.store');

    });

});