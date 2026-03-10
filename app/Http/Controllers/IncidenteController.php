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
        // Aquí se revisa que los campos vengan llenos.
        // Si alguno falta, Laravel regresa al formulario
        // y muestra los errores.
        $request->validate([
            'conductor_nombre' => 'required',
            'bus_numero'       => 'required',
            'ruta'             => 'required',
            'tipo_incidente'   => 'required',
            'descripcion'      => 'required',

            // Campos nuevos HU73
            'ubicacion'        => 'required',
            'nivel_gravedad'   => 'required',
        ]);

        // Aquí se guarda el incidente en la base de datos.
        Incidente::create([
            'empleado_id' => auth()->id(),

            // Datos del formulario
            'conductor_nombre' => $request->conductor_nombre,
            'bus_numero'       => $request->bus_numero,
            'ruta'             => $request->ruta,
            'tipo_incidente'   => $request->tipo_incidente,
            'descripcion'      => $request->descripcion,

            // Campos nuevos HU73
            'ubicacion'        => $request->ubicacion,
            'nivel_gravedad'   => $request->nivel_gravedad,

            // Estado inicial del reporte
            'estado'           => 'pendiente',
        ]);

        // Después de guardar, regresamos al formulario
        // y mostramos un mensaje de éxito.
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


        if ($request->bus_numero) {
            $query->where('bus_numero', 'like', "%{$request->bus_numero}%");
        }


        if ($request->conductor_nombre) {
            $query->where('conductor_nombre', 'like', "%{$request->conductor_nombre}%");
        }


        if ($request->tipo_incidente) {
            $query->where('tipo_incidente', $request->tipo_incidente);
        }


        if ($request->fecha_hora) {
            $query->whereDate('fecha_hora', $request->fecha_hora);
        }

        $incidentes = $query->orderBy('fecha_hora', 'desc')->paginate(10);

        return view('empleados.incidentes.historial_incidentes', compact('incidentes'));
    }

}
