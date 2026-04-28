<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table      = 'notifikasi';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const     CREATED_AT  = 'dibuat_pada';
    const     UPDATED_AT  = null; // tidak ada kolom updated_at

    protected $fillable = [
        'id', 'pengguna_id', 'judul', 'pesan', 'jenis', 'sudah_dibaca',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
        'dibuat_pada'  => 'datetime',
    ];

    // Relasi
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
