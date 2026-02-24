<?php

namespace App\Http\Controllers;

use App\Models\ItinerarioChofer;
use Illuminate\Support\Facades\Auth;

class ChoferConfirmacionController extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth', 'user.active']);
    }

    public function index()
    {
        $itinerarios = ItinerarioChofer::with('ruta')
            ->where('chofer_id', auth()->id())

            ->orderBy('fecha', 'desc')
            ->orderBy('hora_salida', 'desc')
            ->paginate(10);

        return view('conductor.confirmar', compact('itinerarios'));
    }

    public function registrarSalida($id)
    {
        $itinerario = ItinerarioChofer::where('chofer_id', Auth::id())
            ->findOrFail($id);

        if ($itinerario->estado_viaje !== 'Pendiente') {
            return back()->with('error', 'No se puede registrar la salida.');
        }

        $itinerario->hora_salida = now();
        $itinerario->estado_viaje = 'En ruta';
        $itinerario->save();

        return back()->with('success', 'Hora de salida registrada correctamente.');
    }


    public function registrarLlegada($id)
    {
        $itinerario = ItinerarioChofer::where('chofer_id', Auth::id())
            ->findOrFail($id);

        if ($itinerario->estado_viaje !== 'En ruta') {
            return back()->with('error', 'No se puede registrar la llegada.');
        }

        $itinerario->hora_llegada = now();
        $itinerario->estado_viaje = 'Finalizado';
        $itinerario->save();

        return back()->with('success', 'Hora de llegada registrada correctamente.');
    }
}

