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
        $dv = substr($clean, -1);
        return [$numero, $dv];
    }

    public function store(Request $request)
    {
        [$rutAl, $dvAl] = $this->splitRut($request->rut);
        $id = (int) $request->id_habilitacion;
        $tipo = $request->tipo_HabilProf;

        $descripcion = ($tipo === 'PrTut') ? '' : ($request->descripcion ?? '');


        $rutSup = $request->rut_profesor_supervisor ? $this->splitRut($request->rut_profesor_supervisor) : null;
        $rutCom = $request->rut_profesor_comision ? $this->splitRut($request->rut_profesor_comision) : null;
        $rutCg = $request->rut_profesor_coguia ? $this->splitRut($request->rut_profesor_coguia) : null;

        // id_habilitacion único
        $idExiste = DB::table('Habilitacion_Profesional')
            ->where('id_Habilitacion', $id)
            ->exists();
        if ($idExiste) {
            return back()->withErrors([
                'id_habilitacion' => 'El ID de habilitación ya existe. Elige otro.'
            ])->withInput();
        }

        $alumnoExiste = DB::table('Alumno')
            ->where('rut_Alumno', $rutAl)
            ->where('DV', $dvAl)
            ->exists();
        if (!$alumnoExiste) {
            return back()->withErrors([
                'rut' => 'El RUT de alumno no existe en la base de datos (tabla Alumno).'
            ])->withInput();
        }

        if ($tipo === 'PrTut') {
            if (!$rutSup) {
                return back()->withErrors([
                    'rut_profesor_supervisor' => 'Debe indicar el RUT del Profesor Tutor de Práctica.'
                ])->withInput();
            }
            [$rp, $dvP] = $rutSup;
            $supExiste = DB::table('Profesor')
                ->where('rut_Profesor', $rp)
                ->where('DV', $dvP)
                ->exists();
            if (!$supExiste) {
                return back()->withErrors([
                    'rut_profesor_supervisor' => 'El Profesor Tutor no está registrado en la tabla Profesor.'
                ])->withInput();
            }
        } elseif ($tipo === 'Pring' || $tipo === 'Prinv') {
            if ($rutCom) {
                [$rp, $dvP] = $rutCom;
                $comExiste = table('Profesor')
                    ->where('rut_Profesor', $rp)
                    ->where('DV', $dvP)
                    ->exists();
                if (!$comExiste) {
                    return back()->withErrors([
                        'rut_profesor_comision' => 'El Profesor de Comisión no está en la tabla Profesor.'
                    ])->withInput();
                }
            }
            if ($rutCg) {
                [$rp, $dvP] = $rutCg;
                $cgExiste = DB::table('Profesor')
                    ->where('rut_Profesor', $rp)
                    ->where('DV', $dvP)
                    ->exists();
                if (!$cgExiste) {
                    return back()->withErrors([
                        'rut_profesor_coguia' => 'El Profesor Co-guía no está en la tabla Profesor.'
                    ])->withInput();
                }
            }
        }

        DB::transaction(function () use ($request, $rutAl, $dvAl, $id, $tipo, $descripcion, $rutSup, $rutCom, $rutCg) {
            // Habilitación base
            DB::table('Habilitacion_Profesional')->insert([
                'id_Habilitacion' => $id,
                'rut_Alumno' => $rutAl,
                'DV' => $dvAl,
                'tipo_HabilProf' => $tipo,
                'nota' => null,
                'descripcion' => $descripcion,
                'semestre_inicio' => $request->semestre_inicio ?? null,
            ]);

            if ($tipo === 'Pring') {
                DB::table('Pring')->updateOrInsert(
                    ['id_Habilitacion' => $id],
                    ['titulo' => $request->titulo ?? '']
                );
            } elseif ($tipo === 'Prinv') {
                DB::table('Prinv')->updateOrInsert(
                    ['id_Habilitacion' => $id],
                    ['titulo' => $request->titulo ?? '']
                );
            } elseif ($tipo === 'PrTut') {
                DB::table('PrTut')->updateOrInsert(
                    ['id_Habilitacion' => $id],
                    [
                        'nombre_Empresa' => $request->nombre_Empresa ?? '',
                        'nombre_Supervisor' => $request->nombre_Supervisor ?? '',
                    ]
                );
            }

            // Supervisa
            $nextId = fn() => (int) DB::table('Supervisa')->max('id_Supervisa') + 1;

            if ($tipo === 'PrTut' && $rutSup) {
                [$rp, $dvP] = $rutSup;
                $ex = DB::table('Supervisa')->where([
                    'id_Habilitacion' => $id,
                    'rut_Profesor' => $rp,
                    'DV' => $dvP,
                ])->exists();
                if (!$ex) {
                    DB::table('Supervisa')->insert([
                        'id_Supervisa' => $nextId(),
                        'id_Habilitacion' => $id,
                        'rut_Profesor' => $rp,
                        'DV' => $dvP,
                        'tipo_Profesor' => 'Profesor Tutor de Práctica',
                    ]);
                }
            }

            if (($tipo === 'Pring' || $tipo === 'Prinv') && $rutCom) {
                [$rp, $dvP] = $rutCom;
                $ex = DB::table('Supervisa')->where([
                    'id_Habilitacion' => $id,
                    'rut_Profesor' => $rp,
                    'DV' => $dvP,
                ])->exists();
                if (!$ex) {
                    DB::table('Supervisa')->insert([
                        'id_Supervisa' => $nextId(),
                        'id_Habilitacion' => $id,
                        'rut_Profesor' => $rp,
                        'DV' => $dvP,
                        'tipo_Profesor' => 'Profesor Comisión',
                    ]);
                }
            }

            if (($tipo === 'Pring' || $tipo === 'Prinv') && $rutCg) {
                [$rp, $dvP] = $rutCg;
                $ex = DB::table('Supervisa')->where([
                    'id_Habilitacion' => $id,
                    'rut_Profesor' => $rp,
                    'DV' => $dvP,
                ])->exists();
                if (!$ex) {
                    DB::table('Supervisa')->insert([
                        'id_Supervisa' => $nextId(),
                        'id_Habilitacion' => $id,
                        'rut_Profesor' => $rp,
                        'DV' => $dvP,
                        'tipo_Profesor' => 'Profesor Co-Guía',
                    ]);
                }
            }
        });

        return redirect()->route('home')->with('success', 'Habilitación guardada.');
    }

    public function update(Request $request, $id)
    {
        // VA AL HOME.
        return redirect()->route('home')->with('ok', "Habilitacion #$id actualizada (mock).");
    }
}