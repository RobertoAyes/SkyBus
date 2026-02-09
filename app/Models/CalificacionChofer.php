<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // <-- Esto faltaba
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalificacionChofer extends Model
{
    use HasFactory;

    protected $table = 'calificaciones_chofer';

    protected $fillable = [
        'usuario_id',
        'chofer_id',
        'reserva_id',
        'estrellas',
        'comentario',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function chofer()
    {
        return $this->belongsTo(User::class, 'chofer_id');
    }
}
