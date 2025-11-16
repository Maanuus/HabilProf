<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabilitacionController;
use App\Http\Controllers\HabilitacionListadosController;
use App\Http\Controllers\HabilitacionProfesorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// Vista raíz
Route::get('/', fn () => redirect()->route('login'));

// Página principal
Route::get('/home', [HabilitacionListadosController::class, 'ultimasHabilitaciones'])
    ->name('home');

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

// Listado histórico (por semestre)
Route::get('/habilitaciones/historico', [HabilitacionListadosController::class, 'historicoForm'])
    ->name('habilitaciones.HistoricoForm');
Route::post('/habilitaciones/historico', [HabilitacionListadosController::class, 'historicoResultados'])
    ->name('habilitaciones.HistoricoResultados');

// Editar habilitación
Route::get('/habilitaciones/{id}/editar', [HabilitacionController::class, 'edit'])
    ->name('habilitaciones.edit');
Route::put('/habilitaciones/{id}', [HabilitacionController::class, 'update'])
    ->name('habilitaciones.update');

// Formulario por profesor
Route::get('/habilitaciones/profesor', [HabilitacionProfesorController::class, 'form'])
    ->name('habilitaciones.ProfesorForm');

// Resultados del filtro
Route::post('/habilitaciones/profesor/resultados', [HabilitacionProfesorController::class, 'resultados'])
    ->name('habilitaciones.profesor.resultados');
