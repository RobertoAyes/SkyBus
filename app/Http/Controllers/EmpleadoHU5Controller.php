<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoHU5Controller extends Controller
{
    public function index(Request $request)
    {
        $query = Empleado::query();

        // Búsqueda general
        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                    ->orWhere('apellido', 'like', "%$buscar%")
                    ->orWhere('cargo', 'like', "%$buscar%");
            });
        }

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->input('rol'));
        }

        if ($request->filled('fecha_registro')) {
            $query->whereDate('created_at', $request->input('fecha_registro'));
        }

        $empleados = $query->orderBy('nombre')->paginate(10);

        // Retorna a la vista correcta
        return view('empleados.index_hu5', compact('empleados'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|unique:empleados,dni,' . $empleado->id,
            'cargo' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'rol' => 'required|string',
            'estado' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $empleado->nombre = $request->nombre;
        $empleado->apellido = $request->apellido;
        $empleado->dni = $request->dni;
        $empleado->cargo = $request->cargo;
        $empleado->fecha_ingreso = $request->fecha_ingreso;
        $empleado->rol = $request->rol;
        $empleado->estado = $request->estado;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('empleados', 'public');
            $empleado->foto = $path;
        }

        $empleado->save();

        return redirect()->route('empleados.hu5')->with('success', 'Empleado actualizado correctamente.');
    }
}
