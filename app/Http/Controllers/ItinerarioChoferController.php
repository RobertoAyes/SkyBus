<?php

namespace App\Http\Controllers;

use App\Models\ItinerarioChofer;
use App\Models\User;
use App\Models\Ruta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ItinerarioChoferController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.active']);
    }

    public function index()
    {
        $itinerarios = ItinerarioChofer::with(['chofer', 'ruta'])->get();
        return view('itinerarioChofer.index', compact('itinerarios'));
    }

    public function create()
    {
        $choferes = User::where('role', 'Chofer')->get();
        $rutas = Ruta::all();
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

        // Validación: no duplicar chofer + ruta + fecha
        $existe = ItinerarioChofer::where('chofer_id', $request->chofer_id)
            ->where('ruta_id', $request->ruta_id)
            ->where('fecha', $fecha)
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['chofer_id' => 'Este chofer ya tiene asignada esta ruta en la misma fecha y hora.']);
        }

        ItinerarioChofer::create([
            'chofer_id' => $request->chofer_id,
            'ruta_id'   => $request->ruta_id,
            'fecha'     => $fecha,
        ]);

        return redirect()->route('itinerarioChofer.index')
            ->with('success', 'Itinerario asignado correctamente al chofer.');
    }

    public function edit(ItinerarioChofer $itinerarioChofer)
    {
        $choferes = User::where('role', 'Chofer')->get();
        $rutas = Ruta::all();
        return view('itinerarioChofer.edit', compact('itinerarioChofer', 'choferes', 'rutas'));
    }

    public function update(Request $request, ItinerarioChofer $itinerarioChofer)
    {
        $request->validate([
            'chofer_id' => 'required|exists:users,id',
            'ruta_id'   => 'required|exists:rutas,id',
            'fecha'     => 'required|date',
        ]);

        $fecha = Carbon::parse($request->fecha)->format('Y-m-d H:i:s');

        // Validación: evitar duplicado excepto el registro actual
        $existe = ItinerarioChofer::where('chofer_id', $request->chofer_id)
            ->where('ruta_id', $request->ruta_id)
            ->where('fecha', $fecha)
            ->where('id', '!=', $itinerarioChofer->id)
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['chofer_id' => 'Este chofer ya tiene asignada esta ruta en la misma fecha y hora.']);
        }

        $itinerarioChofer->update([
            'chofer_id' => $request->chofer_id,
            'ruta_id'   => $request->ruta_id,
            'fecha'     => $fecha,
        ]);

        return redirect()->route('itinerarioChofer.index')
            ->with('success', 'Itinerario actualizado correctamente.');
    }

    public function destroy(ItinerarioChofer $itinerarioChofer)
    {
        $itinerarioChofer->delete();
        return redirect()->route('itinerarioChofer.index')
            ->with('success', 'Itinerario eliminado correctamente.');
    }
}
