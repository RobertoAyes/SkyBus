<?php

namespace App\Models;

// Aqui cada registro de la tabla incidentes se va a manejar desde aquí.

use Illuminate\Database\Eloquent\Model;

class Incidente extends Model
{
    // Aquí le digo a Laravel que este modelo trabaja con la tabla
    // que se llama exactamente "incidentes" en la base de datos.
    protected $table = 'incidentes';

    // Aquí pongo todos los campos que sí se pueden guardar cuando
    // yo registre un incidente desde el formulario.
    //
    // Si un campo no está aquí, Laravel no lo deja guardar.
    protected $fillable = [

        'empleado_id',

        'conductor_nombre',

        'bus_numero',

        'ruta',

        'tipo_incidente',

        'descripcion',

        // Campos nuevos de HU73
        'ubicacion',

        'nivel_gravedad',

        'estado',

        // Esta fecha se pone sola desde la base de datos.
        'fecha_hora',
        'acciones_tomadas',
    ];
}
