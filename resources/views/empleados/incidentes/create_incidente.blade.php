{{--
Esta pantalla es para registrar un incidente.
--}}

@extends('layouts.layoutadmin')

@section('content')

<div class="container">

    {{-- Título --}}
    <h3>Registro de incidentes en ruta</h3>

    {{--
    Si se guarda bien, aqui sale el mensaje .
    --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{--
    Si falta algo, aquí sale error.
    --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{--
    Formulario:
    Se da en "Guardar", y esto se envía al controlador.
    --}}
    <form method="POST" action="{{ route('empleado.incidentes.store') }}">
        @csrf

        {{-- Conductor --}}
        <div class="mb-3">
            <label>Conductor</label>
            <input type="text"
                   name="conductor_nombre"
                   class="form-control"
                   value="{{ old('conductor_nombre',  '') }}">        </div>

        {{-- Número de bus --}}
        <div class="mb-3">
            <label>Número de bus</label>
            <input type="text"
                   name="bus_numero"
                   class="form-control"
                   value="{{ old('bus_numero') }}">
        </div>

        {{-- Ruta --}}
        <div class="mb-3">
            <label>Ruta</label>
            <input type="text"
                   name="ruta"
                   class="form-control"
                   value="{{ old('ruta') }}">
        </div>

        {{-- Tipo de incidente (desplegable) --}}
        <div class="mb-3">
            <label>Tipo de incidente</label>
            <select name="tipo_incidente" class="form-control">
                <option value="">Seleccione una opción</option>

                {{--
                Si no llega $tipos, igual no explota.
                (pero lo normal es que sí llegue)
                --}}
                @if(!empty($tipos))
                @foreach($tipos as $tipo)
                <option value="{{ $tipo }}"
                        {{ old('tipo_incidente') == $tipo ? 'selected' : '' }}>
                {{ $tipo }}
                </option>
                @endforeach
                @endif

            </select>
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion"
                      class="form-control"
                      rows="4">{{ old('descripcion') }}</textarea>
        </div>

        {{-- Botón --}}
        <button type="submit" class="btn btn-primary">
            Guardar incidente
        </button>

    </form>

</div>

@endsection
