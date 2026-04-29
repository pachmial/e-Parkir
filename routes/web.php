<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\BookingController;

Route::get('/', fn() => view('splash'));
Route::get('/onboarding', fn() => view('onboarding'));
Route::get('/login', fn() => view('login'));
Route::get('/register', fn() => view('login'));

Route::get('/beranda', fn() => view('beranda'));

Route::get('/map', fn() => view('maps'));


Route::get('/tiket', fn() => view('tiket'));
Route::get('/riwayat', fn() => view('riwayat'));
Route::get('/akun', fn() => view('akun'));

Route::get('/succes', fn() => view('succes'));
Route::get('/qrcode', [QrController::class, 'index']);



// halaman edit
Route::get('/akun/edit', function () {
    return view('editakun');

})->name('akun.edit');

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

Route::post('/proses-booking', [BookingController::class, 'store'])->name('booking.store');

Route::get('/logout', function () {

    Auth::logout(); 

    return redirect('/login');

});
