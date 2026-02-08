<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    /** @use HasFactory<\Database\Factories\ExtraFactory> */
    use HasFactory;

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }
}
