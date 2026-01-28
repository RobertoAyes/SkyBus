<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanjeRealizado extends Model
{
    use HasFactory;

    protected $table = 'canjes_realizados';

    protected $fillable = [
        'usuario_id',
        'beneficio_id',
        'puntos_usados',
    ];

    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }

    public function beneficio()
    {
        return $this->belongsTo(CanjeBeneficio::class, 'beneficio_id');
    }
}
