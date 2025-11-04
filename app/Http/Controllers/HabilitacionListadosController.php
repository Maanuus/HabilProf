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
            'semestre_inicio' => 'required|string',
        ]);

        $semestre_inicio = $request->input('semestre_inicio');

        $habilitaciones = DB::connection('pgsql2') // conexión explícita a HabilProf2
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
            ->where('Habilitacion_Profesional.semestre_inicio', '>=', $semestre_inicio)
            ->orderBy('Habilitacion_Profesional.semestre_inicio', 'asc')
            ->get();

        return view('habilitaciones.HistoricoResultados', compact('habilitaciones', 'semestre_inicio'));
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





}
