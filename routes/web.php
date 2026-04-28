<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('splash');
});


Route::get('/halaman2', function () {
    return view('halaman2');
});
Route::get('/map', fn() => view('maps'));

Route::get('/halamanriwayat', function () {
    return view('halamanriwayat');
});
Route::get('/pilihparkir', function () {
    return view('pilihparkir');
});

Route::get('/booking', function () {
    return view('booking');
});


// Route Proses Auth
Route::post('/register-proses', [AuthController::class, 'register'])->name('register.proses');
Route::post('/login-proses', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/proses-register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/proses-login', [AuthConteroller::class, 'login'])->name('login.submit');

// Menampilkan halaman
Route::get('/login', function () { return view('login'); })->name('login');
Route::get('/register', function () { return view('register'); });

// Memproses data
Route::post('/proses-register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/proses-login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/onboarding', function () {
    return view('onboarding'); // Pastikan kamu punya file halaman1.blade.php
})->middleware('auth'); // Opsional: supaya hanya yang sudah login bisa buka

Route::post('/proses-booking', [BookingController::class, 'store'])->name('booking.store');
