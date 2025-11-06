<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabilitacionController;
use App\Http\Controllers\HabilitacionListadosController;
use App\Http\Controllers\HabilitacionProfesorController;

// Página principal
Route::get('/home', [HabilitacionListadosController::class, 'ultimasHabilitaciones'])
    ->name('home');

// Login
Route::view('/', 'auth.login')->name('login');

// Nueva habilitación
Route::get('/habilitaciones/nueva', [HabilitacionController::class, 'create'])
    ->name('habilitaciones.create');

Route::post('/habilitaciones', [HabilitacionController::class, 'store'])
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