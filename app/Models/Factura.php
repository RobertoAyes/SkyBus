<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = [
        'numero_factura',
        'reserva_id',
        'user_id',
        'fecha_emision',
        'monto_total',
        'subtotal',
        'impuestos',
        'cargos_adicionales',
        'metodo_pago',
        'estado',
        'detalles'
    ];

    protected $casts = [
        'fecha_emision' => 'datetime',
    ];

    // Relación con reserva
    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generar número de factura automático
    public static function generarNumeroFactura()
    {
        $year = date('Y');
        $ultimaFactura = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $numero = $ultimaFactura ? (int)substr($ultimaFactura->numero_factura, -5) + 1 : 1;

        return 'FAC-' . $year . '-' . str_pad($numero, 5, '0', STR_PAD_LEFT);
    }
}
