<?php

use App\Http\Controllers\RegistroRentaController;
use App\Http\Controllers\RegistroTeminalController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeEditorController;
use App\Http\Controllers\Api\DestinosController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RegistroPuntosController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\ValidarEmpresaController2;
use App\Http\Controllers\EmpresaHU11Controller;
use App\Http\Controllers\EmpleadoHU5Controller;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EmpresaBusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\RegistroUsuarioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ConsultaParadaController;
use App\Http\Controllers\AbordajeController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\HistorialReservasController;
use App\Http\Controllers\ItinerarioController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\DocumentoBusController;
use App\Http\Controllers\CalificacionChoferController;
use App\Http\Controllers\Cliente\FacturaController;


// Toggle activar/inactivar
Route::patch('/admin/usuarios/{id}/cambiar', [AdminController::class, 'cambiarEstado'])->name('admin.cambiarEstado');

// Validar usuario
Route::patch('/admin/usuarios/{id}/validar', [AdminController::class, 'validar'])->name('admin.validar');

// ======================================================
// RUTAS VALIDAR EMPRESAS
// ======================================================
Route::get('/validar-empresas', [ValidarEmpresaController2::class, 'index'])
    ->name('empresas.validar');

// Visualización de terminales
Route::get('/ver_terminales', [RegistroTeminalController::class, 'ver_terminales'])->name('terminales.ver_terminales');

// Validación empleados
Route::get('/validacion-empleados', function () {
    return view('validacion-empleados.index');
})->name('validacion-empleados.index');

// Consulta paradas
Route::get('consulta-paradas', [ConsultaParadaController::class, 'index'])->name('consulta-paradas.index');

// Ruta principal
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// CONSULTA DE EMPRESAS
Route::get('empresas', [EmpresaController::class, 'index'])->name('empresas.index');

// Recurso empleados
Route::resource('empleados', EmpleadoController::class);

// Activar/desactivar empleados
Route::get('/empleados/{id}/desactivar', [EmpleadoController::class, 'formDesactivar'])->name('empleados.formDesactivar');
Route::put('/empleados/{id}/desactivar', [EmpleadoController::class, 'guardarDesactivacion'])->name('empleados.desactivar');
Route::put('/empleados/{id}/activar', [EmpleadoController::class, 'activar'])->name('empleados.activar');

// ======================================================
// AUTENTICACIÓN
// ======================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/registro', [RegistroUsuarioController::class, 'create'])->name('registro');
Route::post('/registro', [RegistroUsuarioController::class, 'store']);

Route::get('/usuarios/consultar', [RegistroUsuarioController::class, 'consultar'])->name('usuarios.consultar');
Route::resource('usuarios', RegistroUsuarioController::class);

// Password reset
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Logout (mantengo ambos)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ======================================================
// CLIENTES
// ======================================================
Route::middleware(['auth', 'user.active'])->prefix('cliente')->group(function () {
    Route::get('/perfil', [ClienteController::class, 'perfil'])->name('cliente.perfil');
    Route::get('/reservas', [ClienteController::class, 'reservas'])->name('cliente.reservas');
    Route::get('/perfil/editar', [ClienteController::class, 'edit'])->name('cliente.edit');
    Route::put('/perfil', [ClienteController::class, 'update'])->name('cliente.update');
});

// ======================================================
// ADMIN
// ======================================================
Route::middleware(['auth', 'user.active'])->prefix('admin')->group(function () {
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::post('/usuarios/{id}/cambiar-estado', [AdminController::class, 'cambiarEstado'])->name('admin.cambiarEstado');
});

Route::get('/admin/pagina', [EstadisticasController::class, 'index'])
    ->middleware('auth')
    ->name('admin.dashboard');

// ======================================================
// EMPLEADO HU5
// ======================================================
Route::get('/empleados-hu5', [EmpleadoHU5Controller::class, 'index'])->name('empleados.hu5');

// ======================================================
// EMPRESAS HU11 (EDITAR)
// ======================================================
Route::get('/empresa-hu11/{id}/editar', [EmpresaHU11Controller::class, 'edit'])->name('empresa.edit.hu11');
Route::put('/empresa-hu11/{id}', [EmpresaHU11Controller::class, 'update'])->name('empresa.update.hu11');

// ======================================================
// TERMINALES
// ======================================================
Route::resource('terminales', RegistroTeminalController::class)->parameters([
    'terminales' => 'terminal',
]);

// HU10 - empresas buses
Route::get('/hu10/empresas-buses', [EmpresaBusController::class, 'index'])
    ->name('hu10.empresas.buses');

Route::get('/principal', function () {
    return view('interfaces.principal');
})->name('interfaces.principal');

