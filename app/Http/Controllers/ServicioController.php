<?php

namespace App\Http\Controllers;

use App\Models\RegistroTerminal;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Laravel\Prompts\Terminal;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
     $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $terminales = RegistroTerminal::all();
        return view('servicios.servicios_create', compact('terminales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'terminal_id' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
        ],
            [
                'terminal_id.required' => 'La terminal es obligatoria.',
                'nombre.required' => 'El nombre es obligatorio.',
                'descripcion.required' => 'La descripcion es obligatoria.',
            ]);

        $servicio = new Servicio();
        $servicio->registro_terminal_id = $request->input('terminal_id');
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        if ($servicio->save()) {
            return redirect()->route('terminales.index')->with('success', 'Servicio disponible agregado con éxito.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $terminal = RegistroTerminal::findOrfail($id);
        return view('servicios.servicios_edit', compact('terminal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicio = Servicio::findOrfail($id);
        $terminal_id = $servicio->registro_terminal_id;
        $terminal = RegistroTerminal::findOrfail($terminal_id);
        if ($servicio->delete()) {
            return redirect()->route('servicios.edit', $terminal->id)->with('success', 'Servicio disponible eliminado con éxito.');
        }
    }
}

