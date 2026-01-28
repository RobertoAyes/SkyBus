<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'dni',
        'email',
        'telefono',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con la tabla users (si existe)
     */
    public function user()
    {
        return $this->hasOne(User::class, 'email', 'email');
    }

    /**
     * Obtener el estado del usuario desde la tabla users
     */
    public function getEstadoAttribute()
    {
        return $this->user ? $this->user->estado : 'activo';
    }

    /**
     * Obtener el rol del usuario desde la tabla users
     */
    public function getRolAttribute()
    {
        return $this->user ? $this->user->role : 'cliente';
    }
}

