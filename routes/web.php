<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('splash');
});

Route::get('/halaman1', function () {
    return view('halaman1');
});


Route::get('/halaman2', function () {
    return view('halaman2');
});
Route::get('/halaman3', function () {
    return view('halaman3');
});
Route::get('/halaman4', function () {
    return view('halaman4');
});
Route::get('/halamanriwayat', function () {
    return view('halamanriwayat');
});
Route::get('/pilihparkir', function () {
    return view('pilihparkir');
});


// Route Proses Auth
Route::post('/register-proses', [AuthController::class, 'register'])->name('register.proses');
Route::post('/login-proses', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/proses-register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/proses-login', [AuthController::class, 'login'])->name('login.submit');

// Menampilkan halaman
Route::get('/halaman3', function () { return view('halaman3'); })->name('login');
Route::get('/halaman4', function () { return view('halaman4'); });

// Memproses data
Route::post('/proses-register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/proses-login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/halaman1', function () {
    return view('halaman1'); // Pastikan kamu punya file halaman1.blade.php
})->middleware('auth'); // Opsional: supaya hanya yang sudah login bisa buka