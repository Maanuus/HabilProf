<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumnos = [
            [
                'rut_Alumno' => 20111222,
                'DV' => '3',
                'nombre_Alumno' => 'Matias Nicolas Alarcon Valenzuela',
                'carrera' => 'Ingenieria Civil Informatica',
                'correo_Alumno' => 'malarcon@ing.ucsc.cl',
            ],
            [
                'rut_Alumno' => 20222333,
                'DV' => '4',
                'nombre_Alumno' => 'Camila Andrea Baeza Carrasco',
                'carrera' => 'Ingenieria Civil Informatica',
                'correo_Alumno' => 'cbaeza@ing.ucsc.cl',
            ],
            [
                'rut_Alumno' => 20333444,
                'DV' => '5',
                'nombre_Alumno' => 'Felipe Ignacio Cardenas Munoz',
                'carrera' => 'Ingenieria Civil Informatica',
                'correo_Alumno' => 'fcardenas@ing.ucsc.cl',
            ],
            [
                'rut_Alumno' => 20444555,
                'DV' => '6',
                'nombre_Alumno' => 'Valentina Paz Sepulveda Diaz',
                'carrera' => 'Ingenieria Civil Informatica',
                'correo_Alumno' => 'vsepulveda@ing.ucsc.cl',
            ],
            [
                'rut_Alumno' => 20555666,
                'DV' => '7',
                'nombre_Alumno' => 'Diego Alonso Vargas Pino',
                'carrera' => 'Ingenieria Civil Informatica',
                'correo_Alumno' => 'dvargas@ing.ucsc.cl',
            ],
            [
                'rut_Alumno' => 20666777,
                'DV' => '8',
                'nombre_Alumno' => 'Javiera Ignacia Fuentes Vega',
                'carrera' => 'Ingenieria Civil Informatica',
                'correo_Alumno' => 'jfuentes@ing.ucsc.cl',
            ],
            [
                'rut_Alumno' => 20777888,
                'DV' => '9',
                'nombre_Alumno' => 'Tomas Eduardo Morales Rivas',
                'carrera' => 'Ingenieria Civil Informatica',
                'correo_Alumno' => 'tmorales@ing.ucsc.cl',
            ],
        ];

        foreach ($alumnos as $alumno) {
            DB::table('Alumno')->updateOrInsert(
                [
                    'rut_Alumno' => $alumno['rut_Alumno'],
                    'DV' => $alumno['DV'],
                ],
                [
                    'nombre_Alumno' => $alumno['nombre_Alumno'],
                    'carrera' => $alumno['carrera'],
                    'correo_Alumno' => $alumno['correo_Alumno'],
                ]
            );
        }
    }
}
