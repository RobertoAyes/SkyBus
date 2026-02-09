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

    /**
     * Vista principal (buscador y reservas)
     */
    public function create()
    {
        $ciudades = Ciudad::all();
        return view('interfaces.principal', [
            'ciudades' => $ciudades,
            'viajes' => collect(),
            'asientos' => collect(),
            'reserva' => null,
            'qrCode' => null,
            'busquedaRealizada' => false, // Indica que aún no se buscó
        ]);
    }

    /**
     * Buscar viajes (misma vista)
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'ciudad_origen_id' => 'required|exists:ciudades,id',
            'ciudad_destino_id' => 'required|exists:ciudades,id|different:ciudad_origen_id',
            'fecha' => 'required|date',
        ]);

        $ciudades = Ciudad::all();

        $viajes = Viaje::with([
            'origen',
            'destino',
            'asientos' => fn($q) => $q->where('disponible', true)
        ])
            ->where('ciudad_origen_id', $request->ciudad_origen_id)
            ->where('ciudad_destino_id', $request->ciudad_destino_id)
            ->whereDate('fecha_hora_salida', $request->fecha)
            ->where('fecha_hora_salida', '>', now())
            ->get();

        return view('interfaces.principal', [
            'ciudades' => $ciudades,
            'viajes' => $viajes,
            'asientos' => collect(),
            'reserva' => null,
            'qrCode' => null,
            'busquedaRealizada' => true, // Solo ahora se muestra la tabla o mensaje
        ]);
    }

    /**
     * Mostrar asientos de un viaje
     */
    public function asientos($viaje_id)
    {
        $viaje = Viaje::with('origen', 'destino')->findOrFail($viaje_id);
        $asientos = Asiento::where('viaje_id', $viaje_id)->where('disponible', true)->get();
        $ciudades = Ciudad::all();

        return view('interfaces.principal', [
            'ciudades' => $ciudades,
            'viajes' => collect(),
            'viaje' => $viaje,
            'asientos' => $asientos,
            'reserva' => null,
            'qrCode' => null,
            'busquedaRealizada' => false,
        ]);
    }

    /**
     * Guardar reserva
     */
    public function store(Request $request)
    {
        $request->validate([
            'viaje_id' => 'required|exists:viajes,id',
            'asiento_id' => 'required|exists:asientos,id',
        ]);

        $asiento = Asiento::findOrFail($request->asiento_id);

        if (!$asiento->disponible) {
            return redirect()->back()->with('error', 'El asiento ya fue reservado.');
        }

        $codigo = strtoupper(uniqid('SKY-'));

        $reserva = Reserva::create([
            'user_id' => Auth::id(),
            'viaje_id' => $request->viaje_id,
            'asiento_id' => $request->asiento_id,
            'codigo_reserva' => $codigo,
            'fecha_reserva' => now(),
            'estado' => 'confirmada',
        ]);

        $asiento->update([
            'disponible' => false,
            'reserva_id' => $reserva->id,
        ]);

        $qrCode = DNS2D::getBarcodeSVG($codigo, 'QRCODE', 8, 8);
        $ciudades = Ciudad::all();

        return view('interfaces.principal', [
            'ciudades' => $ciudades,
            'viajes' => $viajes,
            'asientos' => collect(),
            'reserva' => null,
            'qrCode' => null,
            'busquedaRealizada' => true,
        ]);

    }
}
