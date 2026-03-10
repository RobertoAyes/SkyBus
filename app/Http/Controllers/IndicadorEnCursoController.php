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

    public function index()
    {
        $viajes = ItinerarioChofer::with(['chofer', 'ruta'])->whereDate('fecha', date('Y-m-d'))->orderBy('fecha', 'asc')->paginate(10);

        return view('indicadores.indicador_curso', compact('viajes'));
    }
}
