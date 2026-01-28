<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class VisualizacionItinerario extends Model
{
    use HasFactory;

    protected $table = 'visualizaciones_itinerario';

    protected $fillable = [
        'usuario_id',
        'reserva_id',
        'fecha_hora_visualizacion',
        'dispositivo',
        'navegador',
        'ip_address'
    ];

    protected $casts = [
        'fecha_hora_visualizacion' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }
}
