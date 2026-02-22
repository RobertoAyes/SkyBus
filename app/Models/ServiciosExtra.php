<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiciosExtra extends Model
{
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function extras()
    {
        return $this->belongsToMany(Extra::class);
    }
}
