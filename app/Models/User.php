<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nombre_completo',
        'dni',
        'telefono',
        'email',
        'password',
        'plain_password',
        'role',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed', // opcional si usas Laravel 10 hash casting; lo dejo fuera para evitar conflictos
    ];

    protected $attributes = [
        'estado' => 'activo',
    ];



    public function calificacionesRealizadas()
    {
        return $this->hasMany(CalificacionChofer::class, 'usuario_id');
    }

    public function calificacionesRecibidas()
    {
        return $this->hasMany(CalificacionChofer::class, 'chofer_id');
    }
    public function servicios_extras()
    {
        return $this->hasMany(ServiciosExtra::class);
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);

    }
}


