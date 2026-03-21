<?php

namespace App\Http\Controllers;

use App\Models\ItinerarioChofer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChoferConfirmacionController extends Controller
{
    public function __construct()
    {

        $this->middleware(['auth', 'user.active']);
    }

    public function index(Request $request)
    {
        $query = ItinerarioChofer::with('ruta')
            ->where('chofer_id', auth()->id());

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('ruta', function ($q) use ($buscar) {
                $q->where('origen', 'like', "%$buscar%")
                    ->orWhere('destino', 'like', "%$buscar%")
                    ->orWhereRaw("CONCAT(origen, ' ', destino) like ?", ["%$buscar%"])
                    ->orWhereRaw("CONCAT(destino, ' ', origen) like ?", ["%$buscar%"]);
            });
        }
        if ($request->filled('estado_viaje')) {
            $query->where('estado_viaje', $request->estado_viaje);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        match ($request->orden) {
            'fecha_asc'   => $query->orderBy('fecha', 'asc'),
            'fecha_desc'  => $query->orderBy('fecha', 'desc'),
            'salida_asc'  => $query->orderBy('hora_salida', 'asc'),
            'salida_desc' => $query->orderBy('hora_salida', 'desc'),
            default       => $query->orderBy('fecha', 'desc')->orderBy('hora_salida', 'desc'),
        };

        $itinerarios = $query->paginate(5)->withQueryString();

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

