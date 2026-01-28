@extends('layouts.layoutuser')
@section('contenido')
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Terminales - BusTrak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            background-color: #ecf0f1;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-content {
            padding: 20px;
            margin-top: 0;
        }

        .header-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .main-title {
            color: #0c3c60;
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 2rem;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .search-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-label {
            font-weight: 600;
            color: #0c3c60;
            margin-bottom: 8px;
        }

        .btn-primary-custom {
            background: #5DA3E8;
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
        }

        .btn-primary-custom:hover {
            background: #4A92D7;
            color: white;
        }

        .table-custom {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .table-custom thead {
            background: #0c3c60;
            color: white;
        }

        .table-custom th {
            font-weight: 600;
            border: none;
            padding: 15px 12px;
        }

        .table-custom td {
            padding: 12px;
            vertical-align: middle;
            border-color: #ecf0f1;
        }

        #map {
            height: 400px;
            border-radius: 8px;
            border: 1px solid #bdc3c7;
            margin-bottom: 20px;
        }

        .map-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .section-title {
            color: #0c3c60;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .pagination .page-link {
            color: #5DA3E8;
        }

        .pagination .page-item.active .page-link {
            background: #5DA3E8;
            border-color: #5DA3E8;
        }

        .badge-codigo {
            background: #6c757d;
            color: white;
            font-weight: 600;
            padding: 6px 10px;
        }

        .location-badge {
            background: #17a2b8;
            color: white;
            font-size: 0.8rem;
            padding: 6px 10px;
        }

        .map-container {
            position: relative;
            width: 100%;
        }

        .leaflet-container {
            background-color: #e8f4f8 !important;
        }

        .form-control, .form-select {
            height: 45px;
        }

        #search-form .form-control,
        #search-form .btn-primary-custom {
            height: 45px !important;
        }

        #search-form .btn-primary-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            border-radius: 6px;
            line-height: 1;
        }

        #search-form .btn-primary-custom i {
            line-height: 1;
        }

        @media (max-width: 575.98px) {
            #search-form .form-control,
            #search-form .btn-primary-custom {
                height: 42px !important;
            }
        }
    </style>
</head>
<body>