// Abordajes
Route::middleware('auth')->prefix('abordajes')->name('abordajes.')->controller(AbordajeController::class)->group(function () {
    Route::get('escanear', 'mostrarEscaner')->name('escanear');
    Route::post('validar', 'validarCodigoQR')->name('validar');
    Route::post('confirmar', 'confirmarAbordaje')->name('confirmar');
    Route::get('historial', 'historial')->name('historial');
});

// ======================================================
// NOTIFICACIONES USUARIO
// ======================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('usuario.notificaciones');
    Route::get('/notificaciones/leida/{id}', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.leida');
    Route::delete('/notificaciones/eliminar/{id}', [NotificacionController::class, 'eliminar'])->name('notificaciones.eliminar');
});

// HISTORIAL CLIENTE
Route::middleware(['auth'])->group(function () {
    Route::get('/cliente/historial', [HistorialReservasController::class, 'index'])
        ->name('cliente.historial');
});

// Itinerarios
Route::middleware('auth')->prefix('itinerario')->name('itinerario.')->controller(ItinerarioController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/pdf', 'descargarPDF')->name('pdf');
    Route::get('/compartir/{id}', 'compartir')->name('compartir');
    Route::get('/compartir/{id}/pdf', 'descargarCompartido')->name('pdf.compartido');
    Route::post('/actualizar', 'actualizarItinerario')->name('actualizar');
    Route::get('/historial', 'historialVisualizaciones')->name('historial');
});

// Catálogo
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');

// Consulta/soporte
Route::get('/ayuda-soporte', [ConsultaController::class, 'index'])->name('consulta.formulario');
Route::post('/ayuda-soporte', [ConsultaController::class, 'store'])->name('soporte.enviar');

// Interfaz empleados
Route::prefix('empleado')->middleware(['auth', 'user.active'])->group(function() {

    Route::get('/dashboard', [EmpleadoController::class, 'dashboard'])->name('empleado.dashboard');
    Route::get('/viajes', [EmpleadoController::class, 'viajes'])->name('empleado.viajes');
    Route::get('/pasajeros', [EmpleadoController::class, 'pasajeros'])->name('empleado.pasajeros');
    Route::get('/confirmar', [EmpleadoController::class, 'confirmar'])->name('empleado.confirmar');
    Route::get('/qr', [EmpleadoController::class, 'qr'])->name('empleado.qr');

    // Reservas
    Route::get('/reservas/create', [EmpleadoController::class, 'crearReserva'])->name('empleado.reservas.create');
    Route::get('/reservas', [EmpleadoController::class, 'consultarReservas'])->name('empleado.reservas');
    Route::get('/asientos', [EmpleadoController::class, 'asignarAsientos'])->name('empleado.asientos');
    Route::get('/boletos', [EmpleadoController::class, 'boletos'])->name('empleado.boletos');

    // Itinerarios
    Route::get('/itinerarios', [EmpleadoController::class, 'itinerarios'])->name('empleado.itinerarios');

    // Perfil
    Route::get('/perfil', [EmpleadoController::class, 'perfil'])->name('empleado.perfil');
});

// Usuario
Route::prefix('usuario')->middleware(['auth', 'user.active'])->group(function() {
    Route::get('/dashboard', function () {
        return view('usuarios.dashboard');
    })->name('usuario.dashboard');

    Route::get('/viajes', [EmpleadoController::class, 'viajes'])->name('usuario.viajes');
    Route::get('/pasajeros', [EmpleadoController::class, 'pasajeros'])->name('usuario.pasajeros');
    Route::get('/confirmar', [EmpleadoController::class, 'confirmar'])->name('usuario.confirmar');
    Route::get('/qr', [EmpleadoController::class, 'qr'])->name('usuario.qr');

    Route::get('/perfil', [EmpleadoController::class, 'perfil'])->name('usuario.perfil');
});

// Empleados HU5 versiones Francis
Route::get('/empleados-hu5', [EmpleadoController::class, 'index'])->name('empleados.hu5');
Route::put('/empleados-hu5/{id}', [EmpleadoController::class, 'update'])->name('empleados.hu5.update');
Route::put('/empleados-hu5/{id}/activar', [EmpleadoController::class, 'activar'])->name('empleados.hu5.activar');
Route::put('/empleados-hu5/{id}/desactivar', [EmpleadoController::class, 'guardarDesactivacion'])->name('empleados.hu5.desactivar');

// Estadísticas
Route::get('/estadisticahu46', [EstadisticasController::class, 'index'])->name('estadistica');
Route::get('/admin/estadisticas', [EstadisticasController::class, 'mostrar'])->name('admin.estadisticas');

// Actualizar empresas
Route::put('empresas/{id}', [EmpresaController::class, 'update'])->name('empresas.update');

Route::resource('rentas', RegistroRentaController::class);

