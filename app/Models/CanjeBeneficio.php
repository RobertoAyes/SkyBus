<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanjeBeneficio extends Model
{
    use HasFactory;

    protected $table = 'canje_beneficios';

    protected $fillable = [
        'nombre',
        'puntos_requeridos',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
