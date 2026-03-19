<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Ruta;
use App\Models\ParadaItinerario;

class ItinerarioChofer extends Model
{
    use HasFactory;

    protected $table = 'itinerarios_chofer';
    protected $fillable = [
        'chofer_id',
        'ruta_id',
        'fecha',
        'hora_salida',
        'hora_llegada',
        'estado_viaje',

    ];

    protected $casts = [
        'fecha'       => 'datetime',
        'hora_salida' => 'datetime',
        'hora_llegada' => 'datetime',
    ];

    // Relación con chofer (usuario con rol Chofer)
    public function chofer()
    {
        return $this->belongsTo(User::class, 'chofer_id');
    }

    // Relación con ruta
    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'ruta_id');
    }

    public function paradas()
    {
        return $this->hasMany(ParadaItinerario::class, 'itinerario_chofer_id');
    }
    public function getEstadoCalculadoAttribute()
    {
        if ($this->hora_salida && $this->hora_llegada) {
            return 'Finalizado';
        }

        if ($this->hora_salida && !$this->hora_llegada) {
            return 'En ruta';
        }

        if (!$this->hora_salida && now() > $this->fecha) {
            return 'Atrasado';
        }

        return 'Pendiente';
    }
}
