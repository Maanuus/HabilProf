<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HabilitacionProfesorController extends Controller
{
    public function form()
    {
        return view('habilitaciones.profesor.form');
    }

    public function resultados(Request $request)
    {
        $request->validate([
            'rut_profesor' => 'required|integer',
            'dv' => 'required|string|max:1',
            'semestre_inicio' => 'required'
        ]);

        $rut_profesor = $request->rut_profesor;
        $dv = $request->dv;
        $semestre = $request->semestre_inicio;
        $solo_semestre = $request->has('solo_semestre'); // <- checkbox

        $query = DB::connection('pgsql2')->table('Supervisa')
            ->join('Profesor', function ($join) {
                $join->on('Supervisa.rut_Profesor', '=', 'Profesor.rut_Profesor')
                    ->on('Supervisa.DV', '=', 'Profesor.DV');
            })
            ->join('Habilitacion_Profesional', 'Supervisa.id_Habilitacion', '=', 'Habilitacion_Profesional.id_Habilitacion')
            ->join('Alumno', function ($join) {
                $join->on('Alumno.rut_Alumno', '=', 'Habilitacion_Profesional.rut_Alumno')
                    ->on('Alumno.DV', '=', 'Habilitacion_Profesional.DV');
            })
            ->select(
                'Profesor.nombre_Profesor',
                'Supervisa.tipo_Profesor',
                'Alumno.rut_Alumno',
                'Alumno.DV',
                'Alumno.nombre_Alumno',
                'Habilitacion_Profesional.tipo_HabilProf',
                'Habilitacion_Profesional.semestre_inicio'
            )
            ->where('Supervisa.rut_Profesor', $rut_profesor)
            ->where('Supervisa.DV', $dv);

        // Aquí aplicamos el filtro del semestre según el checkbox
        if ($solo_semestre) {
            $query->where('Habilitacion_Profesional.semestre_inicio', '=', $semestre);
        } else {
            $query->where('Habilitacion_Profesional.semestre_inicio', '>=', $semestre);
        }

        $resultados = $query
            ->orderBy('Supervisa.tipo_Profesor')
            ->orderBy('Habilitacion_Profesional.semestre_inicio')
            ->get()
            ->groupBy('tipo_Profesor');

        return view('habilitaciones.profesor.resultados', [
            'resultados' => $resultados
        ]);
    }
}
