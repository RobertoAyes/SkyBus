@extends('layouts.layoutadmin')

@section('title', 'Usuarios bloqueados')

@section('content')

    <div class="container-fluid">
        <h3 class="mb-4">Usuarios con múltiples intentos fallidos</h3>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>Email</th>
                        <th>Intentos fallidos</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($bloqueados as $usuario)
                        <tr>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->intentos }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">
                                No hay usuarios bloqueados actualmente
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

@endsection
