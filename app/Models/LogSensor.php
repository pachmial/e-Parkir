<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogSensor extends Model
{
    protected $table      = 'log_sensor';
    protected $keyType    = 'string';
    public    $incrementing = false;
    const     CREATED_AT  = 'dicatat_pada';
    const     UPDATED_AT  = null; // tidak ada kolom updated_at

    protected $fillable = [
        'id', 'slot_id', 'id_sensor', 'status', 'jarak_cm',
    ];

    protected $casts = [
        'jarak_cm'    => 'decimal:2',
        'dicatat_pada' => 'datetime',
    ];

    // Relasi
    public function slotParkir(): BelongsTo
    {
        return $this->belongsTo(SlotParkir::class, 'slot_id');
    }
}
