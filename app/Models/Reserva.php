<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'viaje_id',
        'asiento_id',
        'codigo_reserva',
        'fecha_reserva',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function viaje()
    {
        return $this->belongsTo(Viaje::class);
    }

    public function asiento()
    {
        return $this->belongsTo(Asiento::class);
    }
}
