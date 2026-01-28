<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::all();
        return view('admin.departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('admin.departamentos.create');
    }

    public function store(Request $request)
    {
        if($request->hasFile('imagen')){
            $path = $request->file('imagen')->store('departamentos', 'public');
            $request->merge(['imagen' => '/storage/' . $path]);
        }

        Departamento::create($request->all());
        return redirect()->route('admin.departamentos.index')->with('success','Departamento agregado');
    }

    public function edit(Departamento $departamento)
    {
        return view('admin.departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        if($request->hasFile('imagen')){
            $path = $request->file('imagen')->store('departamentos', 'public');
            $request->merge(['imagen' => '/storage/' . $path]);
        }

        $departamento->update($request->all());
        return redirect()->route('admin.departamentos.index')->with('success','Departamento actualizado');
    }

    public function destroy(Departamento $departamento)
    {
        $departamento->delete();
        return redirect()->route('admin.departamentos.index')->with('success','Departamento eliminado');
    }
}
