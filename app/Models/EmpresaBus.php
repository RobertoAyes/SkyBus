<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaBus extends Model
{
    use HasFactory;

    protected $table = 'empresa_buses';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'propietario',
        'estado_validacion',
        'validado_por',
        'fecha_validacion',
    ];
}

