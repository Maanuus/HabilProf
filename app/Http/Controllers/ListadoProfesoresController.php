<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Validaciones;
use Illuminate\Validation\ValidationException;

class ListadoProfesoresController extends Controller
{
    public function ListadoProfesores()
    {
        return view('habilitaciones.Listados.FormularioProfesor');
    }

    public function ResultadoListadoProfesores(Request $request)
    {
        //Validaciones de datos de entrada del formulario.
        $request->validate([
            'rut_profesor' => 'required|integer',
            'dv' => 'required|string|max:1',
            'semestre_inicio' => 'required'
        ]);

        $errores = [];

        if (!Validaciones::validar_rut($request->rut_profesor)) {
            $errores['rut_profesor'] = 'El RUT debe tener entre 7 y 8 dígitos numéricos.';
        }

        if (!Validaciones::validar_DV($request->dv)) {
            $errores['dv'] = 'El dígito verificador ingresado no es válido.';
        }

        if (!Validaciones::validar_semestre($request->semestre_inicio)) {
            $errores['semestre_inicio'] = 'El formato del semestre debe ser, por ejemplo, 2024-1.';
        }

        if (!empty($errores)) {
            throw ValidationException::withMessages($errores);
        }

        $rut_profesor = $request->rut_profesor;
        $dv = $request->dv;
        $semestre = $request->semestre_inicio;
        $solo_semestre = $request->has('solo_semestre'); // checkbox

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
                'Supervisa.rut_Profesor',
                'Supervisa.DV as DV_profesor',
                'Supervisa.tipo_Profesor',
                'Alumno.rut_Alumno',
                'Alumno.DV as DV_alumno',
                'Alumno.nombre_Alumno',
                'Habilitacion_Profesional.tipo_HabilProf',
                'Habilitacion_Profesional.semestre_inicio'
            )
            ->where('Supervisa.rut_Profesor', $rut_profesor)
            ->where('Supervisa.DV', $dv);


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

        //Validaciones de datos que se extraen desde la base de datos.
        foreach ($resultados as $tipoProfesor => $grupo)
            foreach ($grupo as $registro) {
                if (!Validaciones::validar_rut($registro->rut_Profesor)) {
                    throw ValidationException::withMessages(['rut_Profesor' => "El RUT debe tener entre 7 y 8 dígitos numéricos."]);
                }
                if (!Validaciones::validar_DV($registro->DV_profesor)) {
                    throw ValidationException::withMessages(['DV' => "El dígito verificador ingresado no es válido."]);
                }
                if (!Validaciones::validar_nombre($registro->nombre_Profesor)) {
                    throw ValidationException::withMessages(['nombre_Profesor' => "Nombre profesor debe tener una maximo de 40 caracteres"]);
                }
                if (!Validaciones::validar_tipoProfesor($registro->tipo_Profesor)) {
                    throw ValidationException::withMessages([
                        'tipo_Profesor' => "Tipo Profesor no es válido."
                    ]);
                }
                if (!Validaciones::validar_rut($registro->rut_Alumno)) {
                    throw ValidationException::withMessages(['rut_Alumno' => "El RUT debe tener entre 7 y 8 dígitos numéricos."]);
                }
                if (!Validaciones::validar_DV($registro->DV_alumno)) {
                    throw ValidationException::withMessages(['DV' => "El dígito verificador ingresado no es válido."]);
                }
                if (!Validaciones::validar_nombre($registro->nombre_Alumno)) {
                    throw ValidationException::withMessages(['nombre_Alumno' => "Nombre profesor debe tener una maximo de 40 caracteres"]);
                }
                if (!Validaciones::validar_tipoHabilitacion($registro->tipo_HabilProf)) {
                    throw ValidationException::withMessages([
                        'tipo_Profesor' => "Tipo Habilitación no válido."
                    ]);
                }
            }

        return view('habilitaciones.Listados.ResultadosProfesor', [
            'resultados' => $resultados
        ]);
    }
}
