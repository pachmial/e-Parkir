<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SlotParkir extends Model
{
    protected $table      = 'slot_parkir';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const     CREATED_AT  = 'dibuat_pada';
    const     UPDATED_AT  = null; // tidak ada kolom updated_at

    protected $fillable = [
        'id', 'lokasi_parkir_id', 'kode_slot', 'lantai',
        'zona', 'jenis_slot', 'status', 'id_sensor', 'terakhir_diperbarui',
    ];

    protected $casts = [
        'dibuat_pada'        => 'datetime',
        'terakhir_diperbarui' => 'datetime',
    ];

    // Relasi
    public function lokasiParkir(): BelongsTo
    {
        return $this->belongsTo(LokasiParkir::class, 'lokasi_parkir_id');
    }

    public function pemesanan(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'slot_id');
    }

    public function logSensor(): HasMany
    {
        return $this->hasMany(LogSensor::class, 'slot_id');
    }

    // Helper: cek apakah slot tersedia
    public function isTersedia(): bool
    {
        return $this->status === 'tersedia';
    }
}
