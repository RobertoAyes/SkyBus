<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        #backToTop {
            position: fixed;
            bottom: 30px;
            right: 10px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #000;
            color: #000;
            font-size: 24px;
            display: none;
            align-items: center;
            justify-content: center;
            text-align: center;
            z-index: 1000;
            cursor: pointer;
            background-color: transparent;
            transition: transform 0.3s, border-color 0.3s, color 0.3s;
            display: flex;
        }

        #backToTop:hover {
            transform: translateY(-2px);
            border-color: #06174f;
            color: #06174f;
        }


        .btn-login {
            background-color: #007bff !important;
            color: white !important;
            border: none !important;
            border-radius: 12px;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: 600;
        }
        .btn-login:hover { opacity: 0.85; }

        .btn-registro {
            background-color: #28a745 !important;
            color: white !important;
            border: none !important;
            border-radius: 12px;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: 600;
        }
        .btn-registro:hover { opacity: 0.85; }

        .btn-outline-light {
            color: #fff !important;
            border: 2px solid #fff !important;
        }
        .btn-outline-light:hover {
            background-color: #fff !important;
            color: #1976d2 !important;
        }
        .btn-gradient {
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            transition: all 0.3s;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            opacity: 0.95;
        }

        body { font-family: Arial, sans-serif; background: #EAF6FF; }

        /* BOTONES LOGIN / REGISTRO */
        .hero-buttons a {
            padding: 8px 18px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 10px;
        }
        .btn-login {
            background-color: #007bff !important;
            color: white !important;
            border: none !important;
        }
        .btn-login:hover { opacity: 0.85; }
        .btn-registro {
            background-color: #28a745 !important;
            color: white !important;
            border: none !important;
        }
        .btn-registro:hover { opacity: 0.85; }

        /* HERO */
        .hero-section {
            background-repeat: no-repeat;
            background-position: right top;
            background-size: 550px;
            padding: 80px 0;
        }
        .hero-title {
            font-size: 58px;
            font-weight: 800;
            line-height: 1.1;
            color: #1c1c1c;
            text-align: left;
            text-shadow: none;
        }
        .hero-subtitle {
            font-size: 22px;
            margin-top: 15px;
            color: #4b4b4b;
            text-align: left;
        }

        /* INFO BOXES */
        .info-box {
            background: white;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.05);
        }
        .info-icon { width: 60px; }
        .info-text { font-size: 18px; font-weight: 500; }

        /* General y Back to Top */
        body { font-family: Arial, sans-serif; background: #EAF6FF; }
        #backToTop { position: fixed; bottom: 30px; right: 10px; width: 50px; height: 50px; border-radius: 50%; border: 2px solid #000; color: #000; font-size: 24px; display: none; align-items: center; justify-content: center; cursor: pointer; background-color: transparent; transition: transform 0.3s, border-color 0.3s, color 0.3s; z-index:1000; display:flex; }
        #backToTop:hover { transform: translateY(-2px); border-color: #06174f; color: #06174f; }

        .btn-login, .btn-registro { border-radius:12px; font-weight:600; padding:10px 20px; font-size:18px; }
        .btn-login { background-color:#007bff;color:white;border:none; } .btn-login:hover{opacity:0.85;}
        .btn-registro { background-color:#28a745;color:white;border:none;} .btn-registro:hover{opacity:0.85;}

        /* Hero */
        .hero-section { background-repeat:no-repeat; background-position:right top; background-size:550px; padding:80px 0; }
        .hero-title { font-size:58px;font-weight:800;line-height:1.1;color:#1c1c1c;text-align:left; }
        .hero-subtitle { font-size:22px;margin-top:15px;color:#4b4b4b;text-align:left; }

        /* Departamentos */
        .departments .card { cursor:pointer; transition: transform 0.2s; }
        .departments .card:hover { transform: scale(1.05); }
        .departments img { height:150px; object-fit:cover; border-radius:10px; }

        /* Modal info */
        .modal-info { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.7); z-index:3000; padding:20px; align-items:center; justify-content:center; }
        .modal-info.show { display:flex; }
        .modal-info-content { background:white; border-radius:12px; max-width:1200px; width:100%; box-shadow:0 10px 40px rgba(0,0,0,0.3); max-height:85vh; overflow-y:auto; }
        .modal-info-header { background:linear-gradient(180deg,#1e63b8,#1976d2); color:white; padding:24px; border-radius:12px 12px 0 0; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:10; }
        .modal-info-header h2 { margin:0; font-size:1.5rem; font-weight:700; }
        .modal-info-close { background: rgba(255,255,255,0.2); border:none; color:white; width:40px; height:40px; border-radius:50%; font-size:20px; cursor:pointer; display:flex; align-items:center; justify-content:center; }
        .modal-info-close:hover { background: rgba(255,255,255,0.3); }
        .modal-info-body { padding:24px; }
        .info-tabs { display:flex; gap:10px; margin-bottom:20px; border-bottom:2px solid #e5e7eb; flex-wrap:wrap; }
        .info-tab { padding:10px 20px; border:none; background:none; cursor:pointer; font-weight:600; color:#6b7280; border-bottom:3px solid transparent; transition: all 0.3s; font-size:14px; }
        .info-tab.active { color:#1976d2; border-bottom-color:#1976d2; }
        .info-tab:hover { color:#1976d2; }
        .tab-content { display:none; }
        .tab-content.active { display:block; }
        .cards-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:20px; }
        .info-card { border:1px solid #e5e7eb; border-radius:10px; overflow:hidden; transition: all 0.3s; background:white; box-shadow:0 2px 4px rgba(0,0,0,0.1); }
        .info-card:hover { transform:translateY(-8px); box-shadow:0 12px 24px rgba(0,0,0,0.15); }
        .info-card-img { width:100%; height:160px; display:flex; align-items:center; justify-content:center; font-size:3rem; color:white; }
        .info-card-body { padding:16px; }
        .info-card-title { font-size:16px; font-weight:700; color:#1f2937; margin-bottom:8px; }
        @media(max-width:768px){.cards-grid{grid-template-columns:1fr;}}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #101827;">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="Imagenes/bustrak-logo.png" alt="Bustrak Logo" style="height: 60px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            @guest
                <div class="hero-buttons d-flex gap-2">
                    <a href="/login" class="btn btn-primary btn-login">Iniciar Sesión</a>
                    <a href="/registro" class="btn btn-success btn-registro">Regístrate</a>
                </div>
            @endguest
            @auth
                <div class="d-flex gap-2 align-items-center">
                    <span class="text-white me-2">¡Hola, {{ auth()->user()->name }}!</span>
                    <a href="{{ route('cliente.perfil') }}"
                       class="btn btn-outline-light btn-sm px-3 rounded-pill shadow-sm">
                        <i class="fas fa-user me-1"></i> Perfil
                    </a>
                </div>
            @endauth



        </div>

    </div>
</nav>

<!-- HERO -->
<div class="container hero-section">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="hero-title">
                {!! $homeConfig->titulo ?? 'Encuentra pasajes<br>en bus baratos<br>en Honduras' !!}
            </h1>
            <p class="hero-subtitle">
                {{ $homeConfig->subtitulo ?? 'Busca y compra fácilmente tu próximo pasaje en bus con Bustrak, tu mejor opción.' }}
            </p>

            @if(!empty($homeConfig->texto_boton))
                <a href="{{ $homeConfig->link_boton ?? '#' }}" class="btn btn-gradient mt-3">
                    {{ $homeConfig->texto_boton }}
                </a>
            @endif
        </div>

        <div class="col-md-6 text-center">
            <img src="{{ $homeConfig->imagen_banner ?? '/catalago/img/fondo.png' }}"
                 alt="Imagen hero" class="img-fluid" style="max-height:400px;">
        </div>
    </div>
</div>

<hr style="border: 0; height: 1px; background-color: #1976d2; margin: 50px 0;">


<!-- INFORMACIÓN -->
<div class="container mt-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="info-box d-flex align-items-start gap-3">
                <img class="info-icon" src="https://www.busbud.com/pubweb-assets/images/usp/52ba7ae.usp-v3-trust-coverage.png">
                <p class="info-text">
                    Únete a más de 1 millon de viajeros al rededor de todo el pais.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box d-flex align-items-start gap-3">
                <img class="info-icon" src="https://www.busbud.com/pubweb-assets/images/usp/3136d75.usp-v3-support.png">
                <p class="info-text">
                    Disfruta de nuestro servicio de atención al cliente disponible 24/7.
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box d-flex align-items-start gap-3">
                <img class="info-icon" src="https://www.busbud.com/pubweb-assets/images/usp/5619a22.usp-v3-cfar.png">
                <p class="info-text">
                    Puedes cancelar en cualquier momento y recibir un reembolso.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Departamentos -->
<section class="py-5">
    <div class="container py-5">
        <h2 class="mb-4 text-center">Destinos turísticos en nuestra bella Honduras</h2>
        <div class="row row-cols-1 row-cols-md-4 g-3 departments" id="departamentosGrid"></div>
    </div>
</section>

<!-- Modal -->
<div class="modal-info" id="modalInfo">
    <div class="modal-info-content">
        <div class="modal-info-header">
            <h2 id="modalInfoTitle"><i class="fas fa-map-marker-alt"></i> Departamento</h2>
            <button class="modal-info-close" onclick="cerrarModalInfo()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-info-body">
            <div class="info-tabs">
                <button class="info-tab active" onclick="cambiarTab('lugares', event)"><i class="fas fa-landmark"></i> Lugares Turísticos</button>
                <button class="info-tab" onclick="cambiarTab('comidas', event)"><i class="fas fa-utensils"></i> Comidas Típicas</button>
            </div>
            <div id="lugaresTab" class="tab-content active"><div class="cards-grid" id="lugaresGrid"></div></div>
            <div id="comidasTab" class="tab-content"><div class="cards-grid" id="comidasGrid"></div></div>
        </div>
    </div>
</div>
<hr style="border: 0; height: 1px; background-color: #1976d2; margin: 50px 0;">

<div class="container mt-5">
    <div class="row align-items-center">
        <div class="col-md-4 text-center">
            <img src="/catalago/img/fondo1.png" class="img-fluid" alt="Imagen ilustrativa">
        </div>
        <div class="col-md-8">
            <h2 class="fw-bold mb-3">¿Por qué Bustrak es tu mejor opción?</h2>
            <p class="mb-2" style="font-size: 18px;">La mejor manera de comprar pasajes de bus</p>
            <p style="font-size: 16px; line-height: 1.6;">
                Bustrak.com te ofrece una variedad de rutas a 16 departamentos del pais con la mayor comodidad en nuestros buses super cómodos, seguridad 100% fiable con nuestros choferes experimentados, tendrás el mejor viaje por carretera, porque Bustrak te conecta por toda Honduras.                </p>
        </div>
    </div>
</div>
<hr style="border: 0; height: 1px; background-color: #1976d2; margin: 50px 0;">

<div class="container">
    <h2 class="text-center fw-bold mb-4">Beneficios en algunos de nuestros buses</h2>
    <p class="text-center mb-5" style="font-size: 18px;">
        En <strong>Bustrak</strong> su seguridad y comodidad es nuestra prioridad.<br>
        Nuestros servicios le permiten viajar por Honduras de forma confortable para que tenga un recorrido placentero y seguro con nuestros conductores certificados. Además, le ofrecemos los siguientes servicios exclusivos en nuestras unidades:
    </p>

    <div class="row g-4 justify-content-center">
        <div class="col-6 col-md-4">
            <div class="info-card text-center p-3">
                <i class="fas fa-wifi fa-2x mb-2" style="color:#1976d2;"></i>
                <h6>WIFI a bordo</h6>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="info-card text-center p-3">
                <i class="fas fa-snowflake fa-2x mb-2" style="color:#1976d2;"></i>
                <h6>Aire acondicionado</h6>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="info-card text-center p-3">
                <i class="fas fa-suitcase fa-2x mb-2" style="color:#1976d2;"></i>
                <h6>Kit de viajes</h6>
            </div>
        </div>

        <div class="col-6 col-md-4">
            <div class="info-card text-center p-3">
                <i class="fas fa-coffee fa-2x mb-2" style="color:#1976d2;"></i>
                <h6>Paradas de cortesía</h6>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="info-card text-center p-3">
                <i class="fas fa-bolt fa-2x mb-2" style="color:#1976d2;"></i>
                <h6>Conexiones eléctricas y USB</h6>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="info-card text-center p-3">
                <i class="fas fa-map-marker-alt fa-2x mb-2" style="color:#1976d2;"></i>
                <h6>Sistema de geolocalización GPS</h6>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="info-card text-center p-3">
                <i class="fas fa-tv fa-2x mb-2" style="color:#1976d2;"></i>
                <h6>Entretenimiento a bordo</h6>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="info-card text-center p-3">
                <i class="fas fa-video fa-2x mb-2" style="color:#1976d2;"></i>
                <h6>Cámaras de video vigilancia</h6>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="info-card text-center p-3">
                <i class="fas fa-ellipsis-h fa-2x mb-2" style="color:#1976d2;"></i>
                <h6>Y mucho más</h6>
            </div>
        </div>


    </div>
</div>


<hr style="border: 0; height: 1px; background-color: #1976d2; margin: 50px 0;">

<!-- SECCIÓN: Prepare su viaje -->
<section class="container my-5">
    <h2 class="text-center mb-4">Prepare su viaje</h2>
    <p class="text-center mb-5">Recomendaciones para hacer de su viaje una experiencia inolvidable.</p>

    <div class="row g-4 text-center">
        <!-- Fila 1 -->
        <div class="col-12 col-md-6">
            <img loading="lazy" alt="Planee su viaje" src="https://www.ticabus.com/documents/7092829/7093204/ico_planea.svg/227152e1-824b-3052-c301-3ee496d1ef9f?t=1732002538128" class="img-fluid mb-2" style="max-height:50px;">
            <h6>Planee su viaje</h6>
            <p>Elija su destino, fecha de viaje, horario y punto de abordaje.</p>
        </div>

        <div class="col-12 col-md-6">
            <img loading="lazy" alt="Compre su boleto" src="https://www.ticabus.com/documents/7092829/7093204/ico_compra.svg/537e738f-b33c-4091-7cfa-1053d9b4fa2c?t=1732002538017" class="img-fluid mb-2" style="max-height:50px;">
            <h6>Compre su boleto</h6>
            <p>Adquiera sus boletos en línea aquí.</p>
        </div>

        <!-- Fila 2 -->
        <div class="col-12 col-md-6">
            <img loading="lazy" alt="Aborde a tiempo" src="https://www.ticabus.com/documents/7092829/7093204/ico_aborda.svg/101af751-58dc-674b-ee0e-00bd950ce590?t=1732002537917" class="img-fluid mb-2" style="max-height:50px;">
            <h6>Aborde a tiempo</h6>
            <p>Preséntese una hora antes de su horario de salida en el punto de abordaje para el chequeo del equipaje.</p>
        </div>

        <div class="col-12 col-md-6">
            <img loading="lazy" alt="Equipaje" src="https://www.ticabus.com/documents/7092829/7093204/ico_equipaje.svg/7096cfbe-1126-f415-2858-a8dfab33ce35?t=1732002537690" class="img-fluid mb-2" style="max-height:50px;">
            <h6>Equipaje</h6>
            <p>Cada pasajero tiene derecho a llevar dos maletas de 15 kilos cada una y un bolso de mano.</p>
        </div>
    </div>

    <!-- AVISO AL FINAL -->
    <div class="mt-4 p-4 bg-light rounded text-center">
        <small>
            *La empresa no se hace responsable por pérdida o daños de valores, caja frágil, equipo de cómputo, electrónico y electrodoméstico.
            Los objetos quedan bajo la responsabilidad del pasajero.
        </small>
    </div>
</section>


<a href="#" id="backToTop" title="Ir arriba"><i class="fas fa-arrow-up"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let destinosData = {};

    // Cargar departamentos desde API

    fetch('/api/destinos')
        .then(res => res.json())
        .then(data => {
            destinosData = data;
            const grid = document.getElementById('departamentosGrid');
            if(Object.keys(data).length === 0){
                grid.innerHTML = '<p class="text-center">No hay departamentos registrados.</p>';
                return;
            }
            Object.keys(data).forEach(dep => {
                const depImg = data[dep].imagen || '/catalago/img/default.jpg';
                grid.innerHTML += `<div class="col">
                <div class="card" onclick="abrirModalInfo('${dep}')">
                    <img src="${depImg}" class="card-img-top" alt="${dep}">
                    <div class="card-body text-center"><h6>${dep}</h6></div>
                </div>
            </div>`;
            });
        }).catch(err => {
        document.getElementById('departamentosGrid').innerHTML = '<p class="text-center text-danger">Error al cargar departamentos.</p>';
        console.error(err);
    });

    // Modal
    function abrirModalInfo(departamento){
        const info = destinosData[departamento];
        if(!info) return;
        document.getElementById('modalInfoTitle').innerHTML = `<i class="fas fa-map-marker-alt"></i> ${departamento}`;
        document.getElementById('lugaresGrid').innerHTML = info.lugares.map(l => `
        <div class="info-card">
            <div class="info-card-img"><img src="${l.imagen}" alt="${l.nombre}" style="width:100%;height:100%;object-fit:cover;"></div>
            <div class="info-card-body"><div class="info-card-title">${l.nombre}</div></div>
        </div>`).join('');
        document.getElementById('comidasGrid').innerHTML = info.comidas.map(c => `
        <div class="info-card">
            <div class="info-card-img"><img src="${c.imagen}" alt="${c.nombre}" style="width:100%;height:100%;object-fit:cover;"></div>
            <div class="info-card-body"><div class="info-card-title">${c.nombre}</div></div>
        </div>`).join('');
        document.getElementById('modalInfo').classList.add('show');
    }

    function cerrarModalInfo(){ document.getElementById('modalInfo').classList.remove('show'); }
    function cambiarTab(tab,event){
        document.querySelectorAll('.info-tab').forEach(t=>t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active'));
        event.target.classList.add('active');
        document.getElementById(tab+'Tab').classList.add('active');
    }

    // Back to Top
    window.addEventListener('scroll',()=>{
        document.getElementById('backToTop').style.display = (window.scrollY>200)?'flex':'none';
    });
    document.getElementById('backToTop').addEventListener('click',e=>{
        e.preventDefault();
        window.scrollTo({top:0,behavior:'smooth'});
    });
</script>


<a href="#" id="backToTop" title="Ir arriba">
    <i class="fas fa-arrow-up"></i>
</a>
<script>
    window.addEventListener('scroll', function() {
        const btn = document.getElementById('backToTop');
        if (window.scrollY > 200) {
            btn.style.display = 'flex';
        } else {
            btn.style.display = 'none';
        }
    });

    document.getElementById('backToTop').addEventListener('click', function(e){
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>


</body>
</html>
