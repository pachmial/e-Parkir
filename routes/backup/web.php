<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BerandaController;

// ✅ AKUN (FIX)
Route::get('/akun', [BerandaController::class, 'profile'])
    ->name('akun')
    ->middleware('auth');

Route::post('/save-kendaraan', [BerandaController::class, 'saveKendaraan'])
    ->name('save.kendaraan');



// ===============================
// YANG LAIN BIARIN
// ===============================

Route::get('/', fn() => view('splash'));
Route::get('/onboarding', fn() => view('onboarding'));
Route::get('/login', fn() => view('login'));
Route::get('/register', fn() => view('login'));

Route::get('/beranda', fn() => view('beranda'));
Route::get('/map', fn() => view('maps'));
Route::get('/tiket', fn() => view('tiket'));
Route::get('/riwayat', fn() => view('riwayat'));

Route::get('/succes', fn() => view('succes'));
Route::get('/qrcode', [QrController::class, 'index']);

// (boleh dihapus, tapi gak wajib)
Route::get('/profile', [BerandaController::class, 'profile'])->middleware('auth');

Route::get('/akun/edit', function () {
    return view('editakun');
})->name('akun.edit');

Route::get('/booking', function () {
    return view('booking');
});

// Auth
Route::post('/register-proses', [AuthController::class, 'register'])->name('register.proses');
Route::post('/login-proses', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ⚠️ FIX TYPO
Route::post('/proses-login', [AuthController::class, 'login'])->name('login.submit');

// Booking
Route::post('/proses-booking', [BookingController::class, 'store'])->name('booking.store');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});