// ======================================================
// Reservas
// ======================================================
Route::middleware(['auth'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('reserva/create', [ReservaController::class, 'create'])->name('reserva.create');
    Route::post('reserva/buscar', [ReservaController::class, 'buscar'])->name('reserva.buscar');
    Route::get('reserva/{viaje_id}/asientos', [ReservaController::class, 'seleccionarAsiento'])->name('reserva.asientos');
    Route::post('reserva/store', [ReservaController::class, 'store'])->name('reserva.store');
});

// Admin predeterminado
Route::get('/admin/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'Administrador') {
        return view('admin.dashboard');
    }
    abort(403, 'Acceso denegado');
})->middleware('auth')->name('admin.dashboard');

// Check-in
Route::post('/abordajes/validar', [CheckinController::class, 'validarCodigo'])->name('abordajes.validar');
Route::post('/abordajes/confirmar', [CheckinController::class, 'confirmarAbordaje'])->name('abordajes.confirmar');
Route::get('/abordajes/historial', [CheckinController::class, 'historial'])->name('abordajes.historial');

// Consultas usuario
Route::get('/mis-solicitudes', [ConsultaController::class, 'misConsultas'])->name('consulta.mis');

// Calificación de viajes
Route::get('/viaje/{reserva}/calificar', [CalificacionController::class, 'create'])->name('calificacion.create');
Route::post('/viaje/{reserva}/calificar', [CalificacionController::class, 'store'])->name('calificacion.store');

// ======================================================
// RUTAS ADMINS - NOTIFICACIONES
// ======================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/notificaciones', [NotificacionController::class, 'indexAdmin'])->name('admin.notificaciones');
});

// ======================================================
// REGISTRO EMPRESAS / USUARIOS
// ======================================================
Route::match(['get', 'post'], '/empresa', [EmpresaBusController::class, 'form'])->name('empresa.form');

Route::middleware(['auth'])->prefix('usuario')->group(function () {
    Route::match(['get', 'post'], '/mi-empresa', [EmpresaBusController::class, 'formUsuario'])
        ->name('usuario.empresa.form');
});

// ======================================================
// CAMBIO DE CONTRASEÑA (desde main)
// ======================================================
Route::get('admin/cambiar-password', [AuthController::class, 'showAdminChangePasswordForm'])->name('admin.change-password');
Route::post('admin/update-password', [AuthController::class, 'updateAdminPassword'])->name('admin.update-password');

// Usuario
Route::get('usuario/cambiar-password', [AuthController::class, 'showUserChangePasswordForm'])->name('usuario.change-password');
Route::post('usuario/update-password', [AuthController::class, 'updateUserPassword'])->name('usuario.update-password');

// Solicitudes de constancia
Route::middleware(['auth'])->group(function () {
    Route::get('solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
    Route::get('solicitudes/create', [SolicitudController::class, 'create'])->name('solicitudes.create');
    Route::post('solicitudes', [SolicitudController::class, 'store'])->name('solicitudes.store');
    Route::patch('solicitudes/{solicitud}/procesar', [SolicitudController::class, 'procesar'])->name('solicitudes.procesar');
});

// Solicitud de empleo
Route::get('/solicitud/empleo', [App\Http\Controllers\SolicitudEmpleoController::class, 'misSolicitudes'])->name('solicitud.empleo.mis-solicitudes');
Route::get('/crear-solicitud-empleo', [App\Http\Controllers\SolicitudEmpleoController::class, 'create'])->name('solicitud.empleo.create');
Route::post('/solicitud/empleo/enviar', [App\Http\Controllers\SolicitudEmpleoController::class, 'store'])->name('solicitud.empleo.store');

// Registro de puntos
Route::get('/viaje/{reserva}/registrar-puntos', [RegistroPuntosController::class, 'create'])
    ->name('puntos.create');

Route::post('/viaje/{reserva}/registrar-puntos', [RegistroPuntosController::class, 'store'])
    ->name('puntos.store');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DocumentoBusController::class, 'dashboard'])->name('dashboard');

});
 //Documentos-buses Sindy
