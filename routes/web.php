<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\LaporanController;

// Halaman utama redirect ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Rute autentikasi
Route::get('/masuk', [AuthController::class, 'tampilkanMasuk'])->name('login');
Route::post('/masuk', [AuthController::class, 'masuk']);
Route::post('/keluar', [AuthController::class, 'keluar'])->name('keluar');

// Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Surat Masuk
    Route::get('/surat-masuk/export-pdf', [SuratMasukController::class, 'exportPdf'])->name('surat-masuk.export-pdf');
     Route::get('/surat-masuk/export', [SuratMasukController::class, 'export'])->name('surat-masuk.export');
    Route::resource('surat-masuk', SuratMasukController::class);
    Route::get('/surat-masuk/{suratMasuk}/unduh', [SuratMasukController::class, 'unduhFile'])->name('surat-masuk.unduh-file');
    // Tambahkan route ini di dalam group route surat-masuk

    
    // Surat Keluar
    Route::get('/surat-keluar/export-pdf', [SuratKeluarController::class, 'exportPdf'])->name('surat-keluar.export-pdf');
    Route::get('/surat-keluar/export', [SuratKeluarController::class, 'export'])->name('surat-keluar.export');
    Route::resource('surat-keluar', SuratKeluarController::class);
    Route::get('/surat-keluar/{suratKeluar}/unduh', [SuratKeluarController::class, 'unduhFile'])->name('surat-keluar.unduh-file');
    
    // Kategori Surat (hanya admin)
    Route::middleware(['peran:admin'])->group(function () {
        Route::resource('kategori-surat', KategoriSuratController::class);
        Route::resource('pengguna', PenggunaController::class);
    });
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/surat-masuk', [LaporanController::class, 'suratMasuk'])->name('laporan.surat-masuk');
    Route::get('/laporan/surat-keluar', [LaporanController::class, 'suratKeluar'])->name('laporan.surat-keluar');
    Route::get('/laporan/disposisi', [LaporanController::class, 'disposisi'])->name('laporan.disposisi');
    Route::get('/laporan/arsip', [LaporanController::class, 'arsip'])->name('laporan.arsip');



// Laporan
Route::get('/laporan/surat-masuk', [LaporanController::class, 'suratMasuk'])->name('laporan.surat-masuk');
Route::get('/laporan/surat-keluar', [LaporanController::class, 'suratKeluar'])->name('laporan.surat-keluar');
Route::get('surat-keluar/{suratKeluar}/download', [SuratKeluarController::class, 'downloadFile'])
         ->name('surat-keluar.download');


// Profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
});