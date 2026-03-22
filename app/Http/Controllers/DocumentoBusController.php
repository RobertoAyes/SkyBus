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
            $query->where(function ($q) use ($search) {
                $q->where('numero_documento', 'like', "%{$search}%")
                    ->orWhereHas('bus', function ($busQuery) use ($search) {
                        $busQuery->where('placa', 'like', "%{$search}%")
                            ->orWhere('numero_bus', 'like', "%{$search}%");
                    });
            });
        }
        if ($request->filled('fecha_emision')) {
            $query->whereDate('fecha_emision', $request->fecha_emision);
        }

        $documentos = $query->orderBy('fecha_vencimiento', 'asc')
            ->paginate(5)
            ->appends($request->all());

        $estadisticas = [
            'total'      => DocumentoBus::count(),
            'vigentes'   => DocumentoBus::vigentes()->count(),
            'por_vencer' => DocumentoBus::porVencer()->count(),
            'vencidos'   => DocumentoBus::vencidos()->count(),
        ];

        $buses = Bus::all();

        return view('documentos-buses.index', compact('documentos', 'estadisticas', 'buses'));
    }

    /**
     * Muestra el formulario para crear un nuevo documento (página completa — ya no se usa)
     */
    public function create()
    {
        $buses = Bus::all();
        $tiposDocumento = [
            'permiso_operacion' => 'Permiso de Operación',
            'revision_tecnica'  => 'Revisión Técnica',
            'seguro_vehicular'  => 'Seguro Vehicular',
            'matricula'         => 'Matrícula',
        ];

        return view('documentos-buses.create', compact('buses', 'tiposDocumento'));
    }

    /**
     * Almacena un nuevo documento
     */
    public function store(Request $request)
    {
        $request->validate([
            'bus_id'           => 'required|exists:buses,id',
            'tipo_documento'   => 'required|in:permiso_operacion,revision_tecnica,seguro_vehicular,matricula',
            'numero_documento' => 'required|string|max:100',
            'fecha_emision'    => 'required|date|before_or_equal:today',
            'fecha_vencimiento'=> 'required|date|after:fecha_emision',
            'archivo'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'observaciones'    => 'nullable|string|max:500',
        ], [
            'bus_id.required'              => 'Debe seleccionar un bus',
            'bus_id.exists'                => 'El bus seleccionado no existe',
            'tipo_documento.required'      => 'Debe seleccionar el tipo de documento',
            'numero_documento.required'    => 'El número de documento es obligatorio',
            'fecha_emision.required'       => 'La fecha de emisión es obligatoria',
            'fecha_emision.before_or_equal'=> 'La fecha de emisión no puede ser futura',
            'fecha_vencimiento.required'   => 'La fecha de vencimiento es obligatoria',
            'fecha_vencimiento.after'      => 'La fecha de vencimiento debe ser posterior a la fecha de emisión',
            'archivo.mimes'                => 'El archivo debe ser PDF, JPG, JPEG o PNG',
            'archivo.max'                  => 'El archivo no debe superar 5MB',
        ]);

        $documento = new DocumentoBus($request->except('archivo'));

        if ($request->hasFile('archivo')) {
            $archivo      = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $ruta          = $archivo->storeAs('documentos-buses', $nombreArchivo, 'public');
            $documento->archivo_url = $ruta;
        }

        $documento->save();

        return redirect()->route('documentos-buses.index')
            ->with('success', 'Documento registrado exitosamente');
    }

    /**
     * Muestra los detalles de un documento (página completa — se mantiene por compatibilidad)
     */
    public function show($id)
    {
        $documento = DocumentoBus::with([
            'bus',
            'registradoPor',
            'historial.usuario',
        ])->findOrFail($id);

        return view('documentos-buses.show', compact('documento'));
    }

    /**
     * Retorna el HTML parcial para el MODAL de detalles (sin layout).
     * Ruta sugerida: GET /documentos-buses/{id}/detalle-modal
     */
    public function showModal($id)
    {
        $documento = DocumentoBus::with([
            'bus',
            'registradoPor',
            'historial.usuario',
        ])->findOrFail($id);

        // Retorna la vista parcial sin el layout de administración
        return view('documentos-buses.show-modal', compact('documento'));
    }

    /**
     * Muestra el formulario de edición (página completa — se mantiene por compatibilidad)
     */
    public function edit($id)
    {
        $documento = DocumentoBus::findOrFail($id);
        $buses     = Bus::all();
        $tiposDocumento = [
            'permiso_operacion' => 'Permiso de Operación',
            'revision_tecnica'  => 'Revisión Técnica',
            'seguro_vehicular'  => 'Seguro Vehicular',
            'matricula'         => 'Matrícula',
        ];

        return view('documentos-buses.Editar', compact('documento', 'buses', 'tiposDocumento'));
    }

    /**
     * Retorna el HTML parcial para el MODAL de edición (sin layout).
     * Ruta sugerida: GET /documentos-buses/{id}/editar-modal
     */
    public function editModal($id)
    {
        $documento = DocumentoBus::with(['bus', 'historial.usuario'])->findOrFail($id);
        $buses     = Bus::all();
        $tiposDocumento = [
            'permiso_operacion' => 'Permiso de Operación',
            'revision_tecnica'  => 'Revisión Técnica',
            'seguro_vehicular'  => 'Seguro Vehicular',
            'matricula'         => 'Matrícula',
        ];

        // Retorna la vista parcial sin el layout de administración
        return view('documentos-buses.edit-modal', compact('documento', 'buses', 'tiposDocumento'));
    }

    /**
     * Actualiza un documento existente
     */
    public function update(Request $request, $id)
    {
        $documento = DocumentoBus::findOrFail($id);

        $request->validate([
            'bus_id'           => 'required|exists:buses,id',
            'tipo_documento'   => 'required|in:permiso_operacion,revision_tecnica,seguro_vehicular,matricula',
            'numero_documento' => 'required|string|max:100',
            'fecha_emision'    => 'required|date|before_or_equal:today',
            'fecha_vencimiento'=> 'required|date|after:fecha_emision',
            'archivo'          => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'observaciones'    => 'nullable|string|max:500',
        ]);

        $documento->fill($request->except('archivo'));

        if ($request->hasFile('archivo')) {
            if ($documento->archivo_url && Storage::disk('public')->exists($documento->archivo_url)) {
                Storage::disk('public')->delete($documento->archivo_url);
            }

            $archivo       = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $ruta          = $archivo->storeAs('documentos-buses', $nombreArchivo, 'public');
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
            'total'      => DocumentoBus::count(),
            'vigentes'   => DocumentoBus::vigentes()->count(),
            'por_vencer' => DocumentoBus::porVencer()->count(),
            'vencidos'   => DocumentoBus::vencidos()->count(),
        ];

        $proximosVencer = DocumentoBus::with(['bus'])
            ->porVencer()
            ->orderBy('fecha_vencimiento', 'asc')
            ->take(10)
            ->get();

        $vencidos = DocumentoBus::with(['bus'])
            ->vencidos()
            ->orderBy('fecha_vencimiento', 'desc')
            ->take(10)
            ->get();

        $busesAlerta = Bus::whereHas('documentos', function ($query) {
            $query->where('estado', '!=', 'vigente');
        })->with(['documentos' => function ($query) {
            $query->where('estado', '!=', 'vigente');
        }])->get();

        return view('documentos-buses.dashboard', compact(
            'estadisticas', 'proximosVencer', 'vencidos', 'busesAlerta'
        ));
    }

    /**
     * Actualiza todos los estados de documentos
     */
    public function actualizarEstados()
    {
        $documentos  = DocumentoBus::all();
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
            'total'      => DocumentoBus::count(),
            'vigentes'   => DocumentoBus::vigentes()->count(),
            'por_vencer' => DocumentoBus::porVencer()->count(),
            'vencidos'   => DocumentoBus::vencidos()->count(),
        ];

        $pdf = \PDF::loadView('documentos-buses.pdf', compact('documentos', 'estadisticas'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Reporte_Documentos_Buses_' . now()->format('Y-m-d') . '.pdf');
    }
    /**
     * Verifica si el documento está vencido
     */
    public function estaVencido(): bool
    {
        return $this->fecha_vencimiento->isPast();
    }

    /**
     * Verifica si el documento está próximo a vencer (menos de 30 días)
     */
    public function estaPorVencer(): bool
    {
        if ($this->estaVencido()) return false;
        return $this->fecha_vencimiento->diffInDays(now()) <= 30;
    }

    /**
     * Días hasta el vencimiento (negativo si ya venció)
     */
    public function getDiasHastaVencimientoAttribute(): int
    {
        return (int) now()->diffInDays($this->fecha_vencimiento, false);
    }

    /**
     * Nombre legible del tipo de documento
     */
    public function getTipoDocumentoNombreAttribute(): string
    {
        $tipos = [
            'permiso_operacion' => 'Permiso de Operación',
            'revision_tecnica'  => 'Revisión Técnica',
            'seguro_vehicular'  => 'Seguro Vehicular',
            'matricula'         => 'Matrícula',
        ];
        return $tipos[$this->tipo_documento] ?? $this->tipo_documento;
    }

    /**
     * Badge HTML del estado
     */
    public function getEstadoBadgeAttribute(): string
    {
        return match($this->estado) {
            'vigente'    => '<span class="badge bg-success">Vigente</span>',
            'por_vencer' => '<span class="badge bg-warning text-dark">Por Vencer</span>',
            'vencido'    => '<span class="badge bg-danger">Vencido</span>',
            default      => '<span class="badge bg-secondary">Desconocido</span>',
        };
    }

    /**
     * Actualiza el estado según la fecha de vencimiento
     */
    public function actualizarEstado(): void
    {
        if ($this->estaVencido()) {
            $this->estado = 'vencido';
        } elseif ($this->estaPorVencer()) {
            $this->estado = 'por_vencer';
        } else {
            $this->estado = 'vigente';
        }
    }

    /**
     * Color Bootstrap según estado (para alertas)
     */
    public function getColorEstado(): string
    {
        return match($this->estado) {
            'vencido'    => 'danger',
            'por_vencer' => 'warning',
            default      => 'success',
        };
    }

    /**
     * Ícono FontAwesome según estado
     */
    public function getIconoEstado(): string
    {
        return match($this->estado) {
            'vencido'    => 'fa-times-circle',
            'por_vencer' => 'fa-exclamation-triangle',
            default      => 'fa-check-circle',
        };
    }


    public function documentoVigentes($query)
    {
        return $query->where('estado', 'vigente');
    }

    public function documentoPorVencer($query)
    {
        return $query->where('estado', 'por_vencer');
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', 'vencido');
    }
}
