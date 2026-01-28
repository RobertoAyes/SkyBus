<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Usuarios - BusTrak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Contenedor principal con padding lateral */
        .main-container {
            padding: 0 20px;
        }

        /* Logo BusTrak */
        .logo-container {
            width: 150px;
            height: 60px;
            border: 2px solid #0d6efd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            background-color: white;
        }

        /* Panel de administración */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .admin-title {
            font-size: 22px;
            font-weight: 400;
            margin: 0;
            color: #333;
        }

        .admin-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-badge {
            color: #666;
            font-size: 14px;
            font-weight: 400;
        }

        .admin-user {
            color: #0d6efd;
            font-size: 14px;
            font-weight: 400;
        }

        .logout-btn {
            color: #dc3545;
            font-size: 14px;
            text-decoration: none;
            font-weight: 400;
        }

        /* Tarjeta de validación */
        .validation-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .validation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .validation-title {
            color: #0d6efd;
            font-size: 22px;
            font-weight: 400;
            margin: 0;
        }

        .total-badge {
            background-color: #0d6efd;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 400;
        }

        /* Barra de búsqueda y filtros */
        .search-container {
            background-color: white;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 8px 15px;
            width: 350px;
            font-size: 14px;
        }

        .filter-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-filter {
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 400;
            border: none;
            color: white;
        }

        .btn-volver {
            background-color: #0d6efd;
        }

        .btn-todos {
            background-color: #0d6efd;
        }

        .btn-activos {
            background-color: #28a745;
        }

        .btn-inactivos {
            background-color: #ffc107;
            color: #333;
        }

        /* Tabla de usuarios */
        .users-container {
            background-color: white;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .user-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .user-table th {
            color: #333;
            font-weight: 600;
            padding: 12px 10px;
            text-align: left;
            font-size: 14px;
        }

        .user-table td {
            padding: 12px 10px;
            color: #666;
            font-size: 14px;
        }

        .user-id {
            color: #0d6efd;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            color: white;
            font-weight: 400;
            text-align: center;
        }

        .status-active {
            background-color: #28a745;
        }

        .status-inactive {
            background-color: #dc3545;
        }

        .btn-action {
            padding: 6px 20px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 400;
            border: none;
            color: white;
        }

        .btn-activate {
            background-color: #17a2b8;
        }

        .btn-deactivate {
            background-color: #ffc107;
            color: #333;
        }
    </style>
</head>
<body>
<div class="main-container">
    <!-- Logo BusTrak -->
    <div class="logo-container mt-3">
        <img src="https://placehold.co/100x40/FFFFFF/0d6efd?text=BUSTRAK" alt="BusTrak Logo">
    </div>

    <!-- Panel de administración -->
    <div class="admin-header">
        <h1 class="admin-title">Panel de administración</h1>
        <div class="admin-controls">
            <span class="admin-badge">SuperAdmin</span>
            <span class="admin-user">Administrador</span>
            <a href="#" class="logout-btn">Cerrar sesion</a>
        </div>
    </div>

    <!-- Tarjeta de Validación de Usuarios -->
    <div class="validation-card">
        <div class="validation-header">
            <h2 class="validation-title">Validacion de Usuarios</h2>
            <span class="total-badge">Total: 2</span>
        </div>
    </div>

    <!-- Búsqueda y filtros -->
    <div class="search-container">
        <input type="text" class="search-bar" placeholder="Buscar por Nombre Completo, DNI o Email...">
        <div class="filter-buttons">
            <button class="btn-filter btn-volver">Volver</button>
            <button class="btn-filter btn-todos">Todos</button>
            <button class="btn-filter btn-activos">Activos</button>
            <button class="btn-filter btn-inactivos">Inactivos</button>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="users-container">
        <table class="user-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo Electronico</th>
                <th>Estado</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><span class="user-id">#1</span></td>
                <td>d</td>
                <td>efrancielizabeth@gmail.com</td>
                <td><span class="status-badge status-inactive">Inactivo</span></td>
                <td>05/11/2025</td>
                <td><button class="btn-action btn-activate">Activar</button></td>
            </tr>
            <tr>
                <td><span class="user-id">#2</span></td>
                <td>Estrada</td>
                <td>estrada@gmail.com</td>
                <td><span class="status-badge status-active">Activo</span></td>
                <td>05/11/2025</td>
                <td><button class="btn-action btn-deactivate">Inactivar</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
