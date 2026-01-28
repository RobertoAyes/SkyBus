<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'cargo',
        'fecha_ingreso',
        'rol',
        'estado',
        'foto',
        'email',               // incluido para crear usuario vinculado
        'password_initial',    // incluido para guardar contraseña temporal
        'motivo_baja',         // para desactivaciones
        'fecha_desactivacion', // para registrar fecha de baja
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',           // útil para formatear fechas
        'fecha_desactivacion' => 'datetime', // fecha y hora de desactivación
    ];

    public $timestamps = true; // mantener created_at y updated_at
}
