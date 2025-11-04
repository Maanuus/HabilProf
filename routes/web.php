<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabilitacionController;

Route::get('/', function () {
    return view('welcome');
});

// página principal
Route::view('/home', 'welcome')->name('home'); 

// login
Route::view('/', 'auth.login')->name('login');

// nueva habilitación
Route::get('/habilitaciones/nueva', [HabilitacionController::class, 'create'])
    ->name('habilitaciones.create');

Route::post('/habilitaciones', [HabilitacionController::class, 'store'])
    ->name('habilitaciones.store');

Route::get('/habilitaciones/{id}/editar', [HabilitacionController::class, 'edit'])
    ->name('habilitaciones.edit');

Route::put('/habilitaciones/{id}', [HabilitacionController::class, 'update'])
    ->name('habilitaciones.update');
