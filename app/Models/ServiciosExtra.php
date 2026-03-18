<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiciosExtra extends Model//usuario
{
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function extras()
    {
        // Ajusta 'extra_servicio', 'servicio_id', 'extra_id' según tu tabla pivot
        return $this->belongsToMany(Extra::class, 'extra_servicio', 'servicio_id', 'extra_id');
    }

}
