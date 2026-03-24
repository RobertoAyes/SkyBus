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
        $perPage = $request->input('per_page', 5);
        if (!in_array($perPage, $allowed)) {
            $perPage = 5;
        }

        // 🔹 Construir la consulta base
        $query = ServiciosExtra::with(['reserva', 'extras'])
            ->where('user_id', Auth::id())
            ->orderBy('fecha', 'desc');

        // 🔹 Búsqueda general por código de reserva o nombre de extras
        if ($buscar = $request->input('buscar')) {
            $query->where(function ($q) use ($buscar) {
                // Buscar en código de reserva
                $q->whereHas('reserva', function ($qr) use ($buscar) {
                    $qr->where('codigo_reserva', 'like', "%{$buscar}%");
                })
                    // O buscar en los nombres de los extras
                    ->orWhereHas('extras', function ($qe) use ($buscar) {
                        $qe->where('nombre', 'like', "%{$buscar}%");
                    });
            });
        }

        // 🔹 Filtrado por fechas
        if ($fecha_desde = $request->input('fecha_desde')) {
            $query->whereDate('fecha', '>=', $fecha_desde);
        }
        if ($fecha_hasta = $request->input('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $fecha_hasta);
        }

        // 🔹 Obtener resultados paginados
        $extras = $query->paginate($perPage)->appends($request->all());

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
            'extras_seleccionados' => 'required|array|max:3',
            'extras_seleccionados.*' => 'exists:extras,id',
        ], [
            'reserva_id.required' => 'Debe seleccionar una reserva.',
            'extras_seleccionados.required' => 'Debe seleccionar al menos un servicio.',
            'extras_seleccionados.max' => 'Solo puedes seleccionar máximo 3 servicios.',
        ]);

        // EVITAR DUPLICADOS
        $existe = ServiciosExtra::where('reserva_id', $request->reserva_id)
            ->where('user_id', $usuario->id)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Esta reserva ya tiene servicios adicionales asignados.');
        }

        // 🔹 CREAR
        $servicio = new ServiciosExtra();
        $servicio->reserva_id = $request->reserva_id;
        $servicio->user_id = $usuario->id;
        $servicio->fecha = date('Y-m-d');
        $servicio->save();

        // 🔹 ASOCIAR
        $servicio->extras()->attach($request->extras_seleccionados);

        return redirect()->route('servicios_reserva.index')
            ->with('success', 'Servicios adicionales agregados correctamente.')
            ->with('limpiar_extras', true);
    }

    public function show(string $id) { }
    public function edit(string $id) { }
    public function update(Request $request, string $id) { }
    public function destroy(string $id) { }
}
