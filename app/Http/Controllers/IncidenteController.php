<?php

namespace App\Http\Controllers;

// Aqui se valida y se guarda el incidente.

use App\Models\Incidente;
use Illuminate\Http\Request;
use App\Models\Notificacion;
use App\Models\User;

class IncidenteController extends Controller
{
    // Esta función solo sirve para mostrar la pantalla
    // donde el conductor va a llenar el formulario.
    public function create()
    {
        // Estos son los tipos de incidente que van a salir
        // en el combo (desplegable).
        $tipos = [
            'Retraso',
            'Avería',
            'Inconveniente',
            'Otro'
        ];

        // Aquí tomo el nombre del usuario que inició sesión.
        // Si por alguna razón no existe, pongo "Conductor".
        $conductorNombre = auth()->user()->name ?? 'Conductor';

        // Aquí le digo a Laravel que muestre la vista
        // incidentes/create.blade.php
        return view(
            'empleados.incidentes.create_incidente',
            compact('tipos', 'conductorNombre')
        );


    }

    // Esta función se ejecuta cuando el formulario se envía
    // (cuando el conductor presiona el botón Guardar).
    public function store(Request $request)
    {
        $request->validate([
            'conductor_nombre' => 'required',
            'bus_numero'       => 'required',
            'ruta'             => 'required',
            'tipo_incidente'   => 'required',
            'descripcion'      => 'required',
            'ubicacion'        => 'required',
            'nivel_gravedad'   => 'required',
        ]);

        $empleadoId = auth()->id();

        // Evitar registros duplicados enviados casi al mismo tiempo
        $incidenteReciente = Incidente::where('empleado_id', $empleadoId)
            ->where('bus_numero', $request->bus_numero)
            ->where('ruta', $request->ruta)
            ->where('tipo_incidente', $request->tipo_incidente)
            ->where('descripcion', $request->descripcion)
            ->where('ubicacion', $request->ubicacion)
            ->where('nivel_gravedad', $request->nivel_gravedad)
            ->where('created_at', '>=', now()->subSeconds(10))
            ->first();

        if ($incidenteReciente) {
            return redirect()
                ->route('empleado.misIncidentes')
                ->with('success', 'El incidente ya fue registrado.');
        }

        Incidente::create([
            'empleado_id'      => $empleadoId,
            'conductor_nombre' => $request->conductor_nombre,
            'bus_numero'       => $request->bus_numero,
            'ruta'             => $request->ruta,
            'tipo_incidente'   => $request->tipo_incidente,
            'descripcion'      => $request->descripcion,
            'ubicacion'        => $request->ubicacion,
            'nivel_gravedad'   => $request->nivel_gravedad,
            'estado'           => 'pendiente',
        ]);

        return redirect()
            ->route('empleado.misIncidentes')
            ->with('success', 'Incidente reportado con éxito.');
    }

        // Esta función permite que el empleado vea
        // todos los incidentes que él mismo ha registrado.
        public function misIncidentes()
        {
            // Obtener el empleado que inició sesión
            $empleado = auth()->user();

            // Buscar en la tabla incidentes los registros
            // que tengan el mismo empleado_id
            // y ordenarlos por fecha (más recientes primero)
            $incidentes = Incidente::where('empleado_id', $empleado->id)
                ->orderBy('fecha_hora', 'desc')
                ->get();

            // Enviar los datos a la vista
            return view('empleados.incidentes.mis_incidentes', compact('incidentes'));
    }

    public function historial(Request $request)
    {
        $query = Incidente::query();


        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('conductor_nombre', 'like', "%{$buscar}%")
                    ->orWhere('ruta',           'like', "%{$buscar}%")
                    ->orWhere('bus_numero',     'like', "%{$buscar}%");
            });
        }


        if ($request->filled('estado')) {
            if ($request->estado === 'respondido') {
                $query->whereNotNull('acciones_tomadas')
                    ->where('acciones_tomadas', '!=', '');
            } elseif ($request->estado === 'pendiente') {
                $query->where(function ($q) {
                    $q->whereNull('acciones_tomadas')
                        ->orWhere('acciones_tomadas', '');
                });
            }
        }

        if ($request->filled('tipo_incidente')) {
            $query->where('tipo_incidente', $request->tipo_incidente);
        }


        if ($request->filled('fecha')) {
            $query->whereDate('fecha_hora', $request->fecha);
        }
        $perPage = $request->input('per_page', 5);

        $incidentes = $query->orderBy('fecha_hora', 'desc')->paginate($perPage)->withQueryString();

        return view('empleados.incidentes.historial_incidentes', compact('incidentes'));
    }

    public function responder(Request $request, $id)
    {
        $request->validate([
            'acciones_tomadas' => 'required'
        ]);

        $incidente = Incidente::findOrFail($id);

        $incidente->acciones_tomadas = $request->acciones_tomadas;

        $incidente->save();

        return redirect()->back()->with('success' , ' Respuesta enviada correctamente.');

    }
}
