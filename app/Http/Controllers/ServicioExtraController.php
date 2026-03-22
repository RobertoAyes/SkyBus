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

    /**
     * LISTADO (HISTORIAL) DE SERVICIOS ADICIONALES DEL USUARIO
     */
    public function index(Request $request)
    {
        $allowed = [5, 10, 25, 50];
        $perPage = $request->input('perPage', 5);
        if (!in_array($perPage, $allowed)) {
            $perPage = 5;
        }

        // 🔹 Traer solo los servicios extras del usuario logueado
        // 🔹 Incluir la reserva y los extras asociados
        $extras = ServiciosExtra::with(['reserva', 'extras'])
            ->where('user_id', Auth::id())
            ->orderBy('fecha', 'desc')
            ->paginate($perPage)
            ->appends($request->all());

        return view('extras.extra_index', compact('extras', 'perPage'));
    }

    /**
     * FORMULARIO PARA CREAR NUEVOS SERVICIOS ADICIONALES
     */
    public function create(Request $request)
    {
        $usuario = Auth::user();
        $fecha_hoy = date("Y-m-d");

        // 🔹 Reservas activas del usuario
        $reservas = $usuario->reservas()
            ->where('fecha_reserva', '>=', $fecha_hoy)
            ->get();

        $allowed = [5, 10, 25, 50];
        $perPage = $request->input('perPage', 5);
        if (!in_array($perPage, $allowed)) $perPage = 5;

        $buscar = $request->input('buscar');
        $query = Extra::where('estado', 1);
        if (!empty($buscar)) {
            $query->where('nombre', 'like', '%' . $buscar . '%');
        }

        $extras = $query->paginate($perPage)->appends($request->all());

        return view('extras.extra_create', compact('reservas', 'extras', 'perPage', 'buscar'));
    }

    /**
     * GUARDAR SERVICIOS ADICIONALES ASOCIADOS A UNA RESERVA
     */
    public function store(Request $request)
    {
        $usuario = Auth::user();

        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'extras_seleccionados' => 'required|array',
        ]);

        $servicio = new ServiciosExtra();
        $servicio->reserva_id = $request->reserva_id;
        $servicio->user_id = $usuario->id;
        $servicio->fecha = date('Y-m-d');
        $servicio->save();

        // 🔹 Asociar extras a la tabla pivote correcta
        $servicio->extras()->attach($request->extras_seleccionados);

        return redirect()->route('servicios_reserva.index')
            ->with('success', 'Servicios adicionales agregados correctamente.');
    }

    public function show(string $id) { }
    public function edit(string $id) { }
    public function update(Request $request, string $id) { }
    public function destroy(string $id) { }
}
