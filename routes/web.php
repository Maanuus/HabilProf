<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabilitacionController;
use App\Http\Controllers\ListadoSemestralController;
use App\Http\Controllers\ListadoProfesoresController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\SyncNotificationController;
use App\Http\Controllers\SyncHistoryController;


// Login
Route::view('/', 'auth.login')->name('login');

// Nueva habilitación
Route::get('/habilitaciones/nueva', [HabilitacionController::class, 'create'])
    ->name('habilitaciones.create');

Route::post('/habilitaciones', [HabilitacionController::class, 'store'])
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
    // Resultados del filtro
Route::post('/habilitaciones/ListadoSemestral', [ListadoSemestralController::class, 'ResultadoListadoSemestral'])
    ->name('habilitaciones.ResultadoSemestral');

// Formulario por profesor
Route::get('/habilitaciones/ListadoProfesor', [ListadoProfesoresController::class, 'ListadoProfesores'])
    ->name('habilitaciones.FormularioProfesor');

// Resultados del filtro
Route::post('/habilitaciones/ListadoProfesor', [ListadoProfesoresController::class, 'ResultadoListadoProfesores'])
    ->name('habilitaciones.ResultadoProfesor');