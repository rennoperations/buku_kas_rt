<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IuranController;

// Redirect root ke halaman warga
Route::get('/', function () {
    return redirect('/warga');
});

// Tampilan Halaman Utama
Route::get('/warga', [IuranController::class, 'indexWarga']);
Route::get('/bendahara', [IuranController::class, 'indexBendahara']);

// Endpoint API internal yang dipanggil oleh JavaScript Fetch di Blade
Route::post('/api/scan-struk', [IuranController::class, 'scanOCR']);
Route::post('/api/bayar-iuran', [IuranController::class, 'simpanPembayaran']);
Route::post('/api/transaksi/{id}/verifikasi', [IuranController::class, 'verifikasiBendahara']);