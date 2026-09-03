<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Validaciones;
use Illuminate\Validation\ValidationException;
class ListadoSemestralController extends Controller
{

    public function ListadoSemestral()
    {
        return view('habilitaciones.Listados.FormularioSemestral'); // Creamos esta vista
    }


    public function ResultadoListadoSemestral(Request $request)
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
        $solo_semestre = $request->has('solo_semestre');

        $query = DB::table('Alumno')
            ->join('Habilitacion_Profesional', 'Habilitacion_Profesional.rut_Alumno', '=', 'Alumno.rut_Alumno')
            ->leftJoin('Pring', 'Pring.id_Habilitacion', '=', 'Habilitacion_Profesional.id_Habilitacion')
            ->leftJoin('Prinv', 'Prinv.id_Habilitacion', '=', 'Habilitacion_Profesional.id_Habilitacion')
            ->leftJoin('PrTut', 'PrTut.id_Habilitacion', '=', 'Habilitacion_Profesional.id_Habilitacion')
            ->select(
                'Alumno.rut_Alumno',
                'Alumno.DV',
                'Alumno.nombre_Alumno',
                'Habilitacion_Profesional.tipo_HabilProf',
                'Habilitacion_Profesional.semestre_inicio',
                'Habilitacion_Profesional.nota',
                'Habilitacion_Profesional.descripcion',
                'Pring.titulo as titulo_Pring',
                'Prinv.titulo as titulo_Prinv',
                'PrTut.nombre_Empresa',
                'PrTut.nombre_Supervisor'
            );

        if ($solo_semestre) {
            $query->where('Habilitacion_Profesional.semestre_inicio', '=', $semestre_inicio);
        } else {
            $query->where('Habilitacion_Profesional.semestre_inicio', '>=', $semestre_inicio);
        }

        $habilitaciones = $query
            ->orderBy('Habilitacion_Profesional.semestre_inicio', 'asc')
            ->get();

        foreach ($habilitaciones as $registro) {

            if (!Validaciones::validar_rut($registro->rut_Alumno)) {
                throw ValidationException::withMessages([
                    'rut_Alumno' => "El RUT debe tener entre 7 y 8 dígitos numéricos."
                ]);
            }

            if (!Validaciones::validar_DV($registro->DV)) {
                throw ValidationException::withMessages([
                    'DV' => "El dígito verificador ingresado no es válido."
                ]);
            }

            if (!Validaciones::validar_nombre($registro->nombre_Alumno)) {
                throw ValidationException::withMessages([
                    'nombre_Alumno' => "Nombre del alumno debe tener un máximo de 40 caracteres."
                ]);
            }
            if (!Validaciones::validar_tipoHabilitacion($registro->tipo_HabilProf)) {
                throw ValidationException::withMessages([
                    'tipo_Profesor' => "Tipo Habilitación no válido."
                ]);
            }
            if (!Validaciones::validar_nombre_empresa($registro->nombre_Empresa)) {
                throw ValidationException::withMessages(['nombre_Empresa' => "Nombre empresa debe tener una maximo de 100 caracteres"]);
            }
            if (!Validaciones::validar_nombre_supervisor($registro->nombre_Supervisor)) {
                throw ValidationException::withMessages(['nombre_Supervisor' => "Nombre supervisor debe tener una maximo de 80 caracteres"]);
            }
            if (!Validaciones::validar_titulo($registro->titulo_Pring)) {
                throw ValidationException::withMessages(['titulo_Pring' => "Titulo proyecto ingeniería debe tener una maximo de 100 caracteres"]);
            }
            if (!Validaciones::validar_titulo($registro->titulo_Prinv)) {
                throw ValidationException::withMessages(['titulo_Prinv' => "Titulo proyecto investigación debe tener una maximo de 100 caracteres"]);
            }
            if (!Validaciones::validar_descripcion($registro->descripcion)) {
                    throw ValidationException::withMessages(['descripcion' => "descripción debe tener una maximo de 100 caracteres"]);
                }
        }


        return view('habilitaciones.Listados.ResultadoSemestral', compact('habilitaciones', 'semestre_inicio', 'solo_semestre'));
    }


    public function ultimasHabilitaciones()
    {
        $ultimas = DB::table('Alumno')
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
        foreach ($ultimas as $registro) {

            if (!Validaciones::validar_rut($registro->rut_Alumno)) {
                throw ValidationException::withMessages([
                    'rut_Alumno' => "El RUT debe tener entre 7 y 8 dígitos numéricos."
                ]);
            }

            if (!Validaciones::validar_DV($registro->DV)) {
                throw ValidationException::withMessages([
                    'DV' => "El dígito verificador no es válido."
                ]);
            }

            if (!Validaciones::validar_nombre($registro->nombre_Alumno)) {
                throw ValidationException::withMessages([
                    'nombre_Alumno' => "El nombre del alumno no puede superar los 40 caracteres."
                ]);
            }

            if (!Validaciones::validar_tipoHabilitacion($registro->tipo_HabilProf)) {
                throw ValidationException::withMessages([
                    'tipo_HabilProf' => "El tipo de habilitación no es válido."
                ]);
            }
        }


        // Conteo
        $countPring = DB::table('Habilitacion_Profesional')
            ->where('tipo_HabilProf', 'Pring')
            ->whereNull('nota')
            ->count();

        $countPrinv = DB::table('Habilitacion_Profesional')
            ->where('tipo_HabilProf', 'Prinv')
            ->whereNull('nota')
            ->count();

        $countPrTut = DB::table('Habilitacion_Profesional')
            ->where('tipo_HabilProf', 'PrTut')
            ->whereNull('nota')
            ->count();

        $total = $countPring + $countPrinv + $countPrTut;

        return view('welcome', compact('ultimas', 'countPring', 'countPrinv', 'countPrTut', 'total'));
    }
}
