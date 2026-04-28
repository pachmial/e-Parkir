<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\LokasiParkirController;
use App\Http\Controllers\SlotParkirController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LogSensorController;
use App\Http\Controllers\NotifikasiController;

/*
|--------------------------------------------------------------------------
| E-Parkir API Routes
|--------------------------------------------------------------------------
|
| Prefix  : /api
| Versi   : v1
|
*/

// ─── AUTH ─────────────────────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/logout',   [AuthController::class, 'logout']);
});

// ─── PENGGUNA ─────────────────────────────────────────────────────────────────
Route::prefix('pengguna')->group(function () {
    Route::get('/',                                    [PenggunaController::class, 'index']);        // GET    /api/pengguna          — admin
    Route::get('/{id}',                                [PenggunaController::class, 'show']);         // GET    /api/pengguna/{id}
    Route::put('/{id}',                                [PenggunaController::class, 'update']);       // PUT    /api/pengguna/{id}
    Route::put('/{id}/ganti-password',                 [PenggunaController::class, 'gantiPassword']); // PUT  /api/pengguna/{id}/ganti-password
    Route::delete('/{id}',                             [PenggunaController::class, 'destroy']);      // DELETE /api/pengguna/{id}    — admin

    // Kendaraan milik pengguna
    Route::get('/{penggunaId}/kendaraan',              [KendaraanController::class, 'index']);       // GET    /api/pengguna/{id}/kendaraan
    Route::post('/{penggunaId}/kendaraan',             [KendaraanController::class, 'store']);       // POST   /api/pengguna/{id}/kendaraan

    // Notifikasi milik pengguna
    Route::get('/{penggunaId}/notifikasi',             [NotifikasiController::class, 'index']);      // GET    /api/pengguna/{id}/notifikasi
    Route::put('/{penggunaId}/notifikasi/baca-semua',  [NotifikasiController::class, 'bacaSemua']);  // PUT    /api/pengguna/{id}/notifikasi/baca-semua
});

// ─── KENDARAAN ────────────────────────────────────────────────────────────────
Route::prefix('kendaraan')->group(function () {
    Route::get('/{id}',    [KendaraanController::class, 'show']);    // GET    /api/kendaraan/{id}
    Route::put('/{id}',    [KendaraanController::class, 'update']);  // PUT    /api/kendaraan/{id}
    Route::delete('/{id}', [KendaraanController::class, 'destroy']); // DELETE /api/kendaraan/{id}
});

// ─── LOKASI PARKIR ────────────────────────────────────────────────────────────
Route::prefix('lokasi-parkir')->group(function () {
    Route::get('/',    [LokasiParkirController::class, 'index']);   // GET    /api/lokasi-parkir
    Route::post('/',   [LokasiParkirController::class, 'store']);   // POST   /api/lokasi-parkir      — admin
    Route::get('/{id}',    [LokasiParkirController::class, 'show']);    // GET    /api/lokasi-parkir/{id}
    Route::put('/{id}',    [LokasiParkirController::class, 'update']);  // PUT    /api/lokasi-parkir/{id} — admin
    Route::delete('/{id}', [LokasiParkirController::class, 'destroy']); // DELETE /api/lokasi-parkir/{id} — admin

    // Slot di bawah lokasi parkir
    Route::get('/{lokasiId}/slot',  [SlotParkirController::class, 'index']); // GET  /api/lokasi-parkir/{id}/slot
    Route::post('/{lokasiId}/slot', [SlotParkirController::class, 'store']); // POST /api/lokasi-parkir/{id}/slot — admin
});

// ─── SLOT PARKIR ──────────────────────────────────────────────────────────────
Route::prefix('slot-parkir')->group(function () {
    Route::get('/{id}',    [SlotParkirController::class, 'show']);    // GET    /api/slot-parkir/{id}
    Route::put('/{id}',    [SlotParkirController::class, 'update']);  // PUT    /api/slot-parkir/{id}   — admin
    Route::delete('/{id}', [SlotParkirController::class, 'destroy']); // DELETE /api/slot-parkir/{id}   — admin

    // Log sensor per slot
    Route::get('/{slotId}/log-sensor', [LogSensorController::class, 'index']); // GET /api/slot-parkir/{id}/log-sensor
});

// ─── PEMESANAN ────────────────────────────────────────────────────────────────
Route::prefix('pemesanan')->group(function () {
    Route::get('/',    [PemesananController::class, 'index']); // GET  /api/pemesanan?pengguna_id=xxx&status=xxx
    Route::post('/',   [PemesananController::class, 'store']); // POST /api/pemesanan
    Route::get('/{id}',              [PemesananController::class, 'show']);     // GET  /api/pemesanan/{id}
    Route::put('/{id}/selesai',      [PemesananController::class, 'selesai']);  // PUT  /api/pemesanan/{id}/selesai
    Route::put('/{id}/batalkan',     [PemesananController::class, 'batalkan']); // PUT  /api/pemesanan/{id}/batalkan
});

// ─── PEMBAYARAN ───────────────────────────────────────────────────────────────
Route::prefix('pembayaran')->group(function () {
    Route::get('/',    [PembayaranController::class, 'index']); // GET  /api/pembayaran?pemesanan_id=xxx
    Route::post('/',   [PembayaranController::class, 'store']); // POST /api/pembayaran
    Route::get('/{id}',             [PembayaranController::class, 'show']);       // GET /api/pembayaran/{id}
    Route::put('/{id}/konfirmasi',  [PembayaranController::class, 'konfirmasi']); // PUT /api/pembayaran/{id}/konfirmasi
});

// ─── LOG SENSOR ───────────────────────────────────────────────────────────────
Route::prefix('log-sensor')->group(function () {
    Route::post('/', [LogSensorController::class, 'store']); // POST /api/log-sensor — dari perangkat IoT
});

// ─── NOTIFIKASI ───────────────────────────────────────────────────────────────
Route::prefix('notifikasi')->group(function () {
    Route::post('/',          [NotifikasiController::class, 'store']);      // POST   /api/notifikasi         — admin/internal
    Route::put('/{id}/baca',  [NotifikasiController::class, 'tandaiBaca']); // PUT    /api/notifikasi/{id}/baca
    Route::delete('/{id}',    [NotifikasiController::class, 'destroy']);    // DELETE /api/notifikasi/{id}
});
