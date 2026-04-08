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

        SolicitudEmpleo::create([
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
        // Cambiado de ->get() a ->paginate(10) para habilitar paginación
        $solicitudes = SolicitudEmpleo::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('solicitudes.index-empleo', compact('solicitudes'));
    }

    public function indexAdmin(Request $request)
    {
        if (auth()->user()->role !== 'Administrador') {
            abort(403, 'Acceso denegado');
        }

        $query = SolicitudEmpleo::query();

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('puesto')) {
            $query->where('puesto_deseado', 'like', '%' . $request->puesto . '%')
                ->orWhere('nombre_completo', 'like', '%' . $request->puesto . '%');
        }

        $solicitudes = $query->latest()->paginate(15); // Paginación para admin

        return view('admin.solicitudes_empleo.index', compact('solicitudes'));
    }

    public function show($id)
    {
        if (auth()->user()->role !== 'Administrador') {
            abort(403, 'Acceso denegado');
        }

        $solicitud = SolicitudEmpleo::findOrFail($id);

        return view('admin.solicitudes_empleo.show', compact('solicitud'));
    }
}
