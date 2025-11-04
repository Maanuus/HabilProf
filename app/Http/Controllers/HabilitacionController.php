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

    public function edit($id)
    {
        
        $habilitacion = [
            'id_habilitacion' => $id,
            'rut' => '12.345.678-9',
            'nombre_alumno' => 'María González',
            'carrera' => 'Ingeniería Civil Informática',
            'correo_alumno' => 'maria@ucsc.cl',
            'tipo_HabilProf' => 'PrIng', // PrIng | PrInv | PrTut
            'titulo' => 'Sistema de Monitoreo Energético',
            'descripcion' => 'Proyecto sobre eficiencia energética en hogares.',
            'rut_profesor_comision' => '11111111-1',
            'rut_profesor_coguia' => '',
            'semestre_inicio' => '2025-1',
            'nombre_Empresa' => '',
            'nombre_Supervisor' => '',
        ];

        return view('habilitaciones.edit', compact('habilitacion'));
    }

    public function update(Request $request, $id)
    {
        // VA AL HOME.
        return redirect()->route('home')->with('ok', "Habilitación #$id actualizada (mock).");
    }
}
