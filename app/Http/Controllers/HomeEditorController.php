<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeConfig;       // Configuración de la página principal
use App\Models\Departamento;     // Modelo de Departamentos

class HomeEditorController extends Controller
{
    /**
     * Mostrar la página de edición de la Home
     */
    public function index()
    {
        // Configuración general de la página
        $homeConfig = HomeConfig::first();

        // Todos los departamentos con sus lugares y comidas
        $departamentos = Departamento::with(['lugares', 'comidas'])->get();

        return view('admin.home-editor', compact('homeConfig', 'departamentos'));
    }

    /**
     * Actualizar la configuración de la página principal
     */
    public function update(Request $request)
    {
        // Buscar config y crearla si no existe
        $homeConfig = HomeConfig::first();

        // Validar los datos antes de actualizar
        $validated = $request->validate([
            'titulo'       => 'nullable|string|max:255',
            'subtitulo'    => 'nullable|string',
            'texto_boton'  => 'nullable|string|max:100',
            'link_boton'   => 'nullable|string|max:255',
            'imagen_banner'=> 'nullable|string|max:255',
        ]);

        // Si no existe el registro, lo creamos
        if (!$homeConfig) {
            HomeConfig::create($validated);
        } else {
            $homeConfig->update($validated);
        }

        return redirect()->route('admin.home.editor')
            ->with('success', 'Página actualizada correctamente');
    }
}
