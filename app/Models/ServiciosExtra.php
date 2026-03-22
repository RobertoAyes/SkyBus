<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiciosExtra extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si no sigue la convención)
    protected $table = 'servicios_extras';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'reserva_id',
        'user_id',
        'fecha',
    ];

    /**
     * Relación con la reserva
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    /**
     * Relación con el usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación muchos a muchos con los extras
     */
    public function extras()
    {
        return $this->belongsToMany(
            Extra::class,              // Modelo relacionado
            'extra_servicios_extra',   // Tabla pivote
            'servicios_extra_id',      // FK hacia este modelo
            'extra_id'                 // FK hacia Extra
        )->withTimestamps();
    }
}
