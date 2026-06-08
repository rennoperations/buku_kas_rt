<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landing');
});

// 2. Rute Autentikasi (Sistem Login & Logout)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister']);

// 3. Rute Khusus Warga (Gembok: Hanya bisa diakses kalau sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/warga', [IuranController::class, 'indexWarga']);
    
    // API untuk Scan AI dan Kirim Pembayaran
    Route::post('/api/scan-struk', [IuranController::class, 'scanOCR']);
    Route::post('/api/bayar-iuran', [IuranController::class, 'simpanPembayaran']);
});

// 4. Rute Khusus Bendahara (Gembok Ganda: Harus login & harus berstatus bendahara)
Route::middleware(['auth', 'bendahara'])->group(function () {
    // Menu Utama
    Route::get('/bendahara', [IuranController::class, 'indexBendahara']);
    Route::get('/bendahara/verifikasi-pembayaran', [IuranController::class, 'verifikasiPembayaran']);
    Route::get('/bendahara/data-warga', [IuranController::class, 'dataWarga']);
    Route::get('/bendahara/pemasukan', [IuranController::class, 'pemasukan']);
    Route::get('/bendahara/laporan', [IuranController::class, 'laporan']);
    Route::get('/bendahara/pengaturan', [IuranController::class, 'pengaturan']);
    
    // API untuk Verifikasi Aksi Bendahara
    Route::post('/api/transaksi/{id}/verifikasi', [IuranController::class, 'verifikasiBendahara']);
});