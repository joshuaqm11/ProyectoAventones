<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RideController;
use App\Http\Controllers\PasajeroReservaController;
use App\Http\Controllers\ChoferReservaController;
use App\Http\Controllers\AdminUsuarioController;



// =============================
// AUTH / LOGIN
// =============================

// HOME → pantalla de login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');

// (Opcional) también permitir GET /login
Route::get('/login', [AuthController::class, 'showLogin']);

// Login / logout
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =============================
// REGISTRO
// =============================

Route::get('/registro/chofer', [AuthController::class, 'showRegisterChofer'])->name('registro.chofer');
Route::post('/registro/chofer', [AuthController::class, 'registerChofer'])->name('registro.chofer.post');

Route::get('/registro/pasajero', [AuthController::class, 'showRegisterPasajero'])->name('registro.pasajero');
Route::post('/registro/pasajero', [AuthController::class, 'registerPasajero'])->name('registro.pasajero.post');

// Activación de cuenta (la lógica ya la tienes en el controlador)
Route::get('/activar/{token}', [AuthController::class, 'activarCuenta'])->name('activar');

// =============================
// PÁGINA PÚBLICA DE RIDES
// =============================
Route::get('/rides-publicos', [PasajeroReservaController::class, 'publicos'])
    ->name('rides.publicos');

// =============================
// DASHBOARD CHOFER + VEHÍCULOS + RIDES
// =============================

Route::middleware(['auth', 'rol:chofer'])
    ->prefix('chofer')
    ->name('chofer.')
    ->group(function () {

        // Dashboard principal del chofer
        Route::get('/dashboard', function () {
            return view('chofer.dashboard');
        })->name('dashboard');

        // --------- VEHÍCULOS (CRUD) ---------
        // Lista
        Route::get('/vehiculos', [VehiculoController::class, 'index'])
            ->name('vehiculos.index');

              // --------- RESERVAS DE MIS RIDES (CHOFER) ---------
Route::get('/reservas/pendientes', [ChoferReservaController::class, 'pendientes'])
    ->name('reservas.pendientes');

Route::get('/reservas', [ChoferReservaController::class, 'todas'])
    ->name('reservas.todas');

// Aceptar / rechazar reserva
Route::post('/reservas/{reserva}/aceptar', [ChoferReservaController::class, 'aceptar'])
    ->name('reservas.aceptar');

Route::post('/reservas/{reserva}/rechazar', [ChoferReservaController::class, 'rechazar'])
    ->name('reservas.rechazar');

    
        // Form crear
        Route::get('/vehiculos/create', [VehiculoController::class, 'create'])
            ->name('vehiculos.create');

        // Guardar nuevo
        Route::post('/vehiculos', [VehiculoController::class, 'store'])
            ->name('vehiculos.store');

        // Form editar
        Route::get('/vehiculos/{vehiculo}/edit', [VehiculoController::class, 'edit'])
            ->name('vehiculos.edit');

        // Actualizar
        Route::put('/vehiculos/{vehiculo}', [VehiculoController::class, 'update'])
            ->name('vehiculos.update');

        // Eliminar
        Route::delete('/vehiculos/{vehiculo}', [VehiculoController::class, 'destroy'])
            ->name('vehiculos.destroy');

        // --------- RIDES (CRUD) ---------
        Route::get('/rides', [RideController::class, 'index'])->name('rides.index');
        Route::get('/rides/create', [RideController::class, 'create'])->name('rides.create');
        Route::post('/rides', [RideController::class, 'store'])->name('rides.store');
        Route::get('/rides/{ride}/edit', [RideController::class, 'edit'])->name('rides.edit');
        Route::put('/rides/{ride}', [RideController::class, 'update'])->name('rides.update');
        Route::delete('/rides/{ride}', [RideController::class, 'destroy'])->name('rides.destroy');
    });



// =============================
// DASHBOARD PASAJERO
// =============================

Route::middleware(['auth', 'rol:pasajero'])
    ->prefix('pasajero')
    ->name('pasajero.')
    ->group(function () {

        // Dashboard principal del pasajero
        Route::view('/dashboard', 'pasajero.dashboard')->name('dashboard');

        // Buscar rides disponibles
        Route::get('/rides', [PasajeroReservaController::class, 'buscarRides'])
            ->name('rides.buscar');

        // Reservar ride
        Route::post('/rides/{ride}/reservar', [PasajeroReservaController::class, 'reservar'])
            ->name('rides.reservar');

        // Reservas activas
        Route::get('/reservas/activas', [PasajeroReservaController::class, 'reservasActivas'])
            ->name('reservas.activas');

        // Historial de reservas
        Route::get('/reservas/historial', [PasajeroReservaController::class, 'reservasHistorial'])
            ->name('reservas.historial');

        // Cancelar reserva
        Route::post('/reservas/{reserva}/cancelar', [PasajeroReservaController::class, 'cancelar'])
            ->name('reservas.cancelar');
    });


// =============================
// DASHBOARD ADMIN
// =============================

use App\Http\Controllers\AdminAdminController;

Route::middleware(['auth', 'rol:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/admins', [AdminAdminController::class, 'index'])->name('admins.index');
        Route::get('/admins/create', [AdminAdminController::class, 'create'])->name('admins.create');
        Route::post('/admins', [AdminAdminController::class, 'store'])->name('admins.store');

        Route::get('/usuarios', [AdminUsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/estado', [AdminUsuarioController::class, 'index'])->name('usuarios.estado');
        Route::post('/usuarios/{usuario}/toggle-estado', [AdminUsuarioController::class, 'toggleEstado'])->name('usuarios.toggle-estado');

        // Vista SOLO PARA VER usuarios
        Route::get('/usuarios/ver', [AdminUsuarioController::class, 'ver'])
            ->name('usuarios.ver');

        // Vista para activar / desactivar
        Route::get('/usuarios', [AdminUsuarioController::class, 'index'])
            ->name('usuarios.index');

        Route::post('/usuarios/{usuario}/toggle-estado', [AdminUsuarioController::class, 'toggleEstado'])
            ->name('usuarios.toggle-estado');

    });

    


// =============================
// HOME GENÉRICO
// =============================

Route::get('/home', function () {
    return redirect()->route('login');
})->name('home');
