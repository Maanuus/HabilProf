<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabilitacionController;
use App\Http\Controllers\ListadoSemestralController;
use App\Http\Controllers\ListadoProfesoresController;


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