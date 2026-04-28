<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TokenRefresh extends Model
{
    protected $table      = 'token_refresh';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const     CREATED_AT  = 'dibuat_pada';
    const     UPDATED_AT  = null; // tidak ada kolom updated_at

    protected $fillable = [
        'id', 'pengguna_id', 'token', 'kedaluwarsa_pada', 'dicabut',
    ];

    protected $casts = [
        'dicabut'          => 'boolean',
        'kedaluwarsa_pada' => 'datetime',
        'dibuat_pada'      => 'datetime',
    ];

    // Relasi
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    // Helper: cek apakah token masih valid
    public function isValid(): bool
    {
        return !$this->dicabut && $this->kedaluwarsa_pada->isFuture();
    }
}
