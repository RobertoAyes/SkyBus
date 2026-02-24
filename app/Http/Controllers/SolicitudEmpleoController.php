<?php

namespace App\Http\Controllers;

use App\Models\SolicitudEmpleo;
use Illuminate\Http\Request;

class SolicitudEmpleoController extends Controller
{
    public function create()
    {
        return view('solicitudes.empleo');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|min:3|max:255',
            'contacto' => 'required|email',
            'puesto_deseado' => 'required|string|max:255',
            'experiencia_laboral' => 'required|string|min:10',
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
        ], [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'contacto.required' => 'El correo es obligatorio.',
            'contacto.email' => 'Debe ser un correo válido.',
            'puesto_deseado.required' => 'El puesto deseado es obligatorio.',
            'experiencia_laboral.required' => 'La experiencia laboral es obligatoria.',
            'cv.required' => 'Debe adjuntar un CV.',
            'cv.mimes' => 'El CV debe ser PDF, DOC o DOCX.',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('solicitudes-empleo', 'public');
        }

        $solicitud = SolicitudEmpleo::create([
            'user_id' => auth()->id(),
            'nombre_completo' => $request->nombre_completo,
            'contacto' => $request->contacto,
            'puesto_deseado' => $request->puesto_deseado,
            'experiencia_laboral' => $request->experiencia_laboral,
            'cv' => $cvPath,
        ]);

        return redirect()->route('solicitud.empleo.mis-solicitudes')
            ->with('success', '✅ ¡Solicitud de empleo enviada correctamente! Pronto nos pondremos en contacto contigo.');
    }

    public function misSolicitudes()
    {
        $solicitudes = SolicitudEmpleo::where('user_id', auth()->id())->latest()->get();
        return view('solicitudes.index-empleo', compact('solicitudes'));
    }

    public function indexAdmin(Request $request)
    {
        // Verificamos que el usuario sea administrador
        if (auth()->user()->role !== 'Administrador') {
            abort(403, 'Acceso denegado');
        }

        // Creamos una consulta base a la tabla solicitudes_empleo
        $query = SolicitudEmpleo::query();

        // Filtro por estado (pendiente, en_proceso, atendida)
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por puesto deseado
        if ($request->filled('puesto')) {
            // Busca coincidencias parciales en el nombre del puesto
            $query->where('puesto_deseado', 'like', '%' . $request->puesto . '%');
        }

        // Traemos las solicitudes ordenadas por más reciente
        $solicitudes = $query->latest()->get();

        // Enviamos las solicitudes a la vista
        return view('admin.solicitudes_empleo.index', compact('solicitudes'));
    }

    public function show($id)
    {
        // Verificamos que el usuario sea administrador
        if (auth()->user()->role !== 'Administrador') {
            abort(403, 'Acceso denegado');
        }

        // Buscamos la solicitud por su ID
        $solicitud = SolicitudEmpleo::findOrFail($id);

        // Retornamos la vista de detalle
        return view('admin.solicitudes_empleo.show', compact('solicitud'));
    }
}
