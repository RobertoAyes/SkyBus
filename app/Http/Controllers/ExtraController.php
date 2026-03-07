<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtraController extends Controller
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
        $extras = Extra::Paginate(10);

        return view('servicios_adicionales.servicios_adicionales-index', compact('extras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('servicios_adicionales.servicios_adicionales-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string|max:1000',
                'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            [
                'nombre.required' => 'El nombre del servicio es obligatorio.',
                'descripcion.required' => 'La descripción es obligatoria.',

                'imagen.required' => 'Debe seleccionar una imagen.',
                'imagen.image' => 'El archivo debe ser una imagen válida.',
                'imagen.mimes' => 'La imagen debe ser formato JPG, JPEG, PNG o WEBP.',
                'imagen.max' => 'La imagen no debe pesar más de 2MB.',
            ]
        );

        $extra = new Extra();
        $extra->nombre = $request->nombre;
        $extra->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('servicios', 'public');
            $extra->imagen = $rutaImagen;
        }

        if ($extra->save()){
            return redirect()->route('servicios_adicionales.index')->with('success', 'Servicio adicional agregado correctamente.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $extra = Extra::findOrFail($id);
        $extra->estado = !$extra->estado;
        if($extra->save()){
            return redirect()->route('servicios_adicionales.index')->with('success', 'Estado actualizado correctamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
