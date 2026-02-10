<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use Illuminate\Http\Request;

class RutaController extends Controller
{

    public function create()
    {
        return view('rutas.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'origen' => 'required|string',
            'destino' => 'required|string|different:origen',
            'distancia' => 'required|numeric|min:5',
            'duracion_estimada' => 'required|integer|min:15',
        ], [
            'destino.different' => 'El destino debe ser diferente al origen.',
            'distancia.min' => 'La distancia mínima permitida es 5 km.',
            'duracion_estimada.min' => 'La duración mínima permitida es 15 minutos.',
        ]);

        if (
            Ruta::where('origen', $request->origen)
                ->where('destino', $request->destino)
                ->exists()
        ) {
            return redirect()->back()
                ->withErrors(['duplicado' => 'Esta ruta ya está registrada'])
                ->withInput();
        }

        Ruta::create($request->all());

        return redirect()->back()
            ->with('success', 'Ruta registrada correctamente');
    }


    public function index()
    {
        $rutas = Ruta::all();
        return view('rutas.index', compact('rutas'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'origen' => 'required|string',
            'destino' => 'required|string|different:origen',
            'distancia' => 'required|numeric|min:0.5',
            'duracion_estimada' => 'required|integer|min:5',
        ], [
            'destino.different' => 'El destino debe ser diferente al origen.',
            'distancia.min' => 'La distancia mínima permitida es 5 km.',
            'duracion_estimada.min' => 'La duración mínima permitida es 15 minutos.',
        ]);

        if (
            Ruta::where('origen', $request->origen)
                ->where('destino', $request->destino)
                ->where('id', '!=', $id)
                ->exists()
        ) {
            return redirect()->back()
                ->withErrors(['duplicado' => 'Esta ruta ya está registrada'])
                ->withInput();
        }

        $ruta = Ruta::findOrFail($id);
        $ruta->update($request->all());

        return redirect()->route('rutas.index')
            ->with('success', 'Ruta actualizada correctamente');
    }
}
