<?php

namespace App\Models;

// Este archivo representa la tabla "incidentes" de la base de datos.
// Es decir, cada registro de la tabla incidentes se va a manejar desde aquí.

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

        // Aquí se guardará el id del empleado (conductor).
        // Por ahora puede quedar vacío, luego lo vamos a usar mejor.
        'empleado_id',

        // Aquí se guarda el nombre del conductor que reporta el incidente.
        'conductor_nombre',

        // Aquí se guarda el número del bus (por ejemplo: 101, 205, etc).
        'bus_numero',

        // Aquí se guarda la ruta del viaje
        // (por ejemplo: Tegucigalpa - Comayagua).
        'ruta',

        // Aquí se guarda el tipo de incidente
        // (Retraso, Avería, Inconveniente, Otro).
        'tipo_incidente',

        // Aquí se guarda la explicación de lo que pasó.
        'descripcion',

        // Aquí se guarda la fecha y hora del incidente.
        // Esta fecha se pone sola desde la base de datos.
        'fecha_hora',
    ];
}
