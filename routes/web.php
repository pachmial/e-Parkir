<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('splash');
});

Route::get('/halaman1', function () {
    return view('halaman2');
});


Route::get('/halaman2', function () {
    return view('halaman2');
});
Route::get('/map', fn() => view('maps'));

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

Route::get('/booking', function () {
    return view('booking');
});