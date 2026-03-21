<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\ServiciosExtra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Opciones permitidas
        $allowed = [5, 10, 25, 50];

        // Valor seleccionado por el usuario o default = 5
        $perPage = $request->input('per_page', 5);

        // Validar que esté dentro de los permitidos
        if (!in_array($perPage, $allowed)) {
            $perPage = 5;
        }

        // Consulta con paginación
        $extras = Extra::paginate($perPage);

        return view('extras.extra_index', compact('extras', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $usuario = Auth::user();
        $fecha_hoy = date("Y-m-d");

        $reservas = $usuario->reservas()
            ->where('fecha_reserva', '>=', $fecha_hoy)
            ->get();

        // PAGINACIÓN
        $allowed = [5, 10, 25, 50];
        $perPage = $request->input('perPage', 5);

        if (!in_array($perPage, $allowed)) {
            $perPage = 5;
        }

        // FILTRO
        $buscar = $request->input('buscar');

        $query = Extra::where('estado', 1);

        if (!empty($buscar)) {
            $query->where('nombre', 'like', '%' . $buscar . '%');
        }

        $extras = $query->paginate($perPage)
            ->appends($request->all());

        return view('extras.extra_create', compact('reservas', 'extras', 'perPage', 'buscar'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
