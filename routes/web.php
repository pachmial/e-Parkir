<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

Route::get('/', fn() => view('splash'));
Route::get('/onboarding', fn() => view('onboarding'));
Route::get('/login', fn() => view('login'));
Route::get('/register', fn() => view('login'));

Route::get('/beranda', fn() => view('beranda'));
Route::get('/pilihparkir', fn() => view('pilihparkir'));

Route::get('/tiket', fn() => view('tiket'));
Route::get('/riwayat', fn() => view('riwayat'));
Route::get('/akun', fn() => view('akun'));

// halaman edit
Route::get('/akun/edit', function () {
    return view('editakun');

})->name('akun.edit');


Route::get('/logout', function () {

    Auth::logout(); 

    return redirect('/login');

});