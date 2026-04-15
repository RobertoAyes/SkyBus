<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ruta;
use App\Models\Asiento;
use App\Models\Reserva;

class Viaje extends Model
{
    protected $table = 'viajes';

    protected $fillable = [
        'ruta_id',
        'fecha_hora_salida',
        'fecha_llegada',
        'precio',
        'capacidad',
        'bus_id',
        'asientos_totales'
    ];

    /* =========================
       RELACIÓN: RUTA
    ========================= */
    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'ruta_id');
    }

    /* =========================
       RELACIÓN: ASIENTOS
    ========================= */
    public function asientos()
    {
        return $this->hasMany(Asiento::class, 'viaje_id');
    }

    /* =========================
       RELACIÓN: RESERVAS
    ========================= */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'viaje_id');
    }

    /* =========================
       SCOPES
    ========================= */
    public function scopeFecha($query, $fecha)
    {
        return $query->whereDate('fecha_hora_salida', $fecha);
    }

    public function scopeActivos($query)
    {
        return $query->whereNotNull('fecha_hora_salida');
    }

    /* =========================
       DISPONIBILIDAD
    ========================= */
    public function asientosDisponibles()
    {
        return $this->asientos()
            ->where('ocupado', 0)
            ->count();
    }
}
