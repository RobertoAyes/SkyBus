<?php

namespace App\Http\Controllers;

use App\Models\DocumentoBus;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DocumentoBusController extends Controller
{
    /**
     * Muestra el listado de documentos de buses
     */
    public function index(Request $request)
    {
        $query = DocumentoBus::with(['bus', 'registradoPor']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_documento')) {
            $query->where('tipo_documento', $request->tipo_documento);
        }

        if ($request->filled('bus_id')) {
            $query->where('bus_id', $request->bus_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_documento', 'like', "%{$search}%")
                    ->orWhereHas('bus', function($busQuery) use ($search) {
                        $busQuery->where('placa', 'like', "%{$search}%")
                            ->orWhere('numero_bus', 'like', "%{$search}%");
                    });
            });
        }

        $documentos = $query->orderBy('fecha_vencimiento', 'asc')
            ->paginate(15)
            ->appends($request->all());

        // Estadísticas del dashboard
        $estadisticas = [
            'total' => DocumentoBus::count(),
            'vigentes' => DocumentoBus::vigentes()->count(),
            'por_vencer' => DocumentoBus::porVencer()->count(),
            'vencidos' => DocumentoBus::vencidos()->count(),
        ];

        $buses = Bus::all();

        return view('documentos-buses.index', compact('documentos', 'estadisticas', 'buses'));
    }

    /**
     * Muestra el formulario para crear un nuevo documento
     */
    public function create()
    {
        $buses = Bus::all();
        $tiposDocumento = [
            'permiso_operacion' => 'Permiso de Operación',
            'revision_tecnica' => 'Revisión Técnica',
            'seguro_vehicular' => 'Seguro Vehicular',
            'matricula' => 'Matrícula',
        ];

        return view('documentos-buses.create', compact('buses', 'tiposDocumento'));
    }

    /**
     * Almacena un nuevo documento
     */
    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'tipo_documento' => 'required|in:permiso_operacion,revision_tecnica,seguro_vehicular,matricula',
            'numero_documento' => 'required|string|max:100',
            'fecha_emision' => 'required|date|before_or_equal:today',
            'fecha_vencimiento' => 'required|date|after:fecha_emision',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB máximo
            'observaciones' => 'nullable|string|max:500',
        ], [
            'bus_id.required' => 'Debe seleccionar un bus',
            'bus_id.exists' => 'El bus seleccionado no existe',
            'tipo_documento.required' => 'Debe seleccionar el tipo de documento',
            'numero_documento.required' => 'El número de documento es obligatorio',
            'fecha_emision.required' => 'La fecha de emisión es obligatoria',
            'fecha_emision.before_or_equal' => 'La fecha de emisión no puede ser futura',
            'fecha_vencimiento.required' => 'La fecha de vencimiento es obligatoria',
            'fecha_vencimiento.after' => 'La fecha de vencimiento debe ser posterior a la fecha de emisión',
            'archivo.mimes' => 'El archivo debe ser PDF, JPG, JPEG o PNG',
            'archivo.max' => 'El archivo no debe superar 5MB',
        ]);

        $documento = new DocumentoBus($request->except('archivo'));

        // Subir archivo si existe
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $ruta = $archivo->storeAs('documentos-buses', $nombreArchivo, 'public');
            $documento->archivo_url = $ruta;
        }

        $documento->save();

        return redirect()->route('documentos-buses.index')
            ->with('success', 'Documento registrado exitosamente');
    }

    /**
     * Muestra los detalles de un documento específico
     */
    public function show($id)
    {
        $documento = DocumentoBus::with([
            'bus',
            'registradoPor',
            'historial.usuario'
        ])->findOrFail($id);

        return view('documentos-buses.show', compact('documento'));
    }

    /**
     * Muestra el formulario para editar un documento
     */
    public function edit($id)
    {
        $documento = DocumentoBus::findOrFail($id);
        $buses = Bus::all();
        $tiposDocumento = [
            'permiso_operacion' => 'Permiso de Operación',
            'revision_tecnica' => 'Revisión Técnica',
            'seguro_vehicular' => 'Seguro Vehicular',
            'matricula' => 'Matrícula',
        ];

        return view('documentos-buses.Editar', compact('documento', 'buses', 'tiposDocumento'));
    }

    /**
     * Actualiza un documento existente
     */
    public function update(Request $request, $id)
    {
        $documento = DocumentoBus::findOrFail($id);

        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'tipo_documento' => 'required|in:permiso_operacion,revision_tecnica,seguro_vehicular,matricula',
            'numero_documento' => 'required|string|max:100',
            'fecha_emision' => 'required|date|before_or_equal:today',
            'fecha_vencimiento' => 'required|date|after:fecha_emision',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $documento->fill($request->except('archivo'));

        // Actualizar archivo si se subió uno nuevo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($documento->archivo_url && Storage::disk('public')->exists($documento->archivo_url)) {
                Storage::disk('public')->delete($documento->archivo_url);
            }

            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $ruta = $archivo->storeAs('documentos-buses', $nombreArchivo, 'public');
            $documento->archivo_url = $ruta;
        }

        $documento->actualizarEstado();
        $documento->save();

        return redirect()->route('documentos-buses.index')
            ->with('success', 'Documento actualizado exitosamente');
    }

    /**
     * Elimina un documento
     */
    public function destroy($id)
    {
        $documento = DocumentoBus::findOrFail($id);

        // Eliminar archivo asociado
        if ($documento->archivo_url && Storage::disk('public')->exists($documento->archivo_url)) {
            Storage::disk('public')->delete($documento->archivo_url);
        }

        $documento->delete();

        return redirect()->route('documentos-buses.index')
            ->with('success', 'Documento eliminado exitosamente');
    }

    /**
     * Descarga el archivo del documento
     */
    public function descargarArchivo($id)
    {
        $documento = DocumentoBus::findOrFail($id);

        if (!$documento->archivo_url || !Storage::disk('public')->exists($documento->archivo_url)) {
            return redirect()->back()->with('error', 'El archivo no está disponible');
        }

        return Storage::disk('public')->download($documento->archivo_url);
    }

    /**
     * Dashboard con estadísticas y alertas
     */
    public function dashboard()
    {
        $estadisticas = [
            'total' => DocumentoBus::count(),
            'vigentes' => DocumentoBus::vigentes()->count(),
            'por_vencer' => DocumentoBus::porVencer()->count(),
            'vencidos' => DocumentoBus::vencidos()->count(),
        ];

        // Documentos próximos a vencer (30 días)
        $proximosVencer = DocumentoBus::with(['bus'])
            ->porVencer()
            ->orderBy('fecha_vencimiento', 'asc')
            ->take(10)
            ->get();

        // Documentos vencidos
        $vencidos = DocumentoBus::with(['bus'])
            ->vencidos()
            ->orderBy('fecha_vencimiento', 'desc')
            ->take(10)
            ->get();

        // Buses con documentos pendientes
        $busesAlerta = Bus::whereHas('documentos', function($query) {
            $query->where('estado', '!=', 'vigente');
        })->with(['documentos' => function($query) {
            $query->where('estado', '!=', 'vigente');
        }])->get();

        return view('documentos-buses.dashboard', compact(
            'estadisticas',
            'proximosVencer',
            'vencidos',
            'busesAlerta'
        ));
    }

    /**
     * Actualiza todos los estados de documentos
     */
    public function actualizarEstados()
    {
        $documentos = DocumentoBus::all();
        $actualizados = 0;

        foreach ($documentos as $documento) {
            $estadoAnterior = $documento->estado;
            $documento->actualizarEstado();

            if ($estadoAnterior !== $documento->estado) {
                $actualizados++;
            }
        }

        return redirect()->back()
            ->with('success', "Se actualizaron {$actualizados} documentos");
    }

    /**
     * API - Obtiene documentos por bus
     */
    public function porBus($busId)
    {
        $documentos = DocumentoBus::where('bus_id', $busId)
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        return response()->json($documentos);
    }

    /**
     * Exportar reporte de documentos en PDF
     */
    public function exportarPDF()
    {
        $documentos = DocumentoBus::with(['bus', 'registradoPor'])
            ->orderBy('estado', 'desc')
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        $estadisticas = [
            'total' => DocumentoBus::count(),
            'vigentes' => DocumentoBus::vigentes()->count(),
            'por_vencer' => DocumentoBus::porVencer()->count(),
            'vencidos' => DocumentoBus::vencidos()->count(),
        ];

        $pdf = \PDF::loadView('documentos-buses.pdf', compact('documentos', 'estadisticas'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Reporte_Documentos_Buses_' . now()->format('Y-m-d') . '.pdf');
    }
    /**
     * Mostrar vista de detalles para modal
     */
    public function modalShow($id)
    {
        $documento = DocumentoBus::with(['bus', 'registradoPor', 'historial.usuario'])
            ->findOrFail($id);

        // Retornar la misma vista show pero sin el layout
        return view('documentos-buses.show-content', compact('documento'));
    }

    /**
     * Mostrar formulario de edición para modal
     */
    public function modalEdit($id)
    {
        $documento = DocumentoBus::with(['bus', 'historial.usuario'])->findOrFail($id);
        $buses = Bus::all();
        $tiposDocumento = [
            'permiso_operacion' => 'Permiso de Operación',
            'revision_tecnica' => 'Revisión Técnica',
            'seguro_vehicular' => 'Seguro Vehicular',
            'matricula' => 'Matrícula',
        ];

        // Retornar la misma vista edit pero sin el layout
        return view('documentos-buses.edit-content', compact('documento', 'buses', 'tiposDocumento'));
    }
}


