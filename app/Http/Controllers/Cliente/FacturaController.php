<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FacturaController extends Controller
{
    /* =========================
       LISTADO
    ========================= */
    public function index(Request $request)
    {
        $query = Factura::with([
            'reserva.viaje.ruta',
            'reserva.asiento',
            'user'
        ])
            ->whereHas('reserva', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->orderBy('fecha_emision', 'desc');

        if ($request->filled('numero')) {
            $query->where('numero_factura', 'like', "%{$request->numero}%");
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_emision', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_emision', '<=', $request->fecha_hasta);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $facturas = $query->paginate(10);

        return view('cliente.facturas.index', compact('facturas'));
    }

    /* =========================
       DETALLE
    ========================= */
    public function show($id)
    {
        $factura = Factura::with([
            'reserva.viaje.ruta',
            'reserva.asiento',
            'user'
        ])
            ->whereHas('reserva', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->findOrFail($id);

        return view('cliente.facturas.show', compact('factura'));
    }

    /* =========================
       PDF
    ========================= */
    public function descargarPDF($id)
    {
        $factura = Factura::with([
            'reserva.viaje.ruta',
            'reserva.asiento',
            'user'
        ])
            ->whereHas('reserva', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->findOrFail($id);

        $pdf = Pdf::loadView('cliente.facturas.pdf', compact('factura'));

        return $pdf->download("Factura-{$factura->numero_factura}.pdf");
    }

    /* =========================
       EMAIL
    ========================= */
    public function enviarEmail($id)
    {
        $factura = Factura::with([
            'reserva.viaje.ruta',
            'reserva.asiento',
            'user'
        ])
            ->whereHas('reserva', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->findOrFail($id);

        try {
            $pdf = Pdf::loadView('cliente.facturas.pdf', compact('factura'));

            Mail::send([], [], function ($message) use ($factura, $pdf) {
                $message->to($factura->user->email)
                    ->subject("Factura {$factura->numero_factura}")
                    ->html('<p>Adjunto tu factura.</p>')
                    ->attachData($pdf->output(), "Factura-{$factura->numero_factura}.pdf");
            });

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {
            Log::error('Email factura error: ' . $e->getMessage());
            return response()->json(['success' => false]);
        }
    }

    /* =========================
       CREAR FACTURA (CORRECTO)
    ========================= */
    public static function crearFactura(Reserva $reserva)
    {
        try {
            // evitar duplicados
            if (Factura::where('reserva_id', $reserva->id)->exists()) {
                return null;
            }

            $reserva->load('viaje');

            $precio = $reserva->viaje->precio ?? 0;
            $impuesto = round($precio * 0.15, 2);

            return Factura::create([
                'numero_factura' => 'FAC-' . now()->format('YmdHis'),
                'reserva_id' => $reserva->id,
                'user_id' => $reserva->user_id,
                'fecha_emision' => now(),
                'subtotal' => $precio,
                'impuestos' => $impuesto,
                'cargos_adicionales' => 0,
                'monto_total' => $precio + $impuesto,
                'metodo_pago' => 'transferencia',
                'estado' => 'emitida',
                'detalles' => 'Factura generada automáticamente'
            ]);

        } catch (\Throwable $e) {
            Log::error('Error factura: ' . $e->getMessage());
            return null;
        }
    }

    /* =========================
       VALIDAR QR
    ========================= */
    public function verificarAutenticidad($numeroFactura)
    {
        $factura = Factura::with('user')
            ->where('numero_factura', $numeroFactura)
            ->first();

        if (!$factura) {
            return response()->json([
                'valida' => false,
                'mensaje' => 'No encontrada'
            ]);
        }

        return response()->json([
            'valida' => true,
            'numero_factura' => $factura->numero_factura,
            'fecha_emision' => optional($factura->fecha_emision)->format('d/m/Y H:i'),
            'monto' => 'L. ' . number_format($factura->monto_total, 2),
            'estado' => $factura->estado,
            'cliente' => $factura->user->name ?? 'N/A'
        ]);
    }
}
