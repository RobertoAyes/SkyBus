<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParadaItinerario extends Model
{
    use HasFactory;

    protected $table = 'paradas_itinerario';

    protected $fillable = [
        'itinerario_chofer_id',
        'lugar_parada',
        'tiempo_parada',
    ];

    public function itinerario()
    {
        return $this->belongsTo(ItinerarioChofer::class, 'itinerario_chofer_id');
    }
}
