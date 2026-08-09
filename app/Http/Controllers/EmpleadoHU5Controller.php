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
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u',
            ],

            'apellido' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u',
            ],

            'dni' => [
                'required',
                'regex:/^[0-9]{13}$/',
            ],

            'cargo' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/u',
            ],

            'fecha_ingreso' => [
                'required',
                'date',
            ],

            'rol' => [
                'required',
                'string',
            ],

            'estado' => [
                'required',
                'string',
            ],

            'foto' => [
                'nullable',
                'image',
                'max:2048',
            ],

        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.string' => 'El apellido debe ser texto.',
            'apellido.max' => 'El apellido no puede tener más de 255 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',

            'dni.required' => 'El DNI es obligatorio.',
            'dni.regex' => 'El DNI debe contener exactamente 13 números.',

            'cargo.required' => 'El cargo es obligatorio.',
            'cargo.string' => 'El cargo debe ser texto.',
            'cargo.max' => 'El cargo no puede tener más de 255 caracteres.',
            'cargo.regex' => 'El cargo solo puede contener letras y espacios.',

            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.date' => 'La fecha de ingreso no es válida.',

            'rol.required' => 'Debe seleccionar un rol.',
            'estado.required' => 'Debe seleccionar un estado.',

            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.max' => 'La foto no puede superar los 2 MB.',
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

        $empleado->save();

        // REDIRECCIÓN a la lista de empleados para refrescar tabla
        return redirect()->route('empleados.hu5')
            ->with('success', 'Empleado actualizado correctamente.');
    }
}
