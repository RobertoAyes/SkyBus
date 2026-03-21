<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id', // ❌ Cambiado de user_id a usuario_id
        'viaje_id',
        'asiento_id',
        'codigo_reserva',
        'fecha_reserva',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id'); // ❌ usa usuario_id
    }

    public function viaje()
    {
        return $this->belongsTo(Viaje::class);
    }

    public function asiento()
    {
        return $this->belongsTo(Asiento::class);
    }

    public function servicios_extras()
    {
        return $this->hasOne(ServiciosExtra::class);
    }
}
