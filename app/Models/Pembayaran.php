<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table      = 'pembayaran';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const     CREATED_AT  = 'dibuat_pada';
    const     UPDATED_AT  = 'diperbarui_pada';

    protected $fillable = [
        'id', 'pemesanan_id', 'jumlah', 'metode',
        'status', 'referensi_pembayaran', 'dibayar_pada',
    ];

    protected $casts = [
        'jumlah'         => 'decimal:2',
        'dibayar_pada'   => 'datetime',
        'dibuat_pada'    => 'datetime',
        'diperbarui_pada' => 'datetime',
    ];

    // Relasi
    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    // Helper: cek apakah pembayaran sudah berhasil
    public function isBerhasil(): bool
    {
        return $this->status === 'berhasil';
    }
}
