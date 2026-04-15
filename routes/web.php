<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

// Auth
use App\Http\Controllers\AuthController;

// Kepala Perpus
use App\Http\Controllers\KepalaPerpus\DashboardController as KepalaDashboardController;
use App\Http\Controllers\KepalaPerpus\AkunController;
use App\Http\Controllers\KepalaPerpus\BukuController as KepalaBukuController;
use App\Http\Controllers\KepalaPerpus\KepalaPerpusController;
use App\Http\Controllers\KepalaPerpus\LaporanController;

// Petugas
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Petugas\PengajuanController as PetugasPengajuanController;
use App\Http\Controllers\Petugas\PengaturanController;
use App\Http\Controllers\Petugas\ProcReturController;
use App\Http\Controllers\Petugas\DendaController;
use App\Http\Controllers\Petugas\PembayaranController;
use App\Http\Controllers\Petugas\PengembalianController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;

// Anggota
use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;
use App\Http\Controllers\Anggota\BukuController as AnggotaBukuController;
use App\Http\Controllers\Anggota\PengajuanController as AnggotaPengajuanController;
use App\Http\Controllers\Anggota\RiwayatController;
use App\Http\Controllers\Anggota\AnggotaController;

 use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/', fn () => redirect()->route('login'));

    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');

    Route::post('/logout', 'logout')->name('logout');
});


/*
|--------------------------------------------------------------------------
| AUTH PROTECTED
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | KEPALA PERPUS
    |--------------------------------------------------------------------------
    */
    Route::prefix('kepala')
        ->name('kepala.')
        ->middleware('role:kepala_perpus')
        ->group(function () {

        // Dashboard
        Route::get('/dashboard', [KepalaDashboardController::class, 'index'])
            ->name('dashboard');

        // Profile
        Route::prefix('profile')
            ->name('profile.')
            ->controller(KepalaPerpusController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
            });

        // Akun
        Route::prefix('akun')
            ->name('akun.')
            ->controller(AkunController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}', 'show')->name('show');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        // Buku
        Route::prefix('buku')
            ->name('buku.')
            ->controller(KepalaBukuController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{buku}/edit', 'edit')->name('edit');
                Route::put('/{buku}', 'update')->name('update');
                Route::delete('/{buku}', 'destroy')->name('destroy');
            });

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');
    });


    /*
    |--------------------------------------------------------------------------
    | PETUGAS
    |--------------------------------------------------------------------------
    */
    Route::prefix('petugas')
        ->name('petugas.')
        ->middleware('role:petugas')
        ->group(function () {

        // Dashboard (FIX: controller salah sebelumnya)
        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
            ->name('dashboard');

        // Profile
        Route::prefix('profile')
            ->name('profile.')
            ->controller(PetugasController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
            });

        // Buku
        Route::prefix('buku')
            ->name('buku.')
            ->controller(PetugasBukuController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{buku}/edit', 'edit')->name('edit');
                Route::put('/{buku}', 'update')->name('update');
                Route::delete('/{buku}', 'destroy')->name('destroy');
            });

        // Pengajuan
        Route::prefix('pengajuan')
            ->name('pengajuan.')
            ->controller(PetugasPengajuanController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/{id}', 'update')->name('update');
            });

        // Pengaturan
        Route::prefix('pengaturan')
            ->name('pengaturan.')
            ->controller(PengaturanController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'update')->name('update');
            });

        // Pengembalian
        Route::prefix('pengembalian')
            ->name('pengembalian.')
            ->group(function () {
                Route::get('/', [PengembalianController::class, 'index'])->name('index');
                Route::get('/{id}/proses', [ProcReturController::class, 'show'])->name('proses.form');
                Route::post('/{id}/proses', [ProcReturController::class, 'store'])->name('proses');
            });

        // Denda
        Route::prefix('denda')
            ->name('denda.')
            ->controller(DendaController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/{id}/revisi', 'revisi')->name('revisi');
            });

        // Pembayaran
        Route::prefix('pembayaran')
            ->name('pembayaran.')
            ->controller(PembayaranController::class)
            ->group(function () {
                Route::post('/cicilan/{peminjaman_id}', 'storeCicilan')->name('cicilan');
                Route::post('/lunas/{peminjaman_id}', 'storeLunas')->name('lunas');
            });
    });


    /*
    |--------------------------------------------------------------------------
    | ANGGOTA
    |--------------------------------------------------------------------------
    */
    Route::prefix('anggota')
        ->name('anggota.')
        ->middleware('role:anggota')
        ->group(function () {

        // Dashboard (FIX: harus controller, bukan Route::view)
        Route::get('/dashboard', [AnggotaDashboardController::class, 'index'])
            ->name('dashboard');

        // Buku
        Route::prefix('buku')
            ->name('buku.')
            ->controller(AnggotaBukuController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
            });

        // Pengajuan
        Route::prefix('pengajuan')
            ->name('pengajuan.')
            ->controller(AnggotaPengajuanController::class)
            ->group(function () {
                Route::get('/{bukuId}/create', 'create')->name('create');
                Route::post('/{bukuId}', 'store')->name('store');
                Route::post('/pinjam/{id}', 'pinjamLagi')->name('pinjam.lagi');
            });

        // Riwayat
        Route::get('/riwayat', [RiwayatController::class, 'index'])
            ->name('riwayat.index');
            
            Route::post('/anggota/{id}', [AnggotaPengajuanController::class, 'pinjamLagi'])
    ->name('pinjam.lagi');
    //profile
    Route::get('/profile', [AnggotaController::class, 'index'])
            ->name('profile.index');

        Route::get('/profile/{id}/edit', [AnggotaController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile/{id}', [AnggotaController::class, 'update'])
            ->name('profile.update');
    });

   

Route::get('/notif/read/{id}', function ($id) {

    $notif = Notifikasi::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $notif->update([
        'is_read' => true
    ]);

    return back();

})->name('notif.read');
});