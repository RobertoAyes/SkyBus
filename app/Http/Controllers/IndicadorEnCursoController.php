<?php

namespace App\Http\Controllers;

use App\Models\ItinerarioChofer;
use Illuminate\Http\Request;

class IndicadorEnCursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Opciones permitidas de registros por página
        $perPageOptions = [5, 10, 25, 50];
        $perPage = $request->get('per_page', 5);
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 5;
        }

        // FECHA: usar la enviada en la request si existe, si no usar hoy
        $fecha = $request->filled('fecha') ? $request->get('fecha') : date('Y-m-d');

        $query = ItinerarioChofer::with(['chofer', 'ruta'])
            ->whereDate('fecha', $fecha); // siempre limitar a la fecha seleccionada o hoy

        // BUSQUEDA GENERAL (chofer o ruta)
        if ($buscar = $request->get('buscar')) {
            $query->where(function ($q) use ($buscar) {
                $q->whereHas('chofer', function ($q2) use ($buscar) {
                    $q2->where('name', 'like', "%{$buscar}%");
                })
                    ->orWhereHas('ruta', function ($q3) use ($buscar) {
                        $q3->where('origen', 'like', "%{$buscar}%")
                            ->orWhere('destino', 'like', "%{$buscar}%");
                    });
            });
        }

        // FILTRO POR ESTADO (Pendiente, En ruta, Atrasado, Finalizado)
        if ($estado = $request->get('estado')) {
            $query->where('estado_viaje', $estado);
        }

        // Ordenar por hora estimada
        $viajes = $query->orderBy('fecha', 'asc')
            ->paginate($perPage)
            ->appends($request->except('page')); // mantener filtros en paginación

        return view('indicadores.indicador_curso', compact('viajes', 'perPage', 'fecha'));
    }
}
