<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\AuthController;

// ── Auth ─────────────────────────────────────────
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// ── Redirect root ─────────────────────────────────
Route::get('/', function () {
    return redirect('/login');
});

// ── Warga (harus login, role: warga atau bendahara) ──
Route::middleware(['auth'])->group(function () {
    Route::get('/warga',    [IuranController::class, 'indexWarga']);
    Route::post('/api/scan-struk',  [IuranController::class, 'scanOCR']);
    Route::post('/api/bayar-iuran', [IuranController::class, 'simpanPembayaran']);
});

// ── Bendahara (harus login, role: bendahara) ─────────
Route::middleware(['auth', 'bendahara'])->group(function () {
    Route::get('/bendahara', [IuranController::class, 'indexBendahara']);
    Route::post('/api/transaksi/{id}/verifikasi', [IuranController::class, 'verifikasiBendahara']);
});
