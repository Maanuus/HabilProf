<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HabilitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Habilitaciones Principales (3 Pring, 2 Prinv, 2 PrTut)
        $habilitaciones = [
            // --- Proyecto de Ingeniería (Pring) ---
            [
                'id_Habilitacion' => 101,
                'nota' => 6.5,
                'descripcion' => 'Optimizacion de logistica portuaria con arquitectura de microservicios',
                'rut_Alumno' => 20111222,
                'DV' => '3',
                'tipo_HabilProf' => 'Pring',
                'semestre_inicio' => '2024-1',
            ],
            [
                'id_Habilitacion' => 102,
                'nota' => null, // En curso
                'descripcion' => 'Sistema IoT de monitoreo de variables ambientales en tiempo real',
                'rut_Alumno' => 20222333,
                'DV' => '4',
                'tipo_HabilProf' => 'Pring',
                'semestre_inicio' => '2024-2',
            ],
            [
                'id_Habilitacion' => 103,
                'nota' => 5.9,
                'descripcion' => 'Diseno e implementacion de API REST para gestion academica universitaria',
                'rut_Alumno' => 20777888,
                'DV' => '9',
                'tipo_HabilProf' => 'Pring',
                'semestre_inicio' => '2025-1',
            ],

            // --- Proyecto de Investigación (Prinv) ---
            [
                'id_Habilitacion' => 201,
                'nota' => 6.8,
                'descripcion' => 'Analisis comparativo de modelos Transformer en generacion de codigo',
                'rut_Alumno' => 20333444,
                'DV' => '5',
                'tipo_HabilProf' => 'Prinv',
                'semestre_inicio' => '2024-1',
            ],
            [
                'id_Habilitacion' => 202,
                'nota' => null, // En curso
                'descripcion' => 'Aprendizaje federado con privacidad diferencial en redes hospitalarias',
                'rut_Alumno' => 20444555,
                'DV' => '6',
                'tipo_HabilProf' => 'Prinv',
                'semestre_inicio' => '2024-2',
            ],

            // --- Práctica Tutelada (PrTut) ---
            [
                'id_Habilitacion' => 301,
                'nota' => 6.2,
                'descripcion' => 'Practica profesional en area de infraestructura Cloud y pipelines CI CD',
                'rut_Alumno' => 20555666,
                'DV' => '7',
                'tipo_HabilProf' => 'PrTut',
                'semestre_inicio' => '2024-2',
            ],
            [
                'id_Habilitacion' => 302,
                'nota' => null, // En curso
                'descripcion' => 'Desarrollo de modulos ERP y automatizacion de pruebas funcionales',
                'rut_Alumno' => 20666777,
                'DV' => '8',
                'tipo_HabilProf' => 'PrTut',
                'semestre_inicio' => '2025-1',
            ],
        ];

        foreach ($habilitaciones as $h) {
            DB::table('Habilitacion_Profesional')->updateOrInsert(
                ['id_Habilitacion' => $h['id_Habilitacion']],
                [
                    'nota' => $h['nota'],
                    'descripcion' => $h['descripcion'],
                    'rut_Alumno' => $h['rut_Alumno'],
                    'DV' => $h['DV'],
                    'tipo_HabilProf' => $h['tipo_HabilProf'],
                    'semestre_inicio' => $h['semestre_inicio'],
                ]
            );
        }

        // 2. Subtipo Proyecto de Ingeniería (Pring)
        $prings = [
            [
                'id_Habilitacion' => 101,
                'titulo' => 'Plataforma Cloud de Gestion y Trazabilidad Portuaria',
            ],
            [
                'id_Habilitacion' => 102,
                'titulo' => 'Arquitectura IoT para Monitoreo de Variables Urbanas',
            ],
            [
                'id_Habilitacion' => 103,
                'titulo' => 'API REST Escalable para Integracion Curricular',
            ],
        ];

        foreach ($prings as $pring) {
            DB::table('Pring')->updateOrInsert(
                ['id_Habilitacion' => $pring['id_Habilitacion']],
                ['titulo' => $pring['titulo']]
            );
        }

        // 3. Subtipo Proyecto de Investigación (Prinv)
        $prinvs = [
            [
                'id_Habilitacion' => 201,
                'titulo' => 'Evaluacion de Modelos LLM en Refactorizacion Automatica',
            ],
            [
                'id_Habilitacion' => 202,
                'titulo' => 'Aprendizaje Federado Seguro en Redes Distribuidas',
            ],
        ];

        foreach ($prinvs as $prinv) {
            DB::table('Prinv')->updateOrInsert(
                ['id_Habilitacion' => $prinv['id_Habilitacion']],
                ['titulo' => $prinv['titulo']]
            );
        }

        // 4. Subtipo Práctica Tutelada (PrTut)
        $prtuts = [
            [
                'id_Habilitacion' => 301,
                'nombre_Empresa' => 'Synopsys Chile',
                'nombre_Supervisor' => 'Mauricio Gonzalez Reyes',
            ],
            [
                'id_Habilitacion' => 302,
                'nombre_Empresa' => 'Capgemini Chile',
                'nombre_Supervisor' => 'Marcela Troncoso Silva',
            ],
        ];

        foreach ($prtuts as $prtut) {
            DB::table('PrTut')->updateOrInsert(
                ['id_Habilitacion' => $prtut['id_Habilitacion']],
                [
                    'nombre_Empresa' => $prtut['nombre_Empresa'],
                    'nombre_Supervisor' => $prtut['nombre_Supervisor'],
                ]
            );
        }

        // 5. Asignaciones Docentes (Supervisa)
        $colTipoProfesor = Schema::hasColumn('Supervisa', 'tipo_Profesor') ? 'tipo_Profesor' : 'tipo_Profeosr';

        $supervisiones = [
            // Hab 101 (Pring)
            [
                'id_Habilitacion' => 101,
                'rut_Profesor' => 11223344,
                'DV' => '5',
                'tipo' => 'Profesor Guía',
            ],
            [
                'id_Habilitacion' => 101,
                'rut_Profesor' => 12345678,
                'DV' => '9',
                'tipo' => 'Profesor Comisión',
            ],

            // Hab 102 (Pring)
            [
                'id_Habilitacion' => 102,
                'rut_Profesor' => 13456789,
                'DV' => 'K',
                'tipo' => 'Profesor Guía',
            ],
            [
                'id_Habilitacion' => 102,
                'rut_Profesor' => 14567890,
                'DV' => '1',
                'tipo' => 'Profesor Co-Guía',
            ],

            // Hab 103 (Pring)
            [
                'id_Habilitacion' => 103,
                'rut_Profesor' => 11223344,
                'DV' => '5',
                'tipo' => 'Profesor Guía',
            ],
            [
                'id_Habilitacion' => 103,
                'rut_Profesor' => 13456789,
                'DV' => 'K',
                'tipo' => 'Profesor Comisión',
            ],

            // Hab 201 (Prinv)
            [
                'id_Habilitacion' => 201,
                'rut_Profesor' => 13456789,
                'DV' => 'K',
                'tipo' => 'Profesor Guía',
            ],
            [
                'id_Habilitacion' => 201,
                'rut_Profesor' => 11223344,
                'DV' => '5',
                'tipo' => 'Profesor Comisión',
            ],

            // Hab 202 (Prinv)
            [
                'id_Habilitacion' => 202,
                'rut_Profesor' => 14567890,
                'DV' => '1',
                'tipo' => 'Profesor Guía',
            ],
            [
                'id_Habilitacion' => 202,
                'rut_Profesor' => 12345678,
                'DV' => '9',
                'tipo' => 'Profesor Comisión',
            ],

            // Hab 301 (PrTut)
            [
                'id_Habilitacion' => 301,
                'rut_Profesor' => 12345678,
                'DV' => '9',
                'tipo' => 'Profesor Tutor de Práctica',
            ],

            // Hab 302 (PrTut)
            [
                'id_Habilitacion' => 302,
                'rut_Profesor' => 14567890,
                'DV' => '1',
                'tipo' => 'Profesor Tutor de Práctica',
            ],
        ];

        foreach ($supervisiones as $s) {
            DB::table('Supervisa')->updateOrInsert(
                [
                    'id_Habilitacion' => $s['id_Habilitacion'],
                    'rut_Profesor' => $s['rut_Profesor'],
                    'DV' => $s['DV'],
                ],
                [
                    $colTipoProfesor => $s['tipo'],
                ]
            );
        }
    }
}
