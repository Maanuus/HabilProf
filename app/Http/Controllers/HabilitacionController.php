<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HabilitacionController extends Controller
{
    public function create()
    {
        return view('habilitaciones.create');
    }

    public function store(Request $request)
    {
        // Lógica para almacenar la nueva habilitación
        // Por ahora, solo redirigimos de vuelta a la página de creación
        return redirect()->route('habilitaciones.create')->with('ok', 'Habilitación creada exitosamente.');
    }

    public function edit()
    {
        return view('habilitaciones.edit');
    }
}
