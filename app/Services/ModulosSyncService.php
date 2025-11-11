<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

/**
 * Servicio de sincronización mínima con la BD Modulos.
 * - Detecta registros incompletos (Alumno/Profesor)
 * - Completa campos faltantes consultando Modulos
 * - Sincroniza notas desde Modulos.Notas hacia Habilitacion_Profesional
 *
 * Alcance: versión mínima sin tablas de alertas ni auditoría.
 */
class ModulosSyncService
{
    /**
     * Obtiene listados de alumnos y profesores con datos incompletos en HabilProf2.
     * @return array{alumnos: \Illuminate\Support\Collection, profesores: \Illuminate\Support\Collection}
     */
    public function obtenerIncompletos(): array
    {
        $alumnos = DB::connection('pgsql2')
            ->table('Alumno')
            ->where(function ($q) {
                $q->whereNull('nombre_Alumno')->orWhere('nombre_Alumno', '')
                  ->orWhereNull('carrera')->orWhere('carrera', '')
                  ->orWhereNull('correo_Alumno')->orWhere('correo_Alumno', '');
            })
            ->get();

        $profesores = DB::connection('pgsql2')
            ->table('Profesor')
            ->where(function ($q) {
                $q->whereNull('nombre_Profesor')->orWhere('nombre_Profesor', '')
                  ->orWhereNull('correo_Profesor')->orWhere('correo_Profesor', '');
            })
            ->get();

        return [
            'alumnos' => $alumnos,
            'profesores' => $profesores,
        ];
    }

    /**
     * Completa únicamente campos faltantes para alumnos y profesores utilizando Modulos.
     * No sobreescribe información ya existente.
     * @return array
     */
    public function completarIncompletos(): array
    {
        $res = [
            'alumnos_actualizados' => 0,
            'profesores_actualizados' => 0,
            'errores' => [],
        ];

        // Alumnos
        $alumnos = DB::connection('pgsql2')->table('Alumno')
            ->where(function ($q) {
                $q->whereNull('nombre_Alumno')->orWhere('nombre_Alumno', '')
                  ->orWhereNull('carrera')->orWhere('carrera', '')
                  ->orWhereNull('correo_Alumno')->orWhere('correo_Alumno', '');
            })
            ->get();

        foreach ($alumnos as $a) {
            $mod = DB::connection('Modulos')->table('Alumno')
                ->where('rut_Alumno', $a->rut_Alumno)
                ->where('DV', $a->DV)
                ->first();

            if (!$mod) {
                $res['errores'][] = "Alumno {$a->rut_Alumno}-{$a->DV} no existe en Modulos";
                continue;
            }

            $update = [];
            if (empty($a->nombre_Alumno) && !empty($mod->nombre_Alumno)) {
                $update['nombre_Alumno'] = $mod->nombre_Alumno;
            }
            if (empty($a->carrera) && !empty($mod->carrera)) {
                $update['carrera'] = $mod->carrera;
            }
            if (empty($a->correo_Alumno) && !empty($mod->correo_Alumno)) {
                if ($this->validarCorreoIng($mod->correo_Alumno)) {
                    $update['correo_Alumno'] = $mod->correo_Alumno;
                }
            }

            if (!empty($update)) {
                DB::connection('pgsql2')->table('Alumno')
                    ->where('rut_Alumno', $a->rut_Alumno)
                    ->where('DV', $a->DV)
                    ->update($update);
                $res['alumnos_actualizados']++;
            }
        }

        // Profesores
        $profesores = DB::connection('pgsql2')->table('Profesor')
            ->where(function ($q) {
                $q->whereNull('nombre_Profesor')->orWhere('nombre_Profesor', '')
                  ->orWhereNull('correo_Profesor')->orWhere('correo_Profesor', '');
            })
            ->get();

        foreach ($profesores as $p) {
            $modP = DB::connection('Modulos')->table('Profesor')
                ->where('rut_Profesor', $p->rut_Profesor)
                ->where('DV', $p->DV)
                ->first();

            if (!$modP) {
                $res['errores'][] = "Profesor {$p->rut_Profesor}-{$p->DV} no existe en Modulos";
                continue;
            }

            $update = [];
            if (empty($p->nombre_Profesor) && !empty($modP->nombre_Profesor)) {
                $update['nombre_Profesor'] = $modP->nombre_Profesor;
            }
            if (empty($p->correo_Profesor) && !empty($modP->correo_Profesor)) {
                if ($this->validarCorreoUcsc($modP->correo_Profesor)) {
                    $update['correo_Profesor'] = $modP->correo_Profesor;
                }
            }

            if (!empty($update)) {
                DB::connection('pgsql2')->table('Profesor')
                    ->where('rut_Profesor', $p->rut_Profesor)
                    ->where('DV', $p->DV)
                    ->update($update);
                $res['profesores_actualizados']++;
            }
        }

        return $res;
    }

    /**
     * Sincroniza notas desde Modulos.Notas a Habilitacion_Profesional.
     * @return array
     */
    public function sincronizarNotas(): array
    {
        $notas = DB::connection('Modulos')->table('Notas')->get();
        $total = 0; $aprobadas = 0; $reprobadas = 0;

        foreach ($notas as $n) {
            $total++;
            $hab = DB::connection('pgsql2')->table('Habilitacion_Profesional')
                ->where('rut_Alumno', $n->rut_Alumno)
                ->where('DV', $n->DV)
                ->first();

            if (!$hab) {
                continue;
            }

            $estado = $n->nota_Alumno >= 4.0 ? 'Aprobado' : 'Reprobado';

            DB::connection('pgsql2')->table('Habilitacion_Profesional')
                ->where('id_Habilitacion', $hab->id_Habilitacion)
                ->update([
                    'nota' => $n->nota_Alumno,
                    // 'nota_status' => $estado, // si luego agregan la columna
                ]);

            if ($estado === 'Aprobado') { $aprobadas++; } else { $reprobadas++; }
        }

        return [
            'total_notas' => $total,
            'aprobadas' => $aprobadas,
            'reprobadas' => $reprobadas,
        ];
    }

    // =====================
    // Validaciones ligeras
    // =====================
    private function validarCorreoUcsc(string $correo): bool
    {
        // max 35 caracteres ya lo controla la BD; aquí validamos dominio
        return \preg_match('/^[A-Za-z0-9._%-]{1,25}@ucsc\\.cl$/', $correo) === 1;
    }

    private function validarCorreoIng(string $correo): bool
    {
        return \preg_match('/^[A-Za-z0-9._%-]{1,25}@ing\\.ucsc\\.cl$/', $correo) === 1;
    }
}
