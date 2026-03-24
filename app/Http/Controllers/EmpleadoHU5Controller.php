<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoHU5Controller extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 5); // Por defecto 5

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
            $query->whereDate('fecha_ingreso', $request->input('fecha_registro'));
        }

        // Paginación dinámica con orden y filtros aplicados
        $empleados = $query->orderBy('id', 'desc')
            ->paginate($perPage)
            ->appends($request->all());

        return view('empleados.index_hu5', compact('empleados'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20',
            'cargo' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'rol' => 'required|string',
            'estado' => 'required|string',
            'foto' => 'nullable|image|max:2048', // 2MB
        ]);

        // Actualizar campos
        $empleado->nombre = $request->nombre;
        $empleado->apellido = $request->apellido;
        $empleado->dni = $request->dni;
        $empleado->cargo = $request->cargo;
        $empleado->fecha_ingreso = $request->fecha_ingreso;
        $empleado->rol = $request->rol;
        $empleado->estado = $request->estado;

        // Si hay foto nueva, guardarla
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('empleados', 'public');
            $empleado->foto = $foto;
        }

        $empleado->save(); // Guarda cambios en DB

        // REDIRECCIÓN a la lista de empleados para refrescar tabla
        return redirect()->route('empleados.hu5')
            ->with('success', 'Empleado actualizado correctamente.');
    }
}
