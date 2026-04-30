<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pemesanan extends Model
{



    protected $table      = 'pemesanan';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const     CREATED_AT  = 'dibuat_pada';
    const     UPDATED_AT  = 'diperbarui_pada';

    protected $fillable = [
        'id', 'pengguna_id', 'slot_id', 'kendaraan_id',
        'kode_pemesanan', 'waktu_mulai', 'waktu_selesai',
        'durasi_jam', 'total_harga', 'status', 'catatan',
    ];

    protected $casts = [
        'waktu_mulai'    => 'datetime',
        'waktu_selesai'  => 'datetime',
        'durasi_jam'     => 'decimal:2',
        'total_harga'    => 'decimal:2',
        'dibuat_pada'    => 'datetime',
        'diperbarui_pada' => 'datetime',
    ];

    // Relasi
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }


    
    public function slotParkir(): BelongsTo
    {
        return $this->belongsTo(SlotParkir::class, 'slot_id');
    }

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'pemesanan_id');
    }

    // Helper: cek apakah pemesanan bisa dibatalkan
    public function bisaDibatalkan(): bool
    {
        return in_array($this->status, ['menunggu', 'aktif']);
    }

    
}
