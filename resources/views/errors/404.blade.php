<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: black;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: #f8f9fa;
        }

        h1 {
            font-size: 8rem;
            font-weight: bold;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }
        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .btn-primary {
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 20px;
        }

        /* Contenedor del bus y carretera */
        .road-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            height: 60px;
            margin: 0 auto 30px;
        }

        /* Carretera */
        .road {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 40px;
            background: #333;
            border-radius: 5px;
            overflow: hidden;
        }

        .road::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 4px;
            background: repeating-linear-gradient(
                to right,
                white,
                white 20px,
                transparent 20px,
                transparent 40px
            );
            transform: translateY(-50%);
        }

        /* Bus */
        .bus-icon {
            position: absolute;
            bottom: 10px; /* Ajusta la altura para que las ruedas toquen la carretera */
            width: 64px;
            height: 64px;
        }

        .bus1 { left: 10%; }
        .bus2 { left: 45%; }
        .bus3 { left: 80%; }

    </style>
</head>
<body>
<div>
    <h1>Ups!</h1>
    <h2>Página no encontrada</h2>
    <p>Bustrak no encuentra la página que buscas.</p>

    <!-- Contenedor de buses y carretera -->
    <div class="road-container">
        <!-- Carretera -->
        <div class="road"></div>

        <!-- Buses -->
        <svg class="bus-icon bus1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="6" width="20" height="10" rx="2" stroke="#1e63b8" stroke-width="1.6" fill="#fff"/>
            <rect x="3" y="7" width="4" height="4" rx="0.5" fill="#1976d2"/>
            <rect x="8" y="7" width="4" height="4" rx="0.5" fill="#1976d2"/>
            <rect x="13" y="7" width="4" height="4" rx="0.5" fill="#1976d2"/>
            <rect x="18" y="7" width="3" height="6" rx="0.5" fill="#1976d2"/>
            <circle cx="7.5" cy="17" r="1.5" fill="#1976d2"/>
            <circle cx="16.5" cy="17" r="1.5" fill="#1976d2"/>
        </svg>

        <svg class="bus-icon bus2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="6" width="20" height="10" rx="2" stroke="#1e63b8" stroke-width="1.6" fill="#fff"/>
            <rect x="3" y="7" width="4" height="4" rx="0.5" fill="#1976d2"/>
            <rect x="8" y="7" width="4" height="4" rx="0.5" fill="#1976d2"/>
            <rect x="13" y="7" width="4" height="4" rx="0.5" fill="#1976d2"/>
            <rect x="18" y="7" width="3" height="6" rx="0.5" fill="#1976d2"/>
            <circle cx="7.5" cy="17" r="1.5" fill="#1976d2"/>
            <circle cx="16.5" cy="17" r="1.5" fill="#1976d2"/>
        </svg>

        <svg class="bus-icon bus3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="6" width="20" height="10" rx="2" stroke="#1e63b8" stroke-width="1.6" fill="#fff"/>
            <rect x="3" y="7" width="4" height="4" rx="0.5" fill="#1976d2"/>
            <rect x="8" y="7" width="4" height="4" rx="0.5" fill="#1976d2"/>
            <rect x="13" y="7" width="4" height="4" rx="0.5" fill="#1976d2"/>
            <rect x="18" y="7" width="3" height="6" rx="0.5" fill="#1976d2"/>
            <circle cx="7.5" cy="17" r="1.5" fill="#1976d2"/>
            <circle cx="16.5" cy="17" r="1.5" fill="#1976d2"/>
        </svg>
    </div>

    <a href="javascript:history.back()" class="btn btn-primary">Volver atras</a>
</div>
</body>
</html>
