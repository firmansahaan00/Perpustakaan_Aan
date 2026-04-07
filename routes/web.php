<?php

use App\Http\Controllers\KepalaPerpus\AkunController;
use App\Http\Controllers\KepalaPerpus\BukuController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Anggota\BukuController as AnggotaBukuController;
use App\Http\Controllers\Anggota\PeminjamanController as AnggotaPeminjamanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KepalaPerpus\KepalaPerpusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL 
|--------------------------------------------------------------------------
*/
// Auth (Login/Register)
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
| DASHBOARD & ROUTE ROLE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Kepala Perpustakaan
    Route::middleware('role:kepala_perpus')->prefix('kepala')->name('kepala.')->group(function () {
        Route::view('/dashboard', 'kepala.dashboard')->name('dashboard');

        //Profile Kepala
        Route::prefix('profile')->name('profile.')->controller(KepalaPerpusController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });

        //Daftar Pengguna Akun Kepala
        Route::prefix('akun')->name('akun.')->controller(AkunController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{id}/detail', 'detail')->name('detail');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}/update', 'update')->name('update');
            Route::delete('/{id}/delete', 'destroy')->name('destroy');
        });

        //Daftar Buku Kepala
        Route::prefix('buku')->name('buku.')->controller(BukuController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{buku}/edit', 'edit')->name('edit');
            Route::put('/{buku}/update', 'update')->name('update');
            Route::delete('/{buku}/delete', 'destroy')->name('destroy');
        });
    });

    // Petugas
    Route::middleware('role:petugas')->prefix('petugas')->name('petugas.')->group(function () {
        Route::view('/dashboard', 'petugas.dashboard')->name('dashboard');

        // Profile Petugas 
        Route::prefix('profile')->name('profile.')->controller(PetugasController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });

        // Daftar Buku Petugas
        Route::prefix('buku')->name('buku.')->controller(PetugasBukuController::class)->group(function () {  // FIX Controller
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{buku}/edit', 'edit')->name('edit');
            Route::put('/{buku}/update', 'update')->name('update');
            Route::delete('/{buku}/delete', 'destroy')->name('destroy');
        });
    });


    // Anggota
    Route::middleware('role:anggota')->prefix('anggota')->name('anggota.')->group(function () {
         Route::view('/dashboard', 'anggota.dashboard')->name('dashboard');

         Route::get('buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

         //Daftar
         Route::prefix('buku')->name('buku.')->controller(AnggotaBukuController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{buku}/edit', 'edit')->name('edit');
            Route::put('/{buku}/update', 'update')->name('update');
            Route::delete('/{buku}/delete', 'destroy')->name('destroy');
        }); 

        Route::prefix('peminjaman')->name('peminjaman.')->controller(AnggotaPeminjamanController::class)->group(function () {
            Route::post('/store', 'store')->name('store'); 
            Route::get('/', 'index')->name('index');      
        });
    });
    
});