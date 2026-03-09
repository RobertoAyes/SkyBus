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

    public function index()
    {
        $itinerarios = ItinerarioChofer::with(['chofer', 'ruta'])->get();
        return view('itinerarioChofer.index', compact('itinerarios'));
    }

    public function create()
    {
        $choferes = User::where('role', 'Chofer')->get();
        $rutas = Ruta::where('estado', true)->get(); // solo rutas activas
        return view('itinerarioChofer.create', compact('choferes', 'rutas'));
    }

        public function store(Request $request)
    {
        //Validación
        $request->validate([
            'chofer_id' => 'required|exists:users,id',
            'ruta_id'   => 'required|exists:rutas,id',
            'fecha'     => 'required|date',
        ]);

        // Convertir fecha correctamente
        $fecha = \Carbon\Carbon::parse($request->fecha)->format('Y-m-d H:i:s');

        // Validar que no exista itinerario duplicado
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

        // Crear itinerario
        $itinerario = ItinerarioChofer::create([
            'chofer_id' => $request->chofer_id,
            'ruta_id'   => $request->ruta_id,
            'fecha'     => $fecha,
        ]);

        // Guardar paradas intermedias (SI existen)
        if ($request->has('paradas')) {
            foreach ($request->paradas['lugar'] as $index => $lugar) {
                if (!empty($lugar) && !empty($request->paradas['tiempo'][$index])) {
                    \App\Models\ParadaItinerario::create([
                        'itinerario_chofer_id' => $itinerario->id,
                        'lugar_parada' => $lugar,
                        'tiempo_parada' => $request->paradas['tiempo'][$index],
                    ]);
                }
            }
        }

        // Redirección final
        return redirect()->route('itinerarioChofer.index')
            ->with('success', 'Itinerario asignado correctamente con parada(s) intermedia(s).');
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
            'ruta_id' => 'required|exists:rutas,id',
            'fecha' => 'required|date',
        ]);

        $fecha = Carbon::parse($request->fecha)->format('Y-m-d H:i:s');

        $itinerarioChofer->update([
            'chofer_id'=>$request->chofer_id,
            'ruta_id'=>$request->ruta_id,
            'fecha'=>$fecha
        ]);

// eliminar paradas anteriores
        ParadaItinerario::where('itinerario_chofer_id',$itinerarioChofer->id)->delete();

        if($request->has('paradas')){

            foreach($request->paradas['lugar'] as $index=>$lugar){

                if(!empty($lugar) && !empty($request->paradas['tiempo'][$index])){

                    ParadaItinerario::create([
                        'itinerario_chofer_id'=>$itinerarioChofer->id,
                        'lugar_parada'=>$lugar,
                        'tiempo_parada'=>$request->paradas['tiempo'][$index]
                    ]);

                }

            }

        }

        return redirect()->route('itinerarioChofer.index')
            ->with('success','Itinerario actualizado correctamente');

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

        $itinerarios = ItinerarioChofer::with('ruta')
            ->where('chofer_id', $choferId)
            ->orderBy('fecha', 'asc')
            ->get();

        return view('chofer.itinerario', compact('itinerarios'));
    }
}
