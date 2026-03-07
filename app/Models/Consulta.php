<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'user_id',
        'nombre_completo',
        'correo',
        'asunto',
        'mensaje',
        'estado',
        'respuesta_admin',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
