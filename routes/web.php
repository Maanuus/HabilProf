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

// Rutas Protegidas por Autenticación y Prevención de Caché (Atrás en navegador)
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Página principal (Dashboard)
    Route::get('/home', [ListadoSemestralController::class, 'ultimasHabilitaciones'])->name('home');

    // Habilitaciones
    Route::get('/habilitaciones/nueva', [HabilitacionController::class, 'create'])->name('habilitaciones.create');
    Route::post('/habilitaciones', [HabilitacionController::class, 'store'])->name('habilitaciones.store');
    Route::get('/habilitaciones/{id}/editar', [HabilitacionController::class, 'edit'])->name('habilitaciones.edit');
    Route::put('/habilitaciones/{id}', [HabilitacionController::class, 'update'])->name('habilitaciones.update');

    // Listados
    Route::get('/habilitaciones/ListadoSemestral', [ListadoSemestralController::class, 'ListadoSemestral'])->name('habilitaciones.FormularioSemestral');
    Route::post('/habilitaciones/ListadoSemestral', [ListadoSemestralController::class, 'ResultadoListadoSemestral'])->name('habilitaciones.ResultadoSemestral');

    Route::get('/habilitaciones/ListadoProfesor', [ListadoProfesoresController::class, 'ListadoProfesores'])->name('habilitaciones.FormularioProfesor');
    Route::post('/habilitaciones/ListadoProfesor', [ListadoProfesoresController::class, 'ResultadoListadoProfesores'])->name('habilitaciones.ResultadoProfesor');

    // Panel de administración y sincronización
    Route::get('/admin/panel', [AdminPanelController::class, 'panel'])->name('admin.panel');
    Route::post('/admin/sync', [AdminPanelController::class, 'ejecutarSync'])->name('admin.sync');
    Route::get('/admin/sync-history', [SyncHistoryController::class, 'index'])->name('admin.sync-history');
    Route::delete('/admin/sync-history', [SyncHistoryController::class, 'clear'])->name('admin.sync-history.clear');

    // API para notificaciones de sincronización
    Route::get('/api/sync-notification', [SyncNotificationController::class, 'getLatest'])->name('api.sync.notification');
});

