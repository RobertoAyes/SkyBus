<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Viaje;
use App\Models\Asiento;
use App\Models\Factura;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'user_id',
        'viaje_id',
        'asiento_id',
        'codigo_reserva',
        'fecha_reserva',
        'estado',
        'pagado'
    ];

    /* =========================
       USUARIO
    ========================= */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* =========================
       VIAJE
    ========================= */
    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'viaje_id');
    }

    /* =========================
       ASIENTO
    ========================= */
    public function asiento()
    {
        return $this->belongsTo(Asiento::class, 'asiento_id');
    }

    /* =========================
       FACTURA
    ========================= */
    public function factura()
    {
        return $this->hasOne(Factura::class, 'reserva_id');
    }
}
