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
        // cada habilitacion del home
        switch ((int) $id) {
            case 1:
                $habilitacion = [
                    'id_habilitacion' => 1,
                    'rut' => '12.345.678-9',
                    'nombre_alumno' => 'María González',
                    'carrera' => 'Ingeniería Civil Informática',
                    'correo_alumno' => 'maria@ucsc.cl',
                    'tipo_HabilProf' => 'PrIng',
                    'titulo' => 'Sistema de Monitoreo Energético',
                    'descripcion' => 'Proyecto sobre eficiencia energética en hogares.',
                    'rut_profesor_comision' => '11111111-1',
                    'rut_profesor_coguia' => '',
                    'semestre_inicio' => '2025-1',
                    'nombre_Empresa' => '',
                    'nombre_Supervisor' => '',
                ];
                break;

            case 2:
                $habilitacion = [
                    'id_habilitacion' => 2,
                    'rut' => '23.456.789-0',
                    'nombre_alumno' => 'Carlos López',
                    'carrera' => 'Ingeniería Civil',
                    'correo_alumno' => 'carlos@ucsc.cl',
                    'tipo_HabilProf' => 'PrTut',
                    'titulo' => '',
                    'descripcion' => '',
                    'rut_profesor_comision' => '',
                    'rut_profesor_coguia' => '',
                    'semestre_inicio' => '2025-1',
                    'nombre_Empresa' => 'Tech Solutions SpA',
                    'nombre_Supervisor' => 'Sofía Ríos',
                ];
                break;

            case 3:
                $habilitacion = [
                    'id_habilitacion' => 3,
                    'rut' => '34.567.890-1',
                    'nombre_alumno' => 'Ana Silva',
                    'carrera' => 'Ingeniería Informática',
                    'correo_alumno' => 'ana.silva@ucsc.cl',
                    'tipo_HabilProf' => 'PrInv',
                    'titulo' => 'Análisis de Redes Neuronales',
                    'descripcion' => 'Estudio comparativo de modelos CNN para clasificación.',
                    'rut_profesor_comision' => '22222222-2',
                    'rut_profesor_coguia' => '33333333-3',
                    'semestre_inicio' => '2025-1',
                    'nombre_Empresa' => '',
                    'nombre_Supervisor' => '',
                ];
                break;
        }

        return view('habilitaciones.edit', compact('habilitacion'));
    }

    public function update(Request $request, $id)
    {
        // VA AL HOME.
        return redirect()->route('home')->with('ok', "Habilitacion #$id actualizada (mock).");
    }
}

