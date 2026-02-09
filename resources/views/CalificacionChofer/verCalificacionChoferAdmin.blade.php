<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones de Choferes</title>
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Calificaciones de Choferes</h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th>Chofer</th>
            <th>Cliente</th>
            <th>⭐</th>
            <th>Comentario</th>
        </tr>
        </thead>
        <tbody>
        @forelse($calificaciones as $c)
            <tr>
                <td>{{ $c->chofer->name }}</td>
                <td>{{ $c->usuario->name }}</td>
                <td>{{ $c->calificacion }}</td>
                <td>{{ $c->comentario }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No hay calificaciones registradas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<!-- Bootstrap JS (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
