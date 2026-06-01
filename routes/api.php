<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IuranController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute untuk melakukan OCR (Kirim gambar ke Python)
Route::post('/scan-struk', [IuranController::class, 'scanStruk']);

// Rute untuk menyimpan hasil transaksi ke MySQL
Route::post('/simpan-transaksi', [IuranController::class, 'simpanTransaksi']);