<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistroTerminal;

class ConsultaParadaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $userLat = $request->input('lat');
        $userLng = $request->input('lng');
        $orderBy = $request->input('order_by', 'nombre');

        $terminales = RegistroTerminal::query()
            ->when($search, function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('direccion', 'like', "%$search%")
                    ->orWhere('municipio', 'like', "%$search%")
                    ->orWhere('departamento', 'like', "%$search%")
                    ->orWhere('codigo', 'like', "%$search%");
            });

        // Calcular distancia si tenemos coordenadas del usuario
        if ($userLat && $userLng) {
            $terminales = $terminales->selectRaw('*,
            (6371 * acos(cos(radians(?)) * cos(radians(latitud)) * cos(radians(longitud) - radians(?)) + sin(radians(?)) * sin(radians(latitud)))) AS distancia',
                [$userLat, $userLng, $userLat]
            );

            if ($orderBy === 'proximidad') {
                $terminales = $terminales->orderBy('distancia');
            }
        }

        // Ordenamientos
        switch ($orderBy) {
            case 'nombre_desc':
                $terminales = $terminales->orderBy('nombre', 'desc');
                break;
            case 'codigo':
                $terminales = $terminales->orderBy('codigo', 'asc');
                break;
            case 'departamento':
                $terminales = $terminales->orderBy('departamento', 'asc');
                break;
            case 'municipio':
                $terminales = $terminales->orderBy('municipio', 'asc');
                break;
            case 'fecha_reciente':
                $terminales = $terminales->orderBy('created_at', 'desc');
                break;
            case 'fecha_antiguo':
                $terminales = $terminales->orderBy('created_at', 'asc');
                break;
            case 'proximidad':
                break;
            default:
                $terminales = $terminales->orderBy('nombre', 'asc');
                break;
        }

        $terminales = $terminales->paginate(10);

        return view('consulta-paradas.index', compact('terminales', 'userLat', 'userLng'));
    }
}
