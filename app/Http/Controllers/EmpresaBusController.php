<?php

namespace App\Http\Controllers;

use App\Models\EmpresaBus;
use Illuminate\Http\Request;

class EmpresaBusController extends Controller
{
    /**
     * Muestra el formulario y guarda la empresa en una sola ruta.
     */


    // HU10 VISUALIZAR EMPRESAS DE BUSES
    public function index()
    {
        // MODIFICACIÓN: Obtener todas las empresas y pasarlas a la vista
        $empresas = EmpresaBus::all();
        return view('terminal.empresas.visualizar', compact('empresas'));

    }

    public function form(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'nombre' => 'required|unique:empresa_buses|max:255',
                'direccion' => 'required|max:255',
                'telefono' => [
                    'required',
                    'regex:/^[839]\d{7}$/', // ← inicia con 8, 3 o 9 y tiene 8 dígitos
                ],
                'email' => 'nullable|email|max:255', // solo este NO es obligatorio
                'propietario' => 'required|max:255',
            ],
                [
                    'nombre.unique' => 'El nombre de la empresa ya ha sido registrado.',
                    'nombre.required' => 'El campo nombre es obligatorio.',
                ]);


            EmpresaBus::create($request->all());

            return back()->with('success', 'Empresa registrada correctamente.');
        }

        // Si es GET, solo muestra el formulario
        return view('empresa.create');
    }
    public function formUsuario(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'nombre' => 'required|unique:empresa_buses,nombre|max:255',
                'propietario' => 'required|unique:empresa_buses,propietario|max:255',
                'telefono' => ['required', 'regex:/^[839]\d{7}$/', 'unique:empresa_buses,telefono'],
                'email' => 'nullable|email|unique:empresa_buses,email',
                'direccion' => 'required|unique:empresa_buses,direccion|max:255',
            ]
            , [
                'nombre.unique' => 'El nombre de la empresa ya ha sido registrado.',
                'nombre.required' => 'El campo nombre es obligatorio.',
            ]);

            EmpresaBus::create($request->all());

            return back()->with('success', 'Registro exitoso, su empresa sera
            verificada y aceptada por un administrador.');
        }

        // Aquí apuntamos a tu vista real
        return view('Empresa.MiEmpresa');
    }
}
