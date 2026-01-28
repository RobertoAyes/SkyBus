<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'numero_registro',
        'correo',
        'telefono',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

    public function scopeActivo($query)
    {
        return $query->where('estado', true);
    }

    public function scopeInactivo($query)
    {
        return $query->where('estado', false);
    }

    public function scopeBuscar($query, $search)
    {
        return $query->where('nombre', 'like', "%{$search}%")
            ->orWhere('numero_registro', 'like', "%{$search}%");
    }
}
