<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BerandaController;

// ─── AKUN ─────────────────────────────────────────────────────────────────────
Route::get('/akun', [BerandaController::class, 'profile'])
    ->name('akun')
    ->middleware('auth');

Route::post('/save-kendaraan', [BerandaController::class, 'saveKendaraan'])
    ->name('save.kendaraan');

// ─── HALAMAN UTAMA ────────────────────────────────────────────────────────────
Route::get('/', fn() => view('splash'));
Route::get('/onboarding', fn() => view('onboarding'));
Route::get('/login', fn() => view('login'))->name('login');
Route::get('/register', fn() => view('register'));

Route::get('/beranda', [BerandaController::class, 'index'])
    ->middleware('auth');
Route::get('/map', fn() => view('maps'));
Route::get('/tiket', fn() => view('tiket'));
Route::get('/riwayat', fn() => view('riwayat'));

Route::get('/succes', fn() => view('succes'));
Route::get('/qrcode', [QrController::class, 'index']);

Route::get('/profile', [BerandaController::class, 'profile'])->middleware('auth');

Route::get('/akun/edit', function () {
    return view('editakun');
})->name('akun.edit');

Route::get('/booking', function () {
    return view('booking');
});

// ─── AUTH 
Route::post('/register-proses', [AuthController::class, 'register'])->name('register.submit');
Route::post('/login-proses', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/proses-login', [AuthController::class, 'login'])->name('login.submit');

// ─── BOOKING ──────────────────────────────────────────────────────────────────
Route::post('/proses-booking', [BookingController::class, 'store'])->name('booking.store');

// ─── LOGOUT VIA GET ───────────────────────────────────────────────────────────
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});
