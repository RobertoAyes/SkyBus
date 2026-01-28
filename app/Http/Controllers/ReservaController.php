<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ciudad;
use App\Models\Viaje;
use App\Models\Asiento;
use App\Models\Reserva;
use DNS2D;

class ReservaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar formulario de búsqueda
    public function create()
    {
        $ciudades = Ciudad::all();
        return view('cliente.reserva.create', compact('ciudades'));
    }


    // Buscar viajes disponibles
    public function buscar(Request $request)
    {
        $request->validate([
            'ciudad_origen_id'  => 'required|exists:ciudades,id',
            'ciudad_destino_id' => 'required|exists:ciudades,id|different:ciudad_origen_id',
        ]);

        $viajes = Viaje::where('ciudad_origen_id', $request->ciudad_origen_id)
            ->where('ciudad_destino_id', $request->ciudad_destino_id)
            ->where('fecha_hora_salida', '>', now())
            ->withCount(['asientos' => fn($q) => $q->where('disponible', true)])
            ->having('asientos_count', '>', 0)
            ->get();

        if ($viajes->isEmpty()) {
            return redirect()->back()->with('error', 'No hay viajes disponibles entre estas ciudades.');
        }

        return view('cliente.reserva.seleccionar', compact('viajes'));
    }

    // Mostrar asientos para un viaje
    public function seleccionarAsiento($viaje_id)
    {
        $viaje = Viaje::findOrFail($viaje_id);
        $asientos = $viaje->asientos()->where('disponible', true)->get();

        return view('cliente.reserva.asientos', compact('viaje', 'asientos'));
    }

    // Procesar reserva
    public function store(Request $request)
    {
        $request->validate([
            'viaje_id'   => 'required|exists:viajes,id',
            'asiento_id' => 'required|exists:asientos,id',
        ]);

        $asiento = Asiento::findOrFail($request->asiento_id);
        if (!$asiento->disponible) {
            return redirect()->back()->with('error', 'Asiento no disponible.');
        }

        $codigo = uniqid('RES_');

        $reserva = Reserva::create([
            'user_id'        => Auth::id(),          // <-- CAMBIO
            'viaje_id'       => $request->viaje_id,
            'asiento_id'     => $request->asiento_id,
            'codigo_reserva' => $codigo,
            'fecha_reserva'  => now(),
            'estado'         => 'pendiente',
        ]);

        $asiento->update(['disponible' => false, 'reserva_id' => $reserva->id]);

        $qrCode = DNS2D::getBarcodeSVG($codigo, 'QRCODE');

        return view('cliente.reserva.confirmacion', compact('reserva', 'qrCode'));
    }


    public function update(Request $request, Reserva $reserva)
    {
        // Validación básica
        $request->validate([
            'ciudad_origen_id' => 'required|exists:ciudades,id',
            'ciudad_destino_id' => 'required|exists:ciudades,id',
            'fecha_salida' => 'required|date',
            'hora_salida' => 'required',
            'asiento_id' => 'required|exists:asientos,id',
        ]);

        // Actualizar datos del viaje
        $reserva->viaje->update([
            'ciudad_origen_id' => $request->ciudad_origen_id,
            'ciudad_destino_id' => $request->ciudad_destino_id,
            'fecha_hora_salida' => $request->fecha_salida . ' ' . $request->hora_salida,
        ]);

        // Actualizar asiento
        $reserva->update([
            'asiento_id' => $request->asiento_id,
        ]);

        return redirect()->back()->with('success', '¡Reserva actualizada correctamente!');
    }


}
