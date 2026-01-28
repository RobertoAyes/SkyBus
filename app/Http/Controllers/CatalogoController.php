<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    // Datos de departamentos con imágenes
    private $departamentos = [
        ['id' => 1, 'nombre' => 'Atlántida', 'color' => '#009B77', 'icono' => '🏝️', 'imagen' => 'atlantida.jpg'],
        ['id' => 2, 'nombre' => 'Colón', 'color' => '#00B894', 'icono' => '🌴', 'imagen' => 'colon.jpg'],
        ['id' => 3, 'nombre' => 'Cortés', 'color' => '#00CEC9', 'icono' => '🏙️', 'imagen' => 'cortes.jpg'],
        ['id' => 4, 'nombre' => 'Copán', 'color' => '#0984E3', 'icono' => '🏛️', 'imagen' => 'copan.jpg'],
        ['id' => 5, 'nombre' => 'Comayagua', 'color' => '#6C5CE7', 'icono' => '⛪', 'imagen' => 'comayagua.jpg'],
        ['id' => 6, 'nombre' => 'Choluteca', 'color' => '#A29BFE', 'icono' => '🌾', 'imagen' => 'choluteca.jpg'],
        ['id' => 7, 'nombre' => 'El Paraíso', 'color' => '#00B894', 'icono' => '🌲', 'imagen' => 'elparaiso.jpg'],
        ['id' => 8, 'nombre' => 'Francisco Morazán', 'color' => '#009B77', 'icono' => '🏛️', 'imagen' => 'francisco.jpg'],
        ['id' => 9, 'nombre' => 'Gracias a Dios', 'color' => '#00CEC9', 'icono' => '🦅', 'imagen' => 'gracias.jpg'],
        ['id' => 10, 'nombre' => 'Intibucá', 'color' => '#0984E3', 'icono' => '⛰️', 'imagen' => 'intibuca.jpg'],
        ['id' => 11, 'nombre' => 'Islas de la Bahía', 'color' => '#6C5CE7', 'icono' => '🏝️', 'imagen' => 'islas.jpg'],
        ['id' => 12, 'nombre' => 'La Paz', 'color' => '#A29BFE', 'icono' => '☮️', 'imagen' => 'lapaz.jpg'],
        ['id' => 13, 'nombre' => 'Lempira', 'color' => '#00B894', 'icono' => '🏞️', 'imagen' => 'lempira.jpg'],
        ['id' => 14, 'nombre' => 'Ocotepeque', 'color' => '#009B77', 'icono' => '🌄', 'imagen' => 'ocotepeque.jpg'],
        ['id' => 15, 'nombre' => 'Olancho', 'color' => '#00CEC9', 'icono' => '🌳', 'imagen' => 'olancho.jpg'],
        ['id' => 16, 'nombre' => 'Santa Bárbara', 'color' => '#0984E3', 'icono' => '❤️', 'imagen' => 'santabarbara.jpg'],
        ['id' => 17, 'nombre' => 'Valle', 'color' => '#00B894', 'icono' => '🌄', 'imagen' => 'valle.jpg'],
        ['id' => 18, 'nombre' => 'Yoro', 'color' => '#0984E3', 'icono' => '🌊', 'imagen' => 'yoro.jpg']
    ];

    // Datos de viajes - TODOS DESDE DANLÍ
    private $viajes = [
        // Danlí → Atlántida
        ['id' => 1, 'origen' => 'Danlí', 'destino' => 'Atlántida', 'fecha' => '2025-02-15', 'horario' => '08:00', 'precio' => 150, 'duracion' => '5 horas'],
        ['id' => 2, 'origen' => 'Danlí', 'destino' => 'Atlántida', 'fecha' => '2025-02-16', 'horario' => '12:00', 'precio' => 150, 'duracion' => '5 horas'],

        // Danlí → Colón
        ['id' => 3, 'origen' => 'Danlí', 'destino' => 'Colón', 'fecha' => '2025-02-17', 'horario' => '06:30', 'precio' => 180, 'duracion' => '6 horas'],
        ['id' => 4, 'origen' => 'Danlí', 'destino' => 'Colón', 'fecha' => '2025-02-18', 'horario' => '14:00', 'precio' => 180, 'duracion' => '6 horas'],

        // Danlí → Cortés
        ['id' => 5, 'origen' => 'Danlí', 'destino' => 'Cortés', 'fecha' => '2025-02-19', 'horario' => '06:00', 'precio' => 200, 'duracion' => '6 horas'],
        ['id' => 6, 'origen' => 'Danlí', 'destino' => 'Cortés', 'fecha' => '2025-02-20', 'horario' => '14:00', 'precio' => 200, 'duracion' => '6 horas'],

        // Danlí → Copán
        ['id' => 7, 'origen' => 'Danlí', 'destino' => 'Copán', 'fecha' => '2025-02-21', 'horario' => '08:30', 'precio' => 250, 'duracion' => '8 horas'],
        ['id' => 8, 'origen' => 'Danlí', 'destino' => 'Copán', 'fecha' => '2025-02-22', 'horario' => '07:00', 'precio' => 250, 'duracion' => '8 horas'],

        // Danlí → Comayagua
        ['id' => 9, 'origen' => 'Danlí', 'destino' => 'Comayagua', 'fecha' => '2025-02-23', 'horario' => '07:00', 'precio' => 120, 'duracion' => '4 horas'],
        ['id' => 10, 'origen' => 'Danlí', 'destino' => 'Comayagua', 'fecha' => '2025-02-24', 'horario' => '09:00', 'precio' => 120, 'duracion' => '4 horas'],

        // Danlí → Choluteca
        ['id' => 11, 'origen' => 'Danlí', 'destino' => 'Choluteca', 'fecha' => '2025-02-25', 'horario' => '09:00', 'precio' => 100, 'duracion' => '3 horas'],
        ['id' => 12, 'origen' => 'Danlí', 'destino' => 'Choluteca', 'fecha' => '2025-02-26', 'horario' => '15:00', 'precio' => 100, 'duracion' => '3 horas'],

        // Danlí → El Paraíso
        ['id' => 13, 'origen' => 'Danlí', 'destino' => 'El Paraíso', 'fecha' => '2025-02-27', 'horario' => '11:00', 'precio' => 80, 'duracion' => '2 horas'],
        ['id' => 14, 'origen' => 'Danlí', 'destino' => 'El Paraíso', 'fecha' => '2025-02-28', 'horario' => '13:00', 'precio' => 80, 'duracion' => '2 horas'],

        // Danlí → Francisco Morazán (Tegucigalpa)
        ['id' => 15, 'origen' => 'Danlí', 'destino' => 'Francisco Morazán', 'fecha' => '2025-03-01', 'horario' => '06:00', 'precio' => 90, 'duracion' => '2.5 horas'],
        ['id' => 16, 'origen' => 'Danlí', 'destino' => 'Francisco Morazán', 'fecha' => '2025-03-02', 'horario' => '10:00', 'precio' => 90, 'duracion' => '2.5 horas'],

        // Danlí → Gracias a Dios
        ['id' => 17, 'origen' => 'Danlí', 'destino' => 'Gracias a Dios', 'fecha' => '2025-03-03', 'horario' => '05:00', 'precio' => 300, 'duracion' => '10 horas'],

        // Danlí → Intibucá
        ['id' => 18, 'origen' => 'Danlí', 'destino' => 'Intibucá', 'fecha' => '2025-03-04', 'horario' => '08:00', 'precio' => 180, 'duracion' => '6 horas'],

        // Danlí → Islas de la Bahía
        ['id' => 19, 'origen' => 'Danlí', 'destino' => 'Islas de la Bahía', 'fecha' => '2025-03-05', 'horario' => '06:00', 'precio' => 350, 'duracion' => '8 horas'],
        ['id' => 20, 'origen' => 'Danlí', 'destino' => 'Islas de la Bahía', 'fecha' => '2025-03-06', 'horario' => '07:00', 'precio' => 350, 'duracion' => '8 horas'],

        // Danlí → La Paz
        ['id' => 21, 'origen' => 'Danlí', 'destino' => 'La Paz', 'fecha' => '2025-03-07', 'horario' => '08:00', 'precio' => 130, 'duracion' => '4 horas'],

        // Danlí → Lempira
        ['id' => 22, 'origen' => 'Danlí', 'destino' => 'Lempira', 'fecha' => '2025-03-08', 'horario' => '09:00', 'precio' => 220, 'duracion' => '7 horas'],

        // Danlí → Ocotepeque
        ['id' => 23, 'origen' => 'Danlí', 'destino' => 'Ocotepeque', 'fecha' => '2025-03-09', 'horario' => '08:30', 'precio' => 280, 'duracion' => '9 horas'],

        // Danlí → Olancho
        ['id' => 24, 'origen' => 'Danlí', 'destino' => 'Olancho', 'fecha' => '2025-03-10', 'horario' => '09:00', 'precio' => 110, 'duracion' => '3 horas'],
        ['id' => 25, 'origen' => 'Danlí', 'destino' => 'Olancho', 'fecha' => '2025-03-11', 'horario' => '14:00', 'precio' => 110, 'duracion' => '3 horas'],

        // Danlí → Santa Bárbara
        ['id' => 26, 'origen' => 'Danlí', 'destino' => 'Santa Bárbara', 'fecha' => '2025-03-12', 'horario' => '10:00', 'precio' => 190, 'duracion' => '6 horas'],

        // Danlí → Valle
        ['id' => 27, 'origen' => 'Danlí', 'destino' => 'Valle', 'fecha' => '2025-03-13', 'horario' => '11:00', 'precio' => 120, 'duracion' => '4 horas'],

        // Danlí → Yoro
        ['id' => 28, 'origen' => 'Danlí', 'destino' => 'Yoro', 'fecha' => '2025-03-14', 'horario' => '13:00', 'precio' => 170, 'duracion' => '5 horas']
    ];

    /**
     * Mostrar el catálogo de viajes
     */
    public function index(Request $request)
    {
        // Origen siempre es Danlí
        $filtroOrigen = 'Danlí';

        // Obtener filtros de la solicitud
        $filtroDestino = $request->get('destino', '');
        $filtroFecha = $request->get('fecha', '');
        $filtroHorario = $request->get('horario', '');
        $filtroPrecioMin = (int)$request->get('precio_min', 0);
        $filtroPrecioMax = (int)$request->get('precio_max', 500);

        // Obtener fechas y horarios únicos
        $fechasUnicas = array_values(array_unique(array_column($this->viajes, 'fecha')));
        $horariosUnicos = array_values(array_unique(array_column($this->viajes, 'horario')));
        sort($fechasUnicas);
        sort($horariosUnicos);

        // Filtrar viajes
        $viajesFiltrados = $this->filtrarViajes(
            $filtroDestino,
            $filtroFecha,
            $filtroHorario,
            $filtroPrecioMin,
            $filtroPrecioMax
        );

        // Pasar datos a la vista
        return view('catalogo.index', [
            'departamentos' => $this->departamentos,
            'viajesFiltrados' => $viajesFiltrados,
            'fechasUnicas' => $fechasUnicas,
            'horariosUnicos' => $horariosUnicos,
            'filtroOrigen' => $filtroOrigen,
            'filtroDestino' => $filtroDestino,
            'filtroFecha' => $filtroFecha,
            'filtroHorario' => $filtroHorario,
            'filtroPrecioMin' => $filtroPrecioMin,
            'filtroPrecioMax' => $filtroPrecioMax
        ]);
    }

    /**
     * Filtrar viajes según los criterios
     */
    private function filtrarViajes($destino, $fecha, $horario, $precioMin, $precioMax)
    {
        return array_filter($this->viajes, function($viaje) use ($destino, $fecha, $horario, $precioMin, $precioMax) {
            $cumpleDestino = empty($destino) || stripos($viaje['destino'], $destino) !== false;
            $cumpleFecha = empty($fecha) || $viaje['fecha'] === $fecha;
            $cumpleHorario = empty($horario) || strpos($viaje['horario'], $horario) === 0;
            $cumplePrecio = $viaje['precio'] >= $precioMin && $viaje['precio'] <= $precioMax;

            return $cumpleDestino && $cumpleFecha && $cumpleHorario && $cumplePrecio;
        });
    }

    /**
     * Obtener color del departamento
     */
    public function obtenerColorDepartamento($nombre)
    {
        foreach ($this->departamentos as $dept) {
            if ($dept['nombre'] === $nombre) {
                return $dept['color'];
            }
        }
        return '#009B77';
    }

    /**
     * Comprar un viaje (AJAX)
     */
    public function comprar(Request $request)
    {
        $viajeId = $request->get('viaje_id');

        // Buscar el viaje
        $viaje = null;
        foreach ($this->viajes as $v) {
            if ($v['id'] == $viajeId) {
                $viaje = $v;
                break;
            }
        }

        if (!$viaje) {
            return response()->json(['error' => 'Viaje no encontrado'], 404);
        }

        // Aquí iría la lógica de compra
        return response()->json(['success' => true, 'viaje' => $viaje]);
    }
}
