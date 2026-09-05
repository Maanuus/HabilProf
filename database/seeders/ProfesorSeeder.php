<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profesores = [
            [
                'rut_Profesor' => 11223344,
                'DV' => '5',
                'nombre_Profesor' => 'Roberto Fernandez Soto',
                'correo_Profesor' => 'rfernandez@ucsc.cl',
            ],
            [
                'rut_Profesor' => 12345678,
                'DV' => '9',
                'nombre_Profesor' => 'Patricia Morales Lagos',
                'correo_Profesor' => 'pmorales@ucsc.cl',
            ],
            [
                'rut_Profesor' => 13456789,
                'DV' => 'K',
                'nombre_Profesor' => 'Alejandro Silva Castro',
                'correo_Profesor' => 'asilva@ucsc.cl',
            ],
            [
                'rut_Profesor' => 14567890,
                'DV' => '1',
                'nombre_Profesor' => 'Claudia Benavides Ruiz',
                'correo_Profesor' => 'cbenavides@ucsc.cl',
            ],
        ];

        foreach ($profesores as $profesor) {
            DB::table('Profesor')->updateOrInsert(
                [
                    'rut_Profesor' => $profesor['rut_Profesor'],
                    'DV' => $profesor['DV'],
                ],
                [
                    'nombre_Profesor' => $profesor['nombre_Profesor'],
                    'correo_Profesor' => $profesor['correo_Profesor'],
                ]
            );
        }
    }
}
