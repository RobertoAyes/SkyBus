@extends('layouts.layoutchofer') <!-- Este es el layout para choferes -->
@section('contenido')



    <div class="container-fluid px-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background-color: transparent; padding: 0;">
                <li class="breadcrumb-item active" aria-current="page">Mi Perfil (Chofer)</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-9 mx-auto">

                <!-- Header Card con Gradiente -->
                <div style="background: linear-gradient(135deg, #5cb3ff 0%, #1e63b8 100%); border-radius: 16px; padding: 40px; color: white; margin-bottom: 30px; display: flex; align-items: center; gap: 30px;">

                    {{-- Foto o inicial --}}
                    @if($chofer->foto)
                        <img src="{{ asset('storage/' . $chofer->foto) }}"
                             style="width: 110px; height: 110px; object-fit: cover; border-radius: 50%; border: 4px solid rgba(255,255,255,0.4);">
                    @else
                        <div style="width: 110px; height: 110px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 50px; font-weight: bold; border: 4px solid rgba(255,255,255,0.4); flex-shrink: 0;">
                            {{ strtoupper(substr($chofer->nombre, 0, 1)) }}
                        </div>
                    @endif

                    <div style="flex-grow: 1;">
                        <h2 style="margin: 0; font-size: 28px; font-weight: 700; text-transform: capitalize;">
                            {{ $chofer->nombre_completo }}
                        </h2>
                        <p style="margin: 12px 0 0 0; font-size: 14px; opacity: 0.95;">
                            <i class="fas fa-id-badge me-2"></i> Chofer Verificado
                        </p>
                    </div>
                </div>

                <!-- Card de Información -->
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-4">

                        <!-- Nombre Completo -->
                        <div style="padding: 20px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; font-size: 12px; color: #999; font-weight: 700;">Nombre Completo</p>
                                <p style="margin: 8px 0 0 0; font-size: 16px; color: #333; font-weight: 600;">
                                    {{ $chofer->nombre_completo }}
                                </p>
                            </div>
                            <i class="fas fa-user" style="color: #5cb3ff; font-size: 24px;"></i>
                        </div>

                        <!-- DNI -->
                        <div style="padding: 20px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; font-size: 12px; color: #999; font-weight: 700;">DNI</p>
                                <p style="margin: 8px 0 0 0; font-size: 16px; color: #333; font-weight: 600;">
                                    {{ $chofer->dni }}
                                </p>
                            </div>
                            <i class="fas fa-id-card" style="color: #5cb3ff; font-size: 24px;"></i>
                        </div>

                        <!-- Fecha de Ingreso -->
                        <div style="padding: 20px 0; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; font-size: 12px; color: #999; font-weight: 700;">Fecha de Ingreso</p>
                                <p style="margin: 8px 0 0 0; font-size: 16px; color: #333; font-weight: 600;">
                                    {{-- Fecha de ingreso --}}
                                    {{ $chofer->fecha_ingreso ? $chofer->fecha_ingreso->format('d \d\e F \d\e Y') : 'No registrada' }}
                                </p>
                            </div>
                            <i class="fas fa-calendar-check" style="color: #5cb3ff; font-size: 24px;"></i>
                        </div>

                        <!-- Edad -->
                        <div style="padding: 20px 0; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin: 0; font-size: 12px; color: #999; font-weight: 700;">Edad</p>
                                <p style="margin: 8px 0 0 0; font-size: 16px; color: #333; font-weight: 600;">
                                    {{ $chofer->edad ? $chofer->edad . ' años' : 'No registrada' }}
                                </p>
                            </div>
                            <i class="fas fa-hourglass-half" style="color: #5cb3ff; font-size: 24px;"></i>
                        </div>

                    </div>

                    <!-- Footer (opcional, por ahora solo ver perfil) -->
                    <div style="background: #f8f9fa; padding: 20px; display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid #f0f0f0; border-radius: 0 0 12px 12px;">
                        <a href="{{ route('chofer.perfil') }}"
                           style="padding: 10px 24px; background: #5cb3ff; color: white; border-radius: 8px; font-weight: 600; text-decoration: none;">
                            <i class="fas fa-user me-2"></i> Actualizar
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
