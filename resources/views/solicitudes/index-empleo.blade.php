@extends('layouts.layoutuser')

@section('title', 'Mis Solicitudes de Empleo')

@section('contenido')
    <div class="container mt-4">
        <div class="card shadow-sm border-0">

            {{-- HEADER --}}
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:2rem;">
                    <i class="fas fa-briefcase me-2"></i> Mis Solicitudes de Empleo
                </h2>
                <a href="{{ route('solicitud.empleo.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Nueva Solicitud
                </a>
            </div>

            <div class="card-body">

                {{-- ALERTAS --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-check me-2"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="fas fa-circle-exclamation me-2"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($solicitudes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-primary">
                            <tr>
                                <th style="width:60px;" class="text-center">#</th>
                                <th>Nombre</th>
                                <th>Puesto Deseado</th>
                                <th>Contacto</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Fecha Envío</th>
                                <th class="text-center">CV</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($solicitudes as $key => $solicitud)
                                <tr>
                                    <td class="text-center">{{ ($solicitudes->currentPage()-1)*$solicitudes->perPage() + $key + 1 }}</td>
                                    <td>{{ $solicitud->nombre_completo }}</td>
                                    <td>{{ $solicitud->puesto_deseado }}</td>
                                    <td>{{ $solicitud->contacto }}</td>
                                    <td class="text-center">
                                        @switch($solicitud->estado)
                                            @case('Pendiente')
                                                <span class="badge bg-warning text-dark">Pendiente</span>
                                                @break
                                            @case('Revisada')
                                                <span class="badge bg-info text-dark">Revisada</span>
                                                @break
                                            @case('Aceptada')
                                                <span class="badge bg-success">Aceptada</span>
                                                @break
                                            @case('Rechazada')
                                                <span class="badge bg-danger">Rechazada</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="text-center">{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        @if($solicitud->cv)
                                            <a href="{{ asset('storage/' . $solicitud->cv) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-download"></i> Ver CV
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINACIÓN --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Mostrando
                            <span class="fw-semibold text-dark">{{ $solicitudes->firstItem() ?? 0 }}</span>
                            –
                            <span class="fw-semibold text-dark">{{ $solicitudes->lastItem() ?? 0 }}</span>
                            de
                            <span class="fw-semibold text-dark">{{ $solicitudes->total() }}</span>
                            registros
                        </div>

                        @if($solicitudes->hasPages())
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item {{ $solicitudes->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $solicitudes->previousPageUrl() }}">Anterior</a>
                                    </li>
                                    @for($page = 1; $page <= $solicitudes->lastPage(); $page++)
                                        <li class="page-item {{ $page == $solicitudes->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $solicitudes->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ $solicitudes->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $solicitudes->nextPageUrl() }}">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>

                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                        <p class="mb-3">No has enviado solicitudes de empleo aún.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <style>
        .table-responsive { min-height: 320px; }
        .pagination .page-link {
            color: #1e63b8;
            border-radius: 0.375rem;
            border: 1px solid #dee2e6;
            margin: 0 2px;
        }
        .pagination .page-link:hover { background-color: #1e63b8; color: #fff; }
        .pagination .page-item.active .page-link { background-color: #1e63b8; border-color: #1e63b8; color: #fff; }
        .pagination .page-item.disabled .page-link { color: #9ca3af; background: #f3f4f6; border-color: #e5e7eb; }
        .badge { font-size: 0.85rem; }
    </style>
@endsection
