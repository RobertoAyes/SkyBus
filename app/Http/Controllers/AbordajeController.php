<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Abordaje; // Modelo Abordaje
use App\Models\User; // Asegúrate de tener el modelo User si no lo tienes importado
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Necesario para obtener el ID del empleado que confirma


class AbordajeController extends Controller
{
    /**
     * Muestra la interfaz del escáner QR.
     * Corresponde a la ruta: GET /abordajes/escanear
     */
    public function mostrarEscaner()
    {
        return view('abordajes.escaner');
    }

    /**
     * Valida el código QR (que es el ID de Reserva).
     * Corresponde a la ruta: POST /abordajes/validar
     */
    public function validarCodigoQR(Request $request)
    {
        $request->validate(['codigo_qr' => 'required|string']);

        $codigo = $request->input('codigo_qr');

        // Buscar la reserva por ID y cargar el pasajero
        $reserva = Reserva::with('pasajero')->find($codigo);

        if (!$reserva) {
            return response()->json(['success' => false, 'message' => 'Reserva no encontrada o código QR inválido.'], 404);
        }

        // Verificar si ya existe un registro de Abordaje para esta Reserva
        $yaAbordado = Abordaje::where('reserva_id', $reserva->id)->exists();

        if ($yaAbordado) {
            return response()->json(['success' => false, 'message' => 'El boleto ya ha sido abordado previamente.'], 400);
        }

        // Si la validación es exitosa, devuelve los datos de la reserva
        return response()->json([
            'success' => true,
            'message' => 'Validación exitosa. Listo para confirmar abordajes.',
            'reserva' => $reserva
        ]);
    }

    /**
     * Confirma el abordajes creando un nuevo registro en el modelo Abordaje.
     * Corresponde a la ruta: POST /abordajes/confirmar
     */
    public function confirmarAbordaje(Request $request)
    {
        // El empleado que confirma debe estar autenticado
        $empleadoId = Auth::id();

        if (!$empleadoId) {
            return response()->json(['success' => false, 'message' => 'Debe iniciar sesión para confirmar un abordajes.'], 401);
        }

        // Validar que el campo 'reserva_id' esté presente
        $request->validate(['reserva_id' => 'required|integer|exists:reservas,id']);

        $reservaId = $request->input('reserva_id');

        try {
            // 1. Verificar si ya existe un registro de Abordaje
            if (Abordaje::where('reserva_id', $reservaId)->exists()) {
                return response()->json(['success' => false, 'message' => 'Esta reserva ya fue abordada.'], 400);
            }

            // 2. Obtener la Reserva para el usuario_id (pasajero_id)
            $reserva = Reserva::findOrFail($reservaId);

            // 3. Crear el registro de Abordaje
            Abordaje::create([
                'reserva_id' => $reservaId,
                'empleado_id' => $empleadoId,
                'usuario_id' => $reserva->pasajero_id, // Usamos el pasajero_id de la reserva como usuario_id del abordajes
                'fecha_hora_abordaje' => now(),
                'estado' => 'confirmado',
            ]);

            // 4. Actualizar el estado de la Reserva (opcional, pero buena práctica)
            $reserva->update(['estado' => 'abordado']);

            return response()->json(['success' => true, 'message' => 'Abordaje confirmado con éxito.'], 200);

        } catch (\Exception $e) {
            Log::error("Error al crear registro de abordajes para Reserva ID {$reservaId}: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error interno al confirmar el abordajes.'], 500);
        }
    }

    /**
     * Muestra el historial de abordajes.
     * Corresponde a la ruta: GET /abordajes/historial
     */
    public function historial(Request $request)
    {
        // Cargamos:
        // - reserva: La reserva asociada.
        // - reserva.viaje: El viaje asociado a esa reserva.
        // - usuario: El pasajero que abordó (relación usuario del modelo Abordaje).
        // - empleado: El empleado que confirmó el abordajes (relación empleado del modelo Abordaje).
        $abordajes = Abordaje::with(['reserva.viaje', 'usuario', 'empleado'])
            ->orderBy('fecha_hora_abordaje', 'desc')
            ->paginate(10);

        return view('abordajes.historial', compact('abordajes'));
    }
}

