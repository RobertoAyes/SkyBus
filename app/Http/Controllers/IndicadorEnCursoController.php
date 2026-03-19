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
        // Opciones permitidas
        $perPageOptions = [5, 10, 25, 50];

        // Obtener valor desde la request, por defecto 5
        $perPage = $request->get('per_page', 5);

        // Validar que esté dentro de las opciones
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 5;
        }

        $viajes = ItinerarioChofer::with(['chofer', 'ruta'])
            ->whereDate('fecha', date('Y-m-d'))
            ->orderBy('fecha', 'asc')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]); // Mantiene el valor en la paginación

        return view('indicadores.indicador_curso', compact('viajes', 'perPage'));
    }
}
