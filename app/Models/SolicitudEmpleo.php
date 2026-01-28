<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudEmpleo extends Model
{
    protected $fillable = [
        'user_id',
        'nombre_completo',
        'contacto',
        'puesto_deseado',
        'experiencia_laboral',
        'cv',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
