<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RegistroTerminal;

class Servicio extends Model
{
    /** @use HasFactory<\Database\Factories\ServicioFactory> */
    use HasFactory;

    public function terminal()
    {
        return $this->belongsTo(RegistroTerminal::class, 'registro_terminal_id');
    }
}
