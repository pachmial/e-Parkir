<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LokasiParkir extends Model
{
    protected $table      = 'lokasi_parkir';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const     CREATED_AT  = 'dibuat_pada';
    const     UPDATED_AT  = 'diperbarui_pada';

    protected $fillable = [
        'id', 'nama', 'alamat', 'latitude', 'longitude',
        'total_slot', 'harga_per_jam', 'jam_buka', 'jam_tutup', 'aktif',
    ];

    protected $casts = [
        'latitude'      => 'decimal:8',
        'longitude'     => 'decimal:8',
        'harga_per_jam' => 'decimal:2',
        'total_slot'    => 'integer',
        'aktif'         => 'boolean',
        'dibuat_pada'   => 'datetime',
        'diperbarui_pada' => 'datetime',
    ];

    // Relasi
    public function slotParkir(): HasMany
    {
        return $this->hasMany(SlotParkir::class, 'lokasi_parkir_id');
    }

    // Helper: hitung slot tersedia
    public function slotTersedia(): int
    {
        return $this->slotParkir()->where('status', 'tersedia')->count();
    }
}
