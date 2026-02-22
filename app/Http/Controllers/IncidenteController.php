<?php

namespace App\Http\Controllers;

// Aqui se valida y se guarda el incidente.

use App\Models\Incidente;
use Illuminate\Http\Request;

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
        // Aquí reviso que los campos vengan llenos.
        // Si alguno falta, Laravel regresa al formulario
        // y muestra los errores.
        $request->validate([
            'conductor_nombre' => 'required',
            'bus_numero'       => 'required',
            'ruta'             => 'required',
            'tipo_incidente'   => 'required',
            'descripcion'      => 'required',
        ]);

        // Aquí se guarda el incidente en la base de datos.
        Incidente::create([
            // Por ahora no usamos todavía el empleado real,
            // luego lo conectamos mejor.
            'empleado_id' => auth()->id(),

            // Datos que vienen del formulario
            'conductor_nombre' => $request->conductor_nombre,
            'bus_numero'       => $request->bus_numero,
            'ruta'             => $request->ruta,
            'tipo_incidente'   => $request->tipo_incidente,
            'descripcion'      => $request->descripcion,

            // La fecha y hora no la mandamos,
            // porque la base de datos la pone sola.
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

}
