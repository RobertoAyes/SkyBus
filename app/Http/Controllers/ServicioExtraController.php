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
        // Opciones de paginación
        $allowed = [5, 10, 25, 50];
        $perPage = $request->input('perPage', 5);
        if (!in_array($perPage, $allowed)) $perPage = 5;

        $usuario = Auth::user();

        // Traer solo los servicios del usuario logueado con extras y reserva
        $extras = ServiciosExtra::with('extras', 'reserva')
            ->where('user_id', $usuario->id)
            ->paginate($perPage);

        return view('extras.extra_index', compact('extras', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuario = Auth::user();
        $fecha_hoy = date("Y-m-d");
        $reservas = $usuario->reservas()->where('fecha_reserva', '>=', $fecha_hoy)->get();
        $extras = Extra::where('estado', 1)->get();
        return view('extras.extra_create', compact('reservas', 'extras'));
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
