<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RegistroRenta extends Model
{
    use HasFactory;

    // Asegúrate de definir la tabla si no sigue la convención de nombres de Laravel (por ejemplo, 'registro_renta')
    // protected $table = 'registro_renta';

    protected $fillable = [
        'nombre_completo',
        'usuario_id',
        'tipo_evento',
        'destino',
        'punto_partida',
        'fecha_inicio',
        'fecha_fin',
        'num_pasajeros_confirmados',
        'num_pasajeros_estimados',
        'tarifa',
        'descuento',
        'total_tarifa',
        'codigo_renta',
        'estado',
        'anticipo',
        'hora_salida',
        'hora_retorno',
        'penalizacion',
    ];

    /**
     * Accesor para calcular el número de días del viaje.
     * Acceso en la vista con: $renta->dias_de_viaje
     *
     * @return int
     */
    public function getDiasDeViajeAttribute(): int
    {
        // Si las fechas no están definidas, devuelve 0 o 1
        if (!$this->fecha_inicio || !$this->fecha_fin) {
            return 1;
        }

        try {
            $fechaInicio = Carbon::parse($this->fecha_inicio);
            $fechaFin = Carbon::parse($this->fecha_fin);

            // Se usa diffInDays() y se suma 1 para incluir el día de inicio y fin.
            return $fechaFin->diffInDays($fechaInicio) + 1;

        } catch (\Exception $e) {
            // En caso de error de parseo, devuelve 1 día
            return 1;
        }
    }

    /**
     * Accesor para calcular el Monto Pendiente de Pago.
     * Este es el valor más útil para mostrar como "Total a Pagar" en el listado.
     * Fórmula: (Total Tarifa + Penalización) - Anticipo.
     * Acceso en la vista con: $renta->monto_pendiente
     *
     * @return float
     */
    public function getMontoPendienteAttribute(): float
    {
        $totalTarifa = $this->total_tarifa ?? 0.00;
        $anticipo = $this->anticipo ?? 0.00;
        $penalizacion = $this->penalizacion ?? 0.00;

        // Suma la penalización (si existe) y resta el anticipo ya pagado.
        return ($totalTarifa + $penalizacion) - $anticipo;
    }

    // Relación con la tabla de Usuarios
    public function usuarios()
    {
        return $this->belongsTo(Usuario::class);
    }
}
