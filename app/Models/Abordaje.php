<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abordaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserva_id',
        'usuario_id',
        'empleado_id',
        'codigo_qr',
        'fecha_hora_abordaje',
        'estado',
        'observaciones'
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function empleado()
    {
        return $this->belongsTo(User::class, 'empleado_id');
    }
}

