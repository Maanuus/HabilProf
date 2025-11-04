<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabilitacionController;
use App\Http\Controllers\HabilitacionListadosController;

// página principal con datos reales
Route::get('/home', [HabilitacionListadosController::class, 'ultimasHabilitaciones'])
    ->name('home');

// login
Route::view('/', 'auth.login')->name('login');

// nueva habilitación
Route::get('/habilitaciones/nueva', [HabilitacionController::class, 'create'])
    ->name('habilitaciones.create');

Route::post('/habilitaciones', [HabilitacionController::class, 'store'])
    ->name('habilitaciones.store');

Route::get('/habilitaciones/historico', [HabilitacionListadosController::class, 'historicoForm'])->name('habilitaciones.HistoricoForm');
Route::post('/habilitaciones/historico', [HabilitacionListadosController::class, 'historicoResultados'])->name('habilitaciones.HistoricoResultados');

Route::get('/habilitaciones/{id}/editar', [HabilitacionController::class, 'edit'])
    ->name('habilitaciones.edit');

Route::put('/habilitaciones/{id}', [HabilitacionController::class, 'update'])
    ->name('habilitaciones.update');
