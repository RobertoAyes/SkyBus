<?php

namespace App\Http\Controllers;

use App\Models\ItinerarioChofer;
use App\Models\Ruta;
use Illuminate\Http\Request;

class IndicadorEnCursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $ahora = now();

        $query = ItinerarioChofer::with(['chofer', 'ruta'])
            ->whereDate('fecha', today());


        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('chofer', function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%");
            });
        }


        if ($request->filled('ruta_id')) {
            $query->where('ruta_id', $request->ruta_id);
        }


        if ($request->filled('hora')) {
            $query->whereTime('fecha', $request->hora);
        }


        if ($request->filled('estado')) {
            switch ($request->estado) {

                case 'en_curso':

                    $query->whereNotNull('hora_salida')
                        ->whereNull('hora_llegada');
                    break;

                case 'completado':

                    $query->whereNotNull('hora_salida')
                        ->whereNotNull('hora_llegada');
                    break;

                case 'atrasado':

                    $query->whereNull('hora_salida')
                        ->where('fecha', '<', $ahora);
                    break;

                case 'pendiente':

                    $query->whereNull('hora_salida')
                        ->where('fecha', '>=', $ahora);
                    break;
            }
        }

        $viajes = $query->orderBy('fecha', 'asc')->paginate(5)->withQueryString();

        $rutas = Ruta::orderBy('origen')->get();

        return view('indicadores.indicador_curso', compact('viajes', 'rutas'));
    }
}