Route::middleware(['auth'])->prefix('documentos-buses')->name('documentos-buses.')->group(function () {

    // documentos-buses.dashboard, si se requiere en el menú específico de esa sección.
    Route::get('/dashboard', [DocumentoBusController::class, 'dashboard'])->name('dashboard');

    Route::get('/crear', [DocumentoBusController::class, 'create'])->name('create');
    Route::post('/', [DocumentoBusController::class, 'store'])->name('store');
    Route::post('/actualizar-estados', [DocumentoBusController::class, 'actualizarEstados'])->name('actualizar-estados');
    Route::get('/exportar/pdf', [DocumentoBusController::class, 'exportarPDF'])->name('exportar-pdf');

    // API - Obtener documentos por bus
    Route::get('/api/bus/{busId}', [DocumentoBusController::class, 'porBus'])->name('api.por-bus');

    // 2. RUTAS DE LISTADO (SIN PARÁMETROS)
    // -------------------------------------------------------------------
    Route::get('/', [DocumentoBusController::class, 'index'])->name('index');

    // 3. RUTAS CON PARÁMETROS (VAN AL FINAL)
    // -------------------------------------------------------------------
    Route::get('/{id}/descargar', [DocumentoBusController::class, 'descargarArchivo'])->name('descargar');
    Route::get('/{id}/editar', [DocumentoBusController::class, 'edit'])->name('edit');
    // Esta ruta siempre debe ser la última dentro del grupo de rutas CRUD con {id}
    Route::get('/{id}', [DocumentoBusController::class, 'show'])->name('show');
    Route::put('/{id}', [DocumentoBusController::class, 'update'])->name('update');
    Route::delete('/{id}', [DocumentoBusController::class, 'destroy'])->name('destroy');

    // Tu ruta resource existente
    Route::resource('documentos-buses', DocumentoBusController::class);
});

//Rutas Shirley
Route::resource('rentas', RegistroRentaController::class);
Route::put('/reservas/{reserva}', [ReservaController::class, 'update'])->name('reserva.update');


Route::get('/chofer/panel', function () {
    return view('interfaces.chofer');
})->name('chofer.panel');
// NUEVAS RUTAS PARA CANJES
Route::get('/mis-puntos', [RegistroPuntosController::class, 'index'])->name('puntos.index');
Route::post('/canjear-puntos/{beneficio_id}', [RegistroPuntosController::class, 'canjear'])->name('puntos.canjear');

/// Calificación de chofer
Route::get('/calificar-chofer', [App\Http\Controllers\CalificacionChoferController::class, 'formulario'])
    ->name('calificar.chofer');

Route::post('/calificar-chofer', [App\Http\Controllers\CalificacionChoferController::class, 'guardar'])
    ->name('calificar.chofer.guardar');



//Roberto Api
Route::prefix('api')->group(function () {
    Route::get('/destinos', [DestinosController::class, 'index']);
});

//editar pagina principal
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/home-editor', [HomeEditorController::class, 'index'])
        ->name('admin.home.editor');

    Route::post('/admin/home-editor/update', [HomeEditorController::class, 'update'])
        ->name('admin.home.update');
});
Route::prefix('admin')->name('admin.')->group(function() {
    Route::resource('departamentos', App\Http\Controllers\Admin\DepartamentoController::class);
    Route::resource('lugares', App\Http\Controllers\Admin\LugarController::class);
    Route::resource('comidas', App\Http\Controllers\Admin\ComidaController::class);
});
Route::get('/principal', [HomeController::class, 'index'])->name('interfaces.principal');

//aqui acaba analisis periodo 3, año 2025
// Rutas de facturas para clientes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('cliente/facturas')->name('cliente.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Cliente\FacturaController::class, 'index'])->name('facturas');
        Route::get('/{id}', [\App\Http\Controllers\Cliente\FacturaController::class, 'show'])->name('facturas.ver');
        Route::get('/{id}/descargar', [\App\Http\Controllers\Cliente\FacturaController::class, 'descargarPDF'])->name('facturas.pdf');
        Route::post('/{id}/enviar-email', [\App\Http\Controllers\Cliente\FacturaController::class, 'enviarEmail'])->name('facturas.enviar');
    });
});

// Endpoint público para verificar autenticidad del QR
Route::get('/facturas/verificar/{numeroFactura}', [\App\Http\Controllers\Cliente\FacturaController::class, 'verificarAutenticidad'])->name('facturas.verificar');

use App\Models\Ciudad;

Route::get('/principal', function () {
    return view('interfaces.principal', [
        'ciudades' => Ciudad::all()
    ]);
});

Route::get('/cliente/reserva', [ReservaController::class, 'create'])
    ->name('cliente.reserva.create');

Route::post('/cliente/reserva/buscar', [ReservaController::class, 'buscar'])
    ->name('cliente.reserva.buscar');

Route::get('/cliente/reserva/asientos/{id}', [ReservaController::class, 'asientos'])
    ->name('cliente.reserva.asientos');

Route::post('/cliente/reserva/store', [ReservaController::class, 'store'])
    ->name('cliente.reserva.store');


Route::get('/', function () {
    return view('interfaces.principal');
})->name('interfaces.principal');


Route::middleware('auth')->group(function () {
    Route::get('/reserva', [ReservaController::class, 'create'])->name('cliente.reserva.create');
    Route::post('/reserva/buscar', [ReservaController::class, 'buscar'])->name('cliente.reserva.buscar');
    Route::post('/reserva/store', [ReservaController::class, 'store'])->name('cliente.reserva.store');
    Route::get('/historial', [ReservaController::class, 'historial'])->name('cliente.historial'); // si tienes historial
});


Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
