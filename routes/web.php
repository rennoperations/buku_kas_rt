<?php

use Illuminate\Support\Facades\Route;

Route::get('/upload', function () {
    return view('upload');
});
Route::get('/warga', function () {
    return view('dashboardwarga');
});
Route::get('/bendahara', function () {
    return view('dashboardbendahara');
});