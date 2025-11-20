<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabilitacionController;
use App\Http\Controllers\ListadoSemestralController;
use App\Http\Controllers\ListadoProfesoresController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\SyncNotificationController;
use App\Http\Controllers\SyncHistoryController;

use App\Http\Controllers\HabilitacionListadosController;
use App\Http\Controllers\HabilitacionProfesorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// Vista raíz
Route::get('/', fn () => redirect()->route('login'));

// Login / Register (solo invitados)
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'show'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.post');
});

// Logout (solo autenticados)
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Nueva habilitación (protegido)
Route::get('/habilitaciones/nueva', [HabilitacionController::class, 'create'])
    ->middleware('auth')
    ->name('habilitaciones.create');

Route::post('/habilitaciones', [HabilitacionController::class, 'store'])
    ->middleware('auth')
    ->name('habilitaciones.store');

// Editar habilitación
Route::get('/habilitaciones/{id}/editar', [HabilitacionController::class, 'edit'])
    ->name('habilitaciones.edit');

// Panel de administración: ver incompletos y ejecutar sincronización
Route::get('/admin/panel', [AdminPanelController::class, 'panel'])
    ->name('admin.panel');
Route::post('/admin/sync', [AdminPanelController::class, 'ejecutarSync'])
    ->name('admin.sync');

// Historial de cambios de sincronización
Route::get('/admin/sync-history', [SyncHistoryController::class, 'index'])
    ->name('admin.sync-history');
Route::delete('/admin/sync-history', [SyncHistoryController::class, 'clear'])
    ->name('admin.sync-history.clear');

// API para notificaciones de sincronización en tiempo real
Route::get('/api/sync-notification', [SyncNotificationController::class, 'getLatest'])
    ->name('api.sync.notification');

Route::put('/habilitaciones/{id}', [HabilitacionController::class, 'update'])
    ->name('habilitaciones.update');

//Manuel Cisternas Agurto
// Página principal (Tabla que muestra las ultimas 5 habilitaciones)
Route::get('/home', [ListadoSemestralController::class, 'ultimasHabilitaciones'])
    ->name('home');

    // Formulario listado semestral
Route::get('/habilitaciones/ListadoSemestral', [ListadoSemestralController::class, 'ListadoSemestral'])
    ->name('habilitaciones.FormularioSemestral');
    // Resultados listado semestral
Route::post('/habilitaciones/ListadoSemestral', [ListadoSemestralController::class, 'ResultadoListadoSemestral'])
    ->name('habilitaciones.ResultadoSemestral');

// Formulario por profesor
Route::get('/habilitaciones/ListadoProfesor', [ListadoProfesoresController::class, 'ListadoProfesores'])
    ->name('habilitaciones.FormularioProfesor');

// Resultados listado profesor
Route::post('/habilitaciones/ListadoProfesor', [ListadoProfesoresController::class, 'ResultadoListadoProfesores'])
    ->name('habilitaciones.ResultadoProfesor');

