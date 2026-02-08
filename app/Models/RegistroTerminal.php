<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function extras()
    {
        return $this->hasOne(Servicio::class);
    }
}
