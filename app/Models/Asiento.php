<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    use HasFactory;

    protected $fillable = ['viaje_id', 'numero_asiento', 'disponible', 'reserva_id'];

    public function viaje()
    {
        return $this->belongsTo(Viaje::class);
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }
}
