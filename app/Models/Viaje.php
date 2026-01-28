<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    protected $table = 'viajes';
    use HasFactory;

    protected $fillable = [
        'ciudad_origen_id',
        'ciudad_destino_id',
        'bus_id',
        'fecha_hora_salida',
        'asientos_totales',
    ];

    public function origen()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_origen_id');
    }

    public function destino()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_destino_id');
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function asientos()
    {
        return $this->hasMany(Asiento::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
