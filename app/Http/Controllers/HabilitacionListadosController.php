<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HabilitacionListadosController extends Controller
{
    // Muestra el formulario para filtrar por semestre
    public function historicoForm()
    {
        return view('habilitaciones.historicoForm'); // Creamos esta vista
    }

    // Procesa el formulario y muestra los resultados
    public function historicoResultados(Request $request)
    {
        $request->validate([
            'semestre_inicio' => [
                'required',
                'regex:/^(199[0-9]|20[0-3][0-9]|204[0-5])-(1|2)$/'
            ],
        ], [
            'semestre_inicio.regex' => 'El formato debe ser AAAA-S, donde el año esté entre 1990 y 2045, y S sea 1 o 2.'
        ]);

        $semestre_inicio = $request->input('semestre_inicio');
        $solo_semestre = $request->has('solo_semestre'); // true si el checkbox está marcado

        $query = DB::connection('pgsql2')
            ->table('Alumno')
            ->join('Habilitacion_Profesional', 'Habilitacion_Profesional.rut_Alumno', '=', 'Alumno.rut_Alumno')
            ->select(
                'Alumno.rut_Alumno',
                'Alumno.DV',
                'Alumno.nombre_Alumno',
                DB::raw('"Habilitacion_Profesional"."tipo_HabilProf" AS "tipo_HabilProf"'),
                'Habilitacion_Profesional.semestre_inicio',
                'Habilitacion_Profesional.nota',
                'Habilitacion_Profesional.descripcion'
            );

        if ($solo_semestre) {
            $query->where('Habilitacion_Profesional.semestre_inicio', '=', $semestre_inicio);
        } else {
            $query->where('Habilitacion_Profesional.semestre_inicio', '>=', $semestre_inicio);
        }

        $habilitaciones = $query
            ->orderBy('Habilitacion_Profesional.semestre_inicio', 'asc')
            ->get();

        return view('habilitaciones.HistoricoResultados', compact('habilitaciones', 'semestre_inicio', 'solo_semestre'));
    }
    public function ultimasHabilitaciones()
    {
        $ultimas = DB::connection('pgsql2')
            ->table('Alumno')
            ->join('Habilitacion_Profesional', 'Habilitacion_Profesional.rut_Alumno', '=', 'Alumno.rut_Alumno')
            ->select(
                'Alumno.rut_Alumno',
                'Alumno.DV',
                'Alumno.nombre_Alumno',
                DB::raw('"Habilitacion_Profesional"."tipo_HabilProf" AS "tipo_HabilProf"'),
                'Habilitacion_Profesional.semestre_inicio',
                'Habilitacion_Profesional.nota',
                'Habilitacion_Profesional.descripcion'
            )
            ->orderBy('Habilitacion_Profesional.semestre_inicio', 'desc') // últimas primero
            ->limit(5) // solo las 5 últimas
            ->get();
        // Conteos por tipo considerando solo activas
        $countPring = DB::connection('pgsql2')
            ->table('Habilitacion_Profesional')
            ->where('tipo_HabilProf', 'Pring')
            ->whereNull('nota')
            ->count();

        $countPrinv = DB::connection('pgsql2')
            ->table('Habilitacion_Profesional')
            ->where('tipo_HabilProf', 'Prinv')
            ->whereNull('nota')
            ->count();

        $countPrTut = DB::connection('pgsql2')
            ->table('Habilitacion_Profesional')
            ->where('tipo_HabilProf', 'PrTut')
            ->whereNull('nota')
            ->count();

        $total = $countPring + $countPrinv + $countPrTut;

        return view('welcome', compact('ultimas', 'countPring', 'countPrinv', 'countPrTut', 'total'));
    }
    public function profesorForm()
    {
        return view('habilitaciones.ProfesorForm');
    }

    public function profesorResultados(Request $request)
    {
        $request->validate([
            'rut_profesor' => [
                'required',
                'regex:/^\d{7,8}-[0-9Kk]$/'
            ],
            'semestre_inicio' => [
                'required',
                'regex:/^(199[0-9]|20[0-3][0-9]|204[0-5])-(1|2)$/'
            ],
        ], [
            'rut_profesor.regex' => 'El RUT debe tener el formato 12345678-K.',
            'semestre_inicio.regex' => 'El formato debe ser AAAA-S, donde el año esté entre 1990 y 2045, y S sea 1 o 2.'
        ]);

        // 🔹 Separar número y DV
        [$rut_num, $dv] = explode('-', str_replace(' ', '', strtoupper($request->rut_profesor)));

        $semestre_inicio = $request->input('semestre_inicio');
        $solo_semestre = $request->has('solo_semestre');

        $query = DB::connection('pgsql2')
            ->table('Profesor')
            ->join('Supervisa', function ($join) {
                $join->on('Supervisa.rut_Profesor', '=', 'Profesor.rut_Profesor')
                    ->on('Supervisa.DV', '=', 'Profesor.DV');
            })
            ->join('Habilitacion_Profesional', 'Habilitacion_Profesional.id_Habilitacion', '=', 'Supervisa.id_Habilitacion')
            ->join('Alumno', function ($join) {
                $join->on('Alumno.rut_Alumno', '=', 'Habilitacion_Profesional.rut_Alumno')
                    ->on('Alumno.DV', '=', 'Habilitacion_Profesional.DV');
            })
            ->select(
                'Profesor.rut_Profesor',
                'Profesor.DV',
                'Profesor.nombre_Profesor',
                'Supervisa.tipo_Profesor',
                'Alumno.rut_Alumno',
                'Alumno.DV AS DV_Alumno',
                'Alumno.nombre_Alumno',
                'Habilitacion_Profesional.tipo_HabilProf',
                'Habilitacion_Profesional.semestre_inicio',
                'Habilitacion_Profesional.nota',
                'Habilitacion_Profesional.descripcion'
            )
            ->where('Profesor.rut_Profesor', '=', (int) $rut_num)
            ->where('Profesor.DV', '=', $dv);

        if ($solo_semestre) {
            $query->where('Habilitacion_Profesional.semestre_inicio', '=', $semestre_inicio);
        } else {
            $query->where('Habilitacion_Profesional.semestre_inicio', '>=', $semestre_inicio);
        }

        $habilitaciones = $query->orderBy('Habilitacion_Profesional.semestre_inicio', 'asc')->get();

        // Enviar también el RUT y semestre a la vista
        return view('habilitaciones.ProfesorResultados', [
            'habilitaciones' => $habilitaciones,
            'rut_profesor' => "$rut_num-$dv",
            'semestre_inicio' => $semestre_inicio,
            'solo_semestre' => $solo_semestre,
        ]);
    }


}
