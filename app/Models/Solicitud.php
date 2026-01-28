<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'user_id',
        'nombre',
        'dni',
        'motivo',
        'fecha_entrega',
        'estado',
        'fecha_procesamiento'
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
        'fecha_procesamiento' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