<!-- Contenido Principal -->
<div class="container main-content">
    <!-- Header Section -->
    <div class="header-section">
        <div class="row align-items-center">
            <div class="col-md-12">
                <h1 class="main-title">Consultar Terminales</h1>
                <p class="subtitle">Lista de Terminales de Autobuses Registradas</p>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <div class="row g-3 align-items-end">
            <!-- 🔍 BUSCADOR -->
            <div class="col-md-6">
                <label class="form-label">Buscar por nombre, dirección, municipio o departamento...</label>
                <form action="{{ route('consulta-paradas.index') }}" method="GET" id="search-form" class="d-flex w-100">
                    <input type="text" name="search" class="form-control me-2 flex-grow-1" placeholder="Buscar terminal..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-search me-1"></i>Buscar
                    </button>
                </form>
            </div>

            <!-- 🔽 ORDENAR -->
            <div class="col-md-6">
                <label class="form-label">Ordenar por</label>
                <form action="{{ route('consulta-paradas.index') }}" method="GET" id="sort-form" class="w-100">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="order_by" class="form-select w-100" onchange="document.getElementById('sort-form').submit()">
                        <option value="nombre" {{ request('order_by') == 'nombre' ? 'selected' : '' }}>Nombre (A-Z)</option>
                        <option value="nombre_desc" {{ request('order_by') == 'nombre_desc' ? 'selected' : '' }}>Nombre (Z-A)</option>
                        <option value="codigo" {{ request('order_by') == 'codigo' ? 'selected' : '' }}>Código</option>
                        <option value="departamento" {{ request('order_by') == 'departamento' ? 'selected' : '' }}>Departamento</option>
                        <option value="municipio" {{ request('order_by') == 'municipio' ? 'selected' : '' }}>Municipio</option>
                        <option value="fecha_reciente" {{ request('order_by') == 'fecha_reciente' ? 'selected' : '' }}>Más Recientes</option>
                        <option value="fecha_antiguo" {{ request('order_by') == 'fecha_antiguo' ? 'selected' : '' }}>Más Antiguos</option>
                        <option value="proximidad" {{ request('order_by') == 'proximidad' ? 'selected' : '' }}>Más Cercanas</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Mapa -->
    <div class="map-section">
        <h3 class="section-title">
            <i class="fas fa-map me-2"></i>Mapa de Terminales
        </h3>
        <div class="map-container">
            <div id="map"></div>
        </div>
        <div class="mt-2">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                El mapa muestra la ubicación exacta de las terminales basada en sus coordenadas.
            </small>
        </div>
    </div>

    <!-- Resultados -->
    <div class="search-section">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="section-title mb-0">
                <i class="fas fa-list me-2"></i>Lista de Terminales
            </h3>
            <span class="text-muted">
                @if($terminales->count() > 0)
                    Mostrando {{ $terminales->firstItem() }} - {{ $terminales->lastItem() }} de {{ $terminales->total() }} terminales
                @endif
            </span>
        </div>

        @if($terminales->count() > 0)
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Dirección</th>
                        <th>Ubicación</th>
                        <th>Horario</th>
                        <th>Contacto</th>
                        <th>Coordenadas</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($terminales as $terminal)
                        <tr>
                            <td>
                                <strong>{{ $terminal->nombre }}</strong>
                                @if($terminal->descripcion)
                                    <br><small class="text-muted">
                                        @php
                                            $descripcion = $terminal->descripcion;
                                            if(strlen($descripcion) > 50) {
                                                echo substr($descripcion, 0, 50) . '...';
                                            } else {
                                                echo $descripcion;
                                            }
                                        @endphp
                                    </small>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-codigo">{{ $terminal->codigo }}</span>
                            </td>
                            <td>{{ $terminal->direccion }}</td>
                            <td>
                                <span class="badge location-badge">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $terminal->municipio }}, {{ $terminal->departamento }}
                                </span>
                            </td>
                            <td>
                                <i class="fas fa-clock text-warning me-1"></i>
                                {{ $terminal->horario_apertura }} - {{ $terminal->horario_cierre }}
                            </td>
                            <td>
                                <i class="fas fa-phone me-1"></i>{{ $terminal->telefono }}
                                @if($terminal->correo)
                                    <br><i class="fas fa-envelope me-1"></i>{{ $terminal->correo }}
                                @endif
                            </td>
                            <td>
                                @if($terminal->latitud && $terminal->longitud)
                                    <span class="badge bg-success">
                                        <i class="fas fa-crosshairs me-1"></i>
                                        {{ number_format($terminal->latitud, 6) }}, {{ number_format($terminal->longitud, 6) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Sin coordenadas
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <nav>
                    {{ $terminales->links() }}
                </nav>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No se encontraron terminales</h4>
                <p class="text-muted">Intenta con otros términos de búsqueda</p>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView([14.8378, -86.5375], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(map);

        const terminalesData = @json($terminales->items());
        const markers = [];

        terminalesData.forEach(terminal => {
            let coords = null;

            // ✅ USAR COORDENADAS EXACTAS DE RegistroTerminal
            if (terminal.latitud && terminal.longitud) {
                coords = [parseFloat(terminal.latitud), parseFloat(terminal.longitud)];
            } else {
                // Coordenadas aproximadas por municipio
                const municipioCoords = {
                    'Distrito Central (Tegucigalpa y Comayagüela)': [14.0940, -87.2067],
                    'San Pedro Sula': [15.5059, -88.0236],
                    'La Ceiba': [15.7828, -86.7900],
                    'Comayagua': [14.4604, -87.6389],
                    'Choluteca': [13.3017, -87.1944],
                    'Puerto Cortés': [15.8389, -87.9439],
                    'El Progreso': [15.4000, -87.8000],
                    'Juticalpa': [14.6667, -86.2167],
                    'Danlí': [14.0333, -86.5833],
                    'Santa Rosa de Copán': [14.7667, -88.7833],
                    'Tela': [15.7833, -87.4500],
                    'Siguatepeque': [14.6000, -87.8333],
                    'La Esperanza': [14.3000, -88.1833],
                    'Catacamas': [14.8481, -85.8944],
                    'Trujillo': [15.9167, -85.9500],
                    'Roatán': [16.3170, -86.5370]
                };
                coords = municipioCoords[terminal.municipio] || [14.8378, -86.5375];
            }

            const marker = L.marker(coords)
            .addTo(map)
            .bindPopup(`
                    <div style="min-width: 220px;">
                        <h6 class="text-primary mb-2" style="font-weight: 600; font-size: 1rem;">
                            <i class="fas fa-bus me-1"></i>${terminal.nombre}
                        </h6>
                        <div style="font-size: 0.85rem;">
                            <p class="mb-1"><strong>Código:</strong> ${terminal.codigo}</p>
                            <p class="mb-1"><i class="fas fa-map-marker-alt me-1"></i>${terminal.direccion}</p>
                            <p class="mb-1"><i class="fas fa-location-arrow me-1"></i>${terminal.municipio}, ${terminal.departamento}</p>
                            ${terminal.latitud && terminal.longitud ?
                `<p class="mb-1"><i class="fas fa-crosshairs me-1"></i><small>Coordenadas exactas</small></p>
                 <p class="mb-1"><small>Lat: ${parseFloat(terminal.latitud).toFixed(6)}</small></p>
                 <p class="mb-1"><small>Lng: ${parseFloat(terminal.longitud).toFixed(6)}</small></p>` :
                `<p class="mb-1"><i class="fas fa-info-circle me-1"></i><small>Ubicación aproximada</small></p>`}
                            <p class="mb-1"><i class="fas fa-clock me-1"></i>${terminal.horario_apertura} - ${terminal.horario_cierre}</p>
                            <p class="mb-1"><i class="fas fa-phone me-1"></i>${terminal.telefono}</p>
                            ${terminal.correo ? `<p class="mb-0"><i class="fas fa-envelope me-1"></i>${terminal.correo}</p>` : ''}
                        </div>
                    </div>
                `);

            markers.push(marker);
        });

        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        } else {
            map.setView([14.8378, -86.5375], 7);
        }

        setTimeout(() => map.invalidateSize(), 100);
    });
</script>

</body>
</html>
@endsection
