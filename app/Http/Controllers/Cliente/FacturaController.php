<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Factura;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{
    // Mostrar listado de facturas
    public function index(Request $request)
    {
        $query = Factura::where('user_id', auth()->id())
            ->with(['reserva.viaje.origen', 'reserva.viaje.destino', 'reserva.asiento', 'user'])
            ->whereHas('reserva', function($q) {
                $q->where('estado', 'confirmada')
                    ->where('pagado', true);
            })
            ->orderBy('fecha_emision', 'desc');

        // Filtro: Número de Factura
        if ($request->filled('numero')) {
            $query->where('numero_factura', 'like', '%' . $request->numero . '%');
        }

        // Filtro: Fecha Desde
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_emision', '>=', $request->fecha_desde);
        }

        // Filtro: Fecha Hasta
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_emision', '<=', $request->fecha_hasta);
        }

        // Filtro: Estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $facturas = $query->paginate(10);

        return view('cliente.facturas.index', compact('facturas'));
    }

    // Ver detalles de una factura
    public function show($id)
    {
        $factura = Factura::where('user_id', auth()->id())
            ->with(['reserva.viaje.origen', 'reserva.viaje.destino', 'reserva.asiento', 'user'])
            ->findOrFail($id);

        return view('cliente.facturas.show', compact('factura'));
    }

    // Descargar factura en PDF
    public function descargarPDF($id)
    {
        $factura = Factura::where('user_id', auth()->id())
            ->with(['reserva.viaje.origen', 'reserva.viaje.destino', 'reserva.asiento', 'user'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('cliente.facturas.pdf', compact('factura'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Factura-' . $factura->numero_factura . '.pdf');
    }

    // Enviar factura por correo
    public function enviarEmail($id)
    {
        $factura = Factura::where('user_id', auth()->id())
            ->with(['reserva', 'user'])
            ->findOrFail($id);

        try {
            $pdf = Pdf::loadView('cliente.facturas.pdf', compact('factura'));

            \Mail::send([], [], function($message) use ($factura, $pdf) {
                $message->to($factura->user->email)
                    ->subject('Factura ' . $factura->numero_factura . ' - BUSTRAK')
                    ->html('<p>Adjunto encontrarás tu factura.</p>')
                    ->attachData($pdf->output(), 'Factura-' . $factura->numero_factura . '.pdf');
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error al enviar factura: ' . $e->getMessage());
            return response()->json(['success' => false]);
        }
    }

    // Crear factura automáticamente cuando se confirma pago
    public static function crearFactura(Reserva $reserva)
    {
        try {
            $factura = Factura::create([
                'numero_factura' => Factura::generarNumeroFactura(),
                'reserva_id' => $reserva->id,
                'user_id' => $reserva->user_id,
                'fecha_emision' => now(),
                'subtotal' => $reserva->viaje->precio,
                'impuestos' => round($reserva->viaje->precio * 0.15, 2),
                'cargos_adicionales' => 0,
                'monto_total' => $reserva->viaje->precio + round($reserva->viaje->precio * 0.15, 2),
                'metodo_pago' => 'transferencia',
                'estado' => 'emitida',
                'detalles' => 'Factura generada por pago de reserva'
            ]);

            // Notificar al usuario
            self::notificarFacturaDisponible($factura);

            return $factura;
        } catch (\Exception $e) {
            \Log::error('Error al crear factura: ' . $e->getMessage());
            return null;
        }
    }

    // Notificar cuando factura está disponible
    private static function notificarFacturaDisponible($factura)
    {
        try {
            $usuario = $factura->user;

            // Aquí puedes enviar una notificación por email, SMS, o guardarlo en BD
            \Log::info('Factura disponible para usuario: ' . $usuario->email);

            // Opcional: Crear notificación en base de datos
            // Notification::send($usuario, new FacturaDisponibleNotification($factura));
        } catch (\Exception $e) {
            \Log::error('Error al notificar: ' . $e->getMessage());
        }
    }

    // Validar autenticidad del QR (endpoint para verificar)
    public function verificarAutenticidad($numeroFactura)
    {
        $factura = Factura::where('numero_factura', $numeroFactura)->first();

        if (!$factura) {
            return response()->json(['valida' => false, 'mensaje' => 'Factura no encontrada']);
        }

        return response()->json([
            'valida' => true,
            'numero_factura' => $factura->numero_factura,
            'fecha_emision' => $factura->fecha_emision->format('d/m/Y H:i'),
            'monto' => 'L. ' . number_format($factura->monto_total, 2),
            'estado' => $factura->estado,
            'cliente' => $factura->user->name
        ]);
    }
}
