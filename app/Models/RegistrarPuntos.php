<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrarPuntos extends Model
{
    use HasFactory;

    protected $table = 'registrar_puntos';

    protected $fillable = [
        'reserva_id',
        'usuario_id',
        'puntos',
    ];

    public function reserva()
    {
        return $this->belongsTo(\App\Models\Reserva::class, 'reserva_id');
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }
}

