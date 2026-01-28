<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionChofer extends Model
{
    protected $table = 'calificaciones_chofer';

    protected $fillable = [
        'usuario_id',
        'calificacion',
        'comentario',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}

