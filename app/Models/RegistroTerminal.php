<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Servicio;

class RegistroTerminal extends Model
{
    protected $table = 'registro_terminal';

    protected $fillable = [
        'nombre',
        'codigo',
        'direccion',
        'departamento',
        'municipio',
        'telefono',
        'correo',
        'horario_apertura',
        'horario_cierre',
        'descripcion',
        'latitud',    // ✅ Asegúrate que esté
        'longitud',   // ✅ Asegúrate que esté
    ];

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'registro_terminal_id');
    }
}
