<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departamento; // Asegúrate de tener este modelo

class DepartamentoController extends Controller
{
    // Mostrar todos los departamentos
    public function index()
    {
        $departamentos = Departamento::all();
        return view('admin.departamentos.index', compact('departamentos'));
    }

    // Mostrar formulario para crear un nuevo departamento
    public function create()
    {
        return view('admin.departamentos.create');
    }

    // Guardar nuevo departamento
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only('nombre');

        // Subir imagen si existe
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('departamentos', 'public');
        }

        Departamento::create($data);

        return redirect()->route('admin.departamentos.index')->with('success', 'Departamento creado correctamente');
    }

    // Mostrar formulario para editar un departamento
    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('admin.departamentos.edit', compact('departamento'));
    }

    // Actualizar departamento
    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $departamento->nombre = $request->nombre;

        // Subir nueva imagen si existe
        if ($request->hasFile('imagen')) {
            $departamento->imagen = $request->file('imagen')->store('departamentos', 'public');
        }

        $departamento->save();

        return redirect()->route('admin.departamentos.index')->with('success', 'Departamento actualizado correctamente');
    }

    // Eliminar departamento
    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('admin.departamentos.index')->with('success', 'Departamento eliminado correctamente');
    }
}
