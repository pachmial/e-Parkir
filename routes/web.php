<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BerandaController;


Route::get('/booking', [BookingController::class, 'index']);
Route::post('/get-snap-token', [BookingController::class, 'getSnapToken']);



Route::get('/success', fn() => view('success'));
Route::get('/qrcode', [QrController::class, 'index']);





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



Route::get('/profile', [BerandaController::class, 'profile'])->middleware('auth');

Route::get('/akun/edit', function () {
    return view('editakun');
})->name('akun.edit');

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



Route::get('/booking/{id}', [ParkingController::class, 'show'])->name('parking.show');