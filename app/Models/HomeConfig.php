<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeConfig extends Model
{
    protected $fillable = [
        'titulo',
        'subtitulo',
        'texto_boton',
        'link_boton',
        'imagen_banner',
        'info_boxes',   // JSON
        'beneficios',   // JSON
        'prepare_viaje' // JSON
    ];

    protected $casts = [
        'info_boxes' => 'array',
        'beneficios' => 'array',
        'prepare_viaje' => 'array',
    ];
}
