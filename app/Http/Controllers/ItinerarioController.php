<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\VisualizacionItinerario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class ItinerarioController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        // Traer todas las reservas del usuario con su viaje y asiento
        $reservas = Reserva::with(['viaje.origen', 'viaje.destino', 'asiento'])
            ->where('user_id', $usuario->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Todas las ciudades para los selects de origen/destino
        $ciudades = \App\Models\Ciudad::all();

        // Todos los asientos para los selects de edición
        $asientos = \App\Models\Asiento::all();

        return view('itinerario.index', compact('usuario', 'reservas', 'ciudades', 'asientos'));
    }


    public function descargarPDF()
    {
        $usuario = Auth::user();

        $reservas = Reserva::with(['viaje.origen', 'viaje.destino', 'asiento'])
            ->where('user_id', $usuario->id)
            ->get();

        $fecha_generacion = Carbon::now();

        // Cargar el logo
        $logoPath = public_path('imagenes/bustrak-logo.jpg');
        $logoBase64 = null;

        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoBase64 = 'data:image/jpg;base64,' . $logoData;
        }

        $qrCodes = [];
        foreach ($reservas as $reserva) {
            $qrCode = new QrCode($reserva->codigo_reserva);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            $qrCodes[$reserva->id] = $result->getDataUri();
        }

        VisualizacionItinerario::create([
            'usuario_id' => $usuario->id,
            'reserva_id' => $reservas->first()?->id,
            'fecha_hora_visualizacion' => now(),
            'dispositivo' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
            'navegador' => $this->detectarNavegador(request()->header('User-Agent')),
        ]);

        $pdf = Pdf::loadView('itinerario.pdf', compact('usuario', 'reservas', 'fecha_generacion', 'qrCodes', 'logoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-local-file-access', true);

        return response()->streamDownload(
            function() use ($pdf) {
                echo $pdf->output();
            },
            'Itinerario_' . $usuario->name . '.pdf',
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Itinerario_' . $usuario->name . '.pdf"'
            ]
        );
    }

    public function descargarCompartido($id)
    {
        $reserva = Reserva::with(['user', 'viaje.origen', 'viaje.destino', 'asiento'])->find($id);

        if (!$reserva) {
            abort(404, 'Reserva de itinerario no encontrada.');
        }

        $usuario = $reserva->user;
        $reservas = collect([$reserva]);
        $fecha_generacion = Carbon::now();

        // Cargar el logo
        $logoPath = public_path('imagenes/bustrak-logo.jpg');
        $logoBase64 = null;

        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoBase64 = 'data:image/jpg;base64,' . $logoData;
        }

        // Generar QR Code
        $qrCode = new QrCode($reserva->codigo_reserva);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $qrCodes = [$reserva->id => $result->getDataUri()];

        VisualizacionItinerario::create([
            'usuario_id' => $usuario->id,
            'reserva_id' => $reserva->id,
            'fecha_hora_visualizacion' => now(),
            'dispositivo' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
            'navegador' => $this->detectarNavegador(request()->header('User-Agent')),
        ]);

        $pdf = Pdf::loadView('itinerario.pdf', compact('usuario', 'reservas', 'fecha_generacion', 'qrCodes', 'logoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable-local-file-access', true);

        return response()->streamDownload(
            function() use ($pdf) {
                echo $pdf->output();
            },
            'Itinerario_Compartido_' . ($reserva->codigo_reserva ?? $reserva->id) . '.pdf',
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Itinerario_Compartido_' . ($reserva->codigo_reserva ?? $reserva->id) . '.pdf"'
            ]
        );
    }

    private function detectarNavegador($userAgent)
    {
        $userAgent = strtolower($userAgent);

        if (strpos($userAgent, 'chrome') !== false) {
            return 'Google Chrome';
        } elseif (strpos($userAgent, 'firefox') !== false) {
            return 'Mozilla Firefox';
        } elseif (strpos($userAgent, 'safari') !== false && strpos($userAgent, 'chrome') === false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'edge') !== false) {
            return 'Microsoft Edge';
        } elseif (strpos($userAgent, 'opera') !== false || strpos($userAgent, 'opr/') !== false) {
            return 'Opera';
        }
        return 'Desconocido';
    }

    // ✅ DESCOMENTA ESTE MÉTODO
    public function compartir($id)
    {
        $reserva = Reserva::with(['user', 'viaje.origen', 'viaje.destino', 'asiento'])->find($id);

        if (!$reserva) {
            abort(404, 'Reserva no encontrada');
        }

        $url = route('itinerario.pdf.compartido', $id);

        return view('itinerario.compartir', compact('reserva', 'url'));
    }
}
