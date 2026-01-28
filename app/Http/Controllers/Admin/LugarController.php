<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lugar;        // Modelo para los lugares
use App\Models\Departamento; // Modelo de departamento

class LugarController extends Controller
{
    // Mostrar todos los lugares de un departamento
    public function index(Request $request)
    {
        $departamento_id = $request->get('departamento_id');
        $departamento = Departamento::findOrFail($departamento_id);
        $lugares = $departamento->lugares; // Relación en el modelo Departamento

        return view('admin.lugares.index', compact('lugares', 'departamento'));
    }

    // Mostrar formulario para crear un nuevo lugar
    public function create(Request $request)
    {
        $departamento_id = $request->get('departamento_id');
        return view('admin.lugares.create', compact('departamento_id'));
    }

    // Guardar nuevo lugar
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        $data = $request->only('nombre', 'departamento_id');

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('lugares', 'public');
        }

        Lugar::create($data);

        return redirect()->route('admin.lugares.index', ['departamento_id' => $request->departamento_id])
            ->with('success', 'Lugar creado correctamente');
    }

    // Mostrar formulario para editar un lugar
    public function edit($id)
    {
        $lugar = Lugar::findOrFail($id);
        return view('admin.lugares.edit', compact('lugar'));
    }

    // Actualizar lugar
    public function update(Request $request, $id)
    {
        $lugar = Lugar::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $lugar->nombre = $request->nombre;

        if ($request->hasFile('imagen')) {
            $lugar->imagen = $request->file('imagen')->store('lugares', 'public');
        }

        $lugar->save();

        return redirect()->route('admin.lugares.index', ['departamento_id' => $lugar->departamento_id])
            ->with('success', 'Lugar actualizado correctamente');
    }

    // Eliminar lugar
    public function destroy($id)
    {
        $lugar = Lugar::findOrFail($id);
        $departamento_id = $lugar->departamento_id;
        $lugar->delete();

        return redirect()->route('admin.lugares.index', ['departamento_id' => $departamento_id])
            ->with('success', 'Lugar eliminado correctamente');
    }
}
