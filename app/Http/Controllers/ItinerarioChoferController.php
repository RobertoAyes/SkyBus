<?php

namespace App\Http\Controllers;

use App\Models\ItinerarioChofer;
use App\Models\User;
use App\Models\Ruta;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ParadaItinerario;

class ItinerarioChoferController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.active']);
    }

    public function index(Request $request)
    {
        $query = ItinerarioChofer::with(['chofer', 'ruta', 'paradas']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {
                $q->whereHas('chofer', function ($q2) use ($buscar) {
                    $q2->where('name', 'like', "%$buscar%");
                })
                    ->orWhereHas('ruta', function ($q2) use ($buscar) {
                        $q2->where('origen', 'like', "%$buscar%")
                            ->orWhere('destino', 'like', "%$buscar%");
                    });
            });
        }

        if ($request->filled('chofer')) {
            $query->where('chofer_id', $request->chofer);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $itinerarios = $query->paginate($request->get('per_page', 10))
            ->appends($request->all());

        $choferes = User::where('role', 'Chofer')->get();
        $rutas = Ruta::where('estado', true)->get();

        return view('itinerarioChofer.index', compact('itinerarios', 'choferes', 'rutas'));
    }

    public function create()
    {
        $choferes = User::where('role', 'Chofer')->get();
        $rutas = Ruta::where('estado', true)->get();

        return view('itinerarioChofer.create', compact('choferes', 'rutas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chofer_id' => 'required|exists:users,id',
            'ruta_id'   => 'required|exists:rutas,id',
            'fecha'     => 'required|date',
        ]);

        $fecha = Carbon::parse($request->fecha)->format('Y-m-d H:i:s');

        $existe = ItinerarioChofer::where('chofer_id', $request->chofer_id)
            ->where('ruta_id', $request->ruta_id)
            ->where('fecha', $fecha)
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'chofer_id' => 'Este chofer ya tiene asignada esta ruta en la misma fecha y hora.'
                ]);
        }

        $itinerario = ItinerarioChofer::create([
            'chofer_id' => $request->chofer_id,
            'ruta_id'   => $request->ruta_id,
            'fecha'     => $fecha,
        ]);

        if ($request->has('paradas')) {
            foreach ($request->paradas['lugar'] as $index => $lugar) {
                if (!empty($lugar) && !empty($request->paradas['tiempo'][$index])) {
                    ParadaItinerario::create([
                        'itinerario_chofer_id' => $itinerario->id,
                        'lugar_parada' => $lugar,
                        'tiempo_parada' => $request->paradas['tiempo'][$index],
                    ]);
                }
            }
        }

        return redirect()->route('itinerarioChofer.index')
            ->with('success', 'Itinerario asignado correctamente con parada(s).');
    }

    public function edit(ItinerarioChofer $itinerarioChofer)
    {
        $choferes = User::where('role', 'Chofer')->get();
        $rutas = Ruta::where('estado', true)->get();

        $itinerarioChofer->load('paradas');

        return view('itinerarioChofer.edit', compact(
            'itinerarioChofer',
            'choferes',
            'rutas'
        ));
    }

    public function update(Request $request, ItinerarioChofer $itinerarioChofer)
    {
        $request->validate([
            'chofer_id' => 'required|exists:users,id',
            'ruta_id'   => 'required|exists:rutas,id',
            'fecha'     => 'required|date',
        ]);

        $fecha = Carbon::parse($request->fecha)->format('Y-m-d H:i:s');

        $itinerarioChofer->update([
            'chofer_id' => $request->chofer_id,
            'ruta_id'   => $request->ruta_id,
            'fecha'     => $fecha
        ]);

        ParadaItinerario::where('itinerario_chofer_id', $itinerarioChofer->id)->delete();

        if ($request->has('paradas')) {
            foreach ($request->paradas['lugar'] as $index => $lugar) {
                if (!empty($lugar) && !empty($request->paradas['tiempo'][$index])) {
                    ParadaItinerario::create([
                        'itinerario_chofer_id' => $itinerarioChofer->id,
                        'lugar_parada' => $lugar,
                        'tiempo_parada' => $request->paradas['tiempo'][$index]
                    ]);
                }
            }
        }

        return redirect()->route('itinerarioChofer.index')
            ->with('success', 'Itinerario actualizado correctamente');
    }

    public function destroy(ItinerarioChofer $itinerarioChofer)
    {
        $itinerarioChofer->delete();

        return redirect()->route('itinerarioChofer.index')
            ->with('success', 'Itinerario eliminado correctamente.');
    }

    public function miItinerario()
    {
        $choferId = auth()->id();

        $itinerarios = ItinerarioChofer::with(['ruta', 'paradas'])
            ->where('chofer_id', $choferId)
            ->orderBy('fecha', 'asc')
            ->get();

        return view('chofer.itinerario', compact('itinerarios'));
    }
}
