<?php

namespace App\Http\Controllers;

use App\Models\EmpresaBus;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $estado = $request->get('estado');

        $empresas = EmpresaBus::query();

        //Búsqueda por nombre o correo
        if ($search) {
            $empresas->where(function ($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtrado por estado_validacion (activo/inactivo)
        if ($estado !== null && $estado !== '') {
            $empresas->where('estado_validacion', $estado);
        }

        // Paginación
        $empresas = $empresas->paginate(10);

        // Generar número de registro automático (no se guarda en BD)
        foreach ($empresas as $empresa) {
            $empresa->numero_registro = 'EMP-' . str_pad($empresa->id, 4, '0', STR_PAD_LEFT);
        }

        // Retornar vista con datos
        return view('terminal.empresas.index', compact('empresas', 'search', 'estado'));
    }

    public function update(Request $request, $id)
    {
        $empresa = EmpresaBus::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:empresa_buses,email,' . $empresa->id,
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required|in:0,1',
        ]);

        $empresa->nombre = $request->nombre;
        $empresa->email = $request->email;
        $empresa->telefono = $request->telefono;
        $empresa->estado_validacion = $request->estado;

        $empresa->save();

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa actualizada correctamente.');
    }

}
