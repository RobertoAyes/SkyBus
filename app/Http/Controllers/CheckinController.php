<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Viaje;
use App\Models\Asiento;

class CheckinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // ... otros métodos que ya tienes ...

    public function validarCodigo(Request $request)
    {
        try {
            $codigo = trim($request->input('codigo_qr'));

            if (!$codigo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código QR no proporcionado',
                    'tipo_alerta' => 'error'
                ]);
            }

            $codigoLimpio = preg_replace('/[^a-zA-Z0-9_]/', '', $codigo);

            $reserva = Reserva::with(['user', 'viaje', 'asiento'])
                ->where('codigo_reserva', $codigoLimpio)
                ->first();

            if (!$reserva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reserva no encontrada o código QR inválido.',
                    'tipo_alerta' => 'error'
                ]);
            }

            if ($reserva->estado === 'confirmada') {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta reserva ya realizó el check-in anteriormente.',
                    'tipo_alerta' => 'warning'
                ]);
            }

            $viaje = $reserva->viaje;
            $ciudadOrigen = \App\Models\Ciudad::find($viaje->ciudad_origen_id);
            $ciudadDestino = \App\Models\Ciudad::find($viaje->ciudad_destino_id);

            $datos = [
                'reserva_id' => $reserva->id,
                'codigo_qr' => $reserva->codigo_reserva,
                'pasajero' => [
                    'nombre_completo' => $reserva->user->name ?? 'N/A',
                    'dni' => $reserva->user->dni ?? 'N/A',
                    'email' => $reserva->user->email ?? 'N/A',
                    'telefono' => $reserva->user->telefono ?? 'N/A'
                ],
                'viaje' => [
                    'ruta' => ($ciudadOrigen ? $ciudadOrigen->nombre : 'N/A') . ' - ' . ($ciudadDestino ? $ciudadDestino->nombre : 'N/A'),
                    'origen' => $ciudadOrigen ? $ciudadOrigen->nombre : 'N/A',
                    'destino' => $ciudadDestino ? $ciudadDestino->nombre : 'N/A',
                    'fecha_salida' => $viaje->fecha_hora_salida ?? 'N/A',
                    'asiento' => $reserva->asiento->numero_asiento ?? 'N/A'
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Datos de reserva verificados correctamente',
                'tipo_alerta' => 'success',
                'datos' => $datos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'tipo_alerta' => 'error'
            ]);
        }
    }
    public function confirmarAbordaje(Request $request)
    {
        try {
            $reservaId = $request->input('reserva_id');

            $reserva = Reserva::find($reservaId);

            if (!$reserva) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reserva no encontrada',
                    'tipo_alerta' => 'error'
                ]);
            }

            $reserva->estado = 'confirmada';
            $reserva->save();

            return response()->json([
                'success' => true,
                'message' => '¡Abordaje confirmado exitosamente!',
                'tipo_alerta' => 'success'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'tipo_alerta' => 'error'
            ]);
        }
    }

    // AGREGAR ESTE MÉTODO
    public function historial()
    {
        // Obtener todas las reservas confirmadas
        $reservas = Reserva::with(['user', 'viaje'])
            ->where('estado', 'confirmada')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('abordajes.historial', compact('reservas'));
    }
}
