<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudSoporte extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_soporte';

    protected $fillable = [
        'chofer_id',
        'titulo',
        'descripcion',
        'estado',
    ];

    public function chofer()
    {
        return $this->belongsTo(User::class, 'chofer_id');
    }
}
