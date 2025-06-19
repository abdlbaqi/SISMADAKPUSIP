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
    Route::resource('surat-masuk', SuratMasukController::class);
    Route::get('/surat-masuk/{suratMasuk}/unduh', [SuratMasukController::class, 'unduhFile'])->name('surat-masuk.unduh-file');
    
    // Surat Keluar
    Route::resource('surat-keluar', SuratKeluarController::class);
    Route::post('/surat-keluar/{suratKeluar}/setuju', [SuratKeluarController::class, 'setuju'])->name('surat-keluar.setuju');
    Route::post('/surat-keluar/{suratKeluar}/kirim', [SuratKeluarController::class, 'kirim'])->name('surat-keluar.kirim');
    Route::get('/surat-keluar/{suratKeluar}/unduh', [SuratKeluarController::class, 'unduhFile'])->name('surat-keluar.unduh');
    
    // Disposisi
    Route::resource('disposisi', DisposisiController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/disposisi/{disposisi}/terima', [DisposisiController::class, 'terima'])->name('disposisi.terima');
    Route::post('/disposisi/{disposisi}/proses', [DisposisiController::class, 'proses'])->name('disposisi.proses');
    Route::post('/disposisi/{disposisi}/selesai', [DisposisiController::class, 'selesai'])->name('disposisi.selesai');
    
    // Arsip
    Route::resource('arsip', ArsipController::class);
    Route::get('/arsip/{arsip}/unduh', [ArsipController::class, 'unduhFile'])->name('arsip.unduh');
    
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


    // Surat Masuk
Route::get('/surat-masuk/arsip', [SuratMasukController::class, 'arsip'])->name('surat-masuk.arsip');

// Surat Keluar  
Route::get('/surat-keluar/arsip', [SuratKeluarController::class, 'arsip'])->name('surat-keluar.arsip');

// Laporan
Route::get('/laporan/surat-masuk', [LaporanController::class, 'suratMasuk'])->name('laporan.surat-masuk');
Route::get('/laporan/surat-keluar', [LaporanController::class, 'suratKeluar'])->name('laporan.surat-keluar');

// Profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
});