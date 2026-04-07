<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('kepala.akun.index');
});

Route::get('/akun/dashboard', function () {
    return view('kepala.dashboard');
})->name('kepala.dashboard');
// Route Akun
Route::prefix('kepala.akun')->name('kepala.akun.')->group(function () {

    // TAMPILKAN SEMUA DATA
    Route::get('/', [AkunController::class, 'index'])->name('index');

    // FORM TAMBAH
    Route::get('/create', [AkunController::class, 'create'])->name('create');

    // SIMPAN DATA
    Route::post('/store', [AkunController::class, 'store'])->name('store');

    // FORM EDIT
    Route::get('/edit/{id}', [AkunController::class, 'edit'])->name('edit');

    // UPDATE DATA
    Route::put('/update/{id}', [AkunController::class, 'update'])->name('update');

    // DETAIL DATA
    Route::get('/detail/{id}', [AkunController::class, 'detail'])->name('detail');

    // HAPUS DATA
    Route::delete('/delete/{id}', [AkunController::class, 'destroy'])->name('destroy');

});
//Route Buku
Route::prefix('kepala')->name('kepala.')->group(function () {
    Route::controller(BukuController::class)->group(function () {
        Route::get('/buku', 'index')->name('buku.index');
        Route::get('/buku/create', 'create')->name('buku.create');
        Route::post('/buku', 'store')->name('buku.store');
        Route::get('/buku/{buku}/edit', 'edit')->name('buku.edit');
        Route::put('/buku/{buku}', 'update')->name('buku.update');
        Route::delete('/buku/{buku}', 'destroy')->name('buku.destroy');
    });
});
