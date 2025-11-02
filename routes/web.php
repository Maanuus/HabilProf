<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Página principal "real" (la de antes, welcome)
Route::view('/home', 'welcome')->name('home');

// Nueva página de inicio del sitio: login (mockup)
Route::view('/', 'auth.login')->name('login');