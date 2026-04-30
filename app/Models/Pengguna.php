<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Authenticatable
{
    protected $table      = 'pengguna';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const     CREATED_AT  = 'dibuat_pada';
    const     UPDATED_AT  = 'diperbarui_pada';

    protected $fillable = [
        'id', 'nama', 'email', 'kata_sandi',
        'no_telepon', 'peran', 'foto_profil', 'sudah_verifikasi',
    ];

    protected $hidden = ['kata_sandi'];

    protected $casts = [
        'sudah_verifikasi' => 'boolean',
        'dibuat_pada'      => 'datetime',
        'diperbarui_pada'  => 'datetime',
    ];

    // Laravel butuh ini untuk auth
    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function kendaraan(): HasMany
    {
        return $this->hasMany(Kendaraan::class, 'pengguna_id');
    }

    public function pemesanan(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'pengguna_id');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'pengguna_id');
    }

    public function tokenRefresh(): HasMany
    {
        return $this->hasMany(TokenRefresh::class, 'pengguna_id');
    }
}