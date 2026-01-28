<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $table = 'buses';

    protected $fillable = [
        'numero_bus',
        'placa',
        'modelo',
        'capacidad_asientos',
        'estado'
    ];

    // Accessor para usar 'capacidad' en lugar de 'capacidad_asientos'
    public function getCapacidadAttribute()
    {
        return $this->capacidad_asientos;
        return $this->numero_bus;
    }

    // Relación con documentos
    public function documentos()
    {
        return $this->hasMany(DocumentoBus::class, 'bus_id');
    }
}
