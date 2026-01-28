<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comida;
use App\Models\Departamento;

class ComidaController extends Controller
{
    // Listar todas las comidas de un departamento
    public function index(Request $request)
    {
        $departamento_id = $request->get('departamento_id');
        $departamento = Departamento::findOrFail($departamento_id);
        $comidas = $departamento->comidas; // Relación en el modelo Departamento

        return view('admin.comidas.index', compact('comidas', 'departamento'));
    }

    // Mostrar formulario para crear nueva comida
    public function create(Request $request)
    {
        $departamento_id = $request->get('departamento_id');
        return view('admin.comidas.create', compact('departamento_id'));
    }

    // Guardar nueva comida
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        $comida = new Comida();
        $comida->nombre = $request->nombre;
        $comida->departamento_id = $request->departamento_id;

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('comidas', 'public');
            $comida->imagen = '/storage/' . $path;
        }

        $comida->save();

        return redirect()->route('admin.comidas.index', ['departamento_id' => $request->departamento_id])
            ->with('success', 'Comida creada correctamente.');
    }

    // Mostrar formulario para editar comida
    public function edit($id)
    {
        $comida = Comida::findOrFail($id);
        return view('admin.comidas.edit', compact('comida'));
    }

    // Actualizar comida
    public function update(Request $request, $id)
    {
        $comida = Comida::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $comida->nombre = $request->nombre;

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('comidas', 'public');
            $comida->imagen = '/storage/' . $path;
        }

        $comida->save();

        return redirect()->route('admin.comidas.index', ['departamento_id' => $comida->departamento_id])
            ->with('success', 'Comida actualizada correctamente.');
    }

    // Eliminar comida
    public function destroy($id)
    {
        $comida = Comida::findOrFail($id);
        $departamento_id = $comida->departamento_id;
        $comida->delete();

        return redirect()->route('admin.comidas.index', ['departamento_id' => $departamento_id])
            ->with('success', 'Comida eliminada correctamente.');
    }
}
