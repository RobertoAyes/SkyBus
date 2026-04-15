<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Viaje;
use App\Models\Reserva;

class Asiento extends Model
{
    protected $table = 'asientos';

    protected $fillable = [
        'viaje_id',
        'numero',
        'ocupado'
    ];

    /* =========================
       RELACIÓN: VIAJE
    ========================= */
    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'viaje_id');
    }

    /* =========================
       RELACIÓN: RESERVA
    ========================= */
    public function reserva()
    {
        return $this->hasOne(Reserva::class, 'asiento_id');
    }

    /* =========================
       SCOPE: DISPONIBLES
    ========================= */
    public function scopeDisponibles($query)
    {
        return $query->where('ocupado', 0);
    }

    /* =========================
       SCOPE: OCUPADOS
    ========================= */
    public function scopeOcupados($query)
    {
        return $query->where('ocupado', 1);
    }
}
