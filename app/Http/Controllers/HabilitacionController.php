<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HabilitacionController extends Controller
{
    public function create()
    {
        return view('habilitaciones.create');
    }

    private function splitRut(string $rut): array
    {
        // Quita puntos y guiones, deja solo dígitos y K
        $clean = strtoupper(preg_replace('/[^0-9K]/', '', $rut));
        // Número = todo menos el último carácter; DV = último
        $numero = (int) substr($clean, 0, -1);
        $dv     = substr($clean, -1);
        return [$numero, $dv];
    }

    public function store(Request $request)
    {
        [$rutAl, $dvAl] = $this->splitRut($request->rut);
        $id   = (int) $request->id_habilitacion;
        $tipo = $request->tipo_HabilProf;

        // PrTut => '', Proyectos => lo que venga o ''
        $descripcion = ($tipo === 'PrTut') ? '' : ($request->descripcion ?? '');

        // Procesar RUTs de profesores
        $rutSup = $request->rut_profesor_supervisor ? $this->splitRut($request->rut_profesor_supervisor) : null;
        $rutCom = $request->rut_profesor_comision ? $this->splitRut($request->rut_profesor_comision) : null;
        $rutCg  = $request->rut_profesor_coguia   ? $this->splitRut($request->rut_profesor_coguia)   : null;

        $exists = DB::connection('pgsql2')
        ->table('Habilitacion_Profesional')
        ->where('id_Habilitacion', $id)
        ->exists();

        if ($exists) {
            return back()
                ->withErrors(['id_habilitacion' => 'El ID de habilitación ya existe. Elige otro.'])
                ->withInput();
        }

        DB::connection('pgsql2')->transaction(function () use ($request, $rutAl, $dvAl, $id, $tipo, $descripcion, $rutSup, $rutCom, $rutCg) {
            // Habilitación
            DB::connection('pgsql2')->table('Habilitacion_Profesional')->insert([
                'id_Habilitacion' => $id,
                'rut_Alumno'      => $rutAl,
                'DV'              => $dvAl,
                'tipo_HabilProf'  => $tipo,
                'nota'            => null,
                'descripcion'     => $descripcion,
                'semestre_inicio' => $request->semestre_inicio ?? null,
            ]);

            // Tipo habilitación
            if ($tipo === 'Pring' || $tipo === 'Pring') {
            DB::connection('pgsql2')->table('Pring')->updateOrInsert(
                ['id_Habilitacion' => $id],
                ['titulo' => $request->titulo ?? '']
            );
            } elseif ($tipo === 'Prinv' || $tipo === 'Prinv') {
                DB::connection('pgsql2')->table('Prinv')->updateOrInsert(
                    ['id_Habilitacion' => $id],
                    ['titulo' => $request->titulo ?? '']
                );
            } elseif ($tipo === 'PrTut') {
                DB::connection('pgsql2')->table('PrTut')->updateOrInsert(
                    ['id_Habilitacion' => $id],
                    [
                        'nombre_Empresa'    => $request->nombre_Empresa ?? '',
                        'nombre_Supervisor' => $request->nombre_Supervisor ?? '',
                    ]
                );
            }

            // Supervisa - Profesor Supervisor (obligatorio)
            if ($rutSup) {
                [$rutP, $dvP] = $rutSup;

                $exists = DB::connection('pgsql2')->table('Supervisa')->where([
                    'id_Habilitacion' => $id,
                    'rut_Profesor'    => $rutP,
                    'DV'              => $dvP,
                ])->exists();

                if (!$exists) {
                    $nextId = (int) DB::connection('pgsql2')->table('Supervisa')->max('id_Supervisa') + 1;

                    DB::connection('pgsql2')->table('Supervisa')->insert([
                        'id_Supervisa'    => $nextId,
                        'id_Habilitacion' => $id,
                        'rut_Profesor'    => $rutP,
                        'DV'              => $dvP,
                        'tipo_Profesor'   => 'Profesor Tutor de Práctica',
                    ]);
                }
            }

            // Supervisa - Profesor Comisión
            if ($rutCom) {
                [$rutP, $dvP] = $rutCom;

                $exists = DB::connection('pgsql2')->table('Supervisa')->where([
                    'id_Habilitacion' => $id,
                    'rut_Profesor'    => $rutP,
                    'DV'              => $dvP,
                ])->exists();

                if (!$exists) {
                    $nextId = (int) DB::connection('pgsql2')->table('Supervisa')->max('id_Supervisa') + 1;

                    DB::connection('pgsql2')->table('Supervisa')->insert([
                        'id_Supervisa'    => $nextId,
                        'id_Habilitacion' => $id,
                        'rut_Profesor'    => $rutP,
                        'DV'              => $dvP,
                        'tipo_Profesor'   => 'Profesor Comisión',
                    ]);
                }
            }

            // Supervisa - Profesor Co-guía
            if ($rutCg) {
                [$rutP, $dvP] = $rutCg;
                
                $exists = DB::connection('pgsql2')->table('Supervisa')->where([
                    'id_Habilitacion' => $id,
                    'rut_Profesor'    => $rutP,
                    'DV'              => $dvP,
                ])->exists();

                if (!$exists) {
                    $nextId = (int) DB::connection('pgsql2')->table('Supervisa')->max('id_Supervisa') + 1;

                    DB::connection('pgsql2')->table('Supervisa')->insert([
                        'id_Supervisa'    => $nextId,
                        'id_Habilitacion' => $id,
                        'rut_Profesor'    => $rutP,
                        'DV'              => $dvP,
                        'tipo_Profesor'   => 'Profesor Co-Guía',
                    ]);
                }
            }
        });

        return redirect()->route('home')->with('success', 'Habilitación guardada.');
    }

    public function edit($id)
    {
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

        default:
            // Datos por defecto si el id no existe en el switch
            $habilitacion = [
                'id_habilitacion' => $id,
                'rut' => '12345678-9',
                'nombre_alumno' => 'Juan Pérez',
                'carrera' => 'Ingeniería Civil Informática',
                'correo_alumno' => 'juan.perez@alumnos.ucsc.cl',
                'tipo_HabilProf' => 'PrIng',
                'titulo' => 'Sistema de Gestión de Prácticas',
                'descripcion' => 'Desarrollo de un sistema web para gestión de prácticas profesionales.',
                'rut_profesor_comision' => '11111111-1',
                'rut_profesor_coguia' => '22222222-2',
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