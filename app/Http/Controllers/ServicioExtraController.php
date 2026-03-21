<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\ServiciosExtra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioExtraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $allowed = [5, 10, 25, 50];
        $perPage = $request->input('perPage', 5);
        if (!in_array($perPage, $allowed)) $perPage = 5;

        $usuario = Auth::user();

        $extras = ServiciosExtra::with('extras', 'reserva')
            ->where('user_id', $usuario->id)
            ->paginate($perPage);

        return view('extras.extra_index', compact('extras', 'perPage'));
    }

    public function create(Request $request)
    {
        $usuario = Auth::user();
        $fecha_hoy = date("Y-m-d");
        $reservas = $usuario->reservas()->where('fecha_reserva', '>=', $fecha_hoy)->get();

        // Opciones de paginación
        $allowed = [5, 10, 25, 50];
        $perPage = $request->input('perPage', 5);
        if (!in_array($perPage, $allowed)) $perPage = 5;

        // Filtro de búsqueda
        $buscar = $request->input('buscar', '');

        $extrasQuery = Extra::where('estado', 1);

        if (!empty($buscar)) {
            $extrasQuery->where('nombre', 'like', '%' . $buscar . '%');
        }

        $extras = $extrasQuery->paginate($perPage)->appends($request->all());

        return view('extras.extra_create', compact('reservas', 'extras', 'perPage', 'buscar'));
    }

    public function store(Request $request)
    {
        $usuario = Auth::user();
        $servicio = new ServiciosExtra();
        $servicio->reserva_id = $request->reserva_id;
        $servicio->user_id = $usuario->id;
        $servicio->fecha = date('Y-m-d');
        $servicio->save();

        foreach ($request->extras_seleccionados as $extra_id) {
            $servicio->extras()->attach($extra_id);
        }

        return redirect()->route('servicios_reserva.index')
            ->with('success', 'Servicios adicionales agregados correctamente.');
    }

    public function show(string $id) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
