<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Incidencia\IncidenciaAdminController;
use App\Http\Controllers\Incidencia\IncidenciaClienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Rutas para admin
Route::middleware(['auth', 'rol:admin'])->group(function () {
    Route::get('incidencias/calendario', [IncidenciaAdminController::class, 'calendario'])->name('calendario');
    Route::resource('incidencias', IncidenciaAdminController::class);
    Route::patch('incidencias/{incidencia}/asignar-tecnico', [IncidenciaAdminController::class, 'asignarTecnico'])->name('incidencias.asignarTecnico'); 
    Route::patch('incidencias/{incidencia}/cambiar-estado', [IncidenciaAdminController::class, 'cambiarEstado'])->name('incidencias.cambiarEstado'); 
});

// Rutas para tecnico
Route::middleware(['auth', 'rol:tecnico'])->group(function () {
    
});

// Rutas para gestora
Route::middleware(['auth', 'rol:gestora'])->group(function () {
    
});

// Rutas para particular
Route::middleware(['auth', 'rol:particular'])->group(function () {
    Route::get('cliente/incidencias', [IncidenciaClienteController::class, 'index'])->name('cliente.incidencias');
    Route::get('cliente/nueva-incidencia', [IncidenciaClienteController::class, 'create'])->name('cliente.nueva-incidencia');
    Route::post('cliente/nueva-incidencia', [IncidenciaClienteController::class, 'store'])->name('cliente.store');
    Route::delete('cliente/incidencias/{incidencia}', [IncidenciaClienteController::class, 'cancelar'])->name('cliente.cancelar');
});
