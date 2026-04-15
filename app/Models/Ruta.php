<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $fillable = [
        'origen',
        'destino',
        'distancia',
        'duracion_estimada',
        'estado'
    ];

    public function viajes()
    {
        return $this->hasMany(Viaje::class, 'ruta_id');
    }
}
