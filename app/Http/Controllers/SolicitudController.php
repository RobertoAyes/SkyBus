<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Notifications\ConstanciaDisponible;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        // Admin ve TODAS las solicitudes
        $solicitudes = Solicitud::with('user')
            ->when($request->nombre, function ($q, $nombre) {
                // Búsqueda exacta e insensible a mayúsculas/minúsculas
                return $q->whereRaw('LOWER(nombre) like ?', ['%' . strtolower($nombre) . '%']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('solicitudes.index', compact('solicitudes'));
    }

    public function create()
    {
        return view('solicitudes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'dni' => 'required|string|min:8|max:20',
            'motivo' => 'required|string|min:10|max:500',
            'fecha_entrega' => 'required|date|after:today',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.min' => 'El DNI debe tener al menos 8 caracteres.',
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.min' => 'El motivo debe tener al menos 10 caracteres.',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria.',
            'fecha_entrega.after' => 'La fecha de entrega debe ser posterior a hoy.',
        ]);

        Solicitud::create([
            'user_id' => auth()->id(),
            'nombre' => $request->nombre,
            'dni' => $request->dni,
            'motivo' => $request->motivo,
            'fecha_entrega' => $request->fecha_entrega,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud creada exitosamente.');
    }

    public function procesar(Solicitud $solicitud, Request $request)
    {
        $request->validate([
            'estado' => 'required|in:procesada,rechazada'
        ]);

        $solicitud->update([
            'estado' => $request->estado,
            'fecha_procesamiento' => now(),
        ]);

        // Enviar notificación si fue procesada
        if ($request->estado === 'procesada') {
            $solicitud->user->notify(new ConstanciaDisponible($solicitud));
        }

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud procesada correctamente.');
    }
}
