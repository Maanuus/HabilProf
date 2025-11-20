<?php
//Faltan las migraciones 
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'alumnos_creados' => 0,
            'profesores_creados' => 0,
            'errores' => [],
        ];

        // =====================
        // Alumnos: Crear nuevos y actualizar existentes
        // =====================
        $alumnosDestino = DB::connection('pgsql2')->table('Alumno')->get();
        $mapAlumnosDestino = [];
        foreach ($alumnosDestino as $a) {
            $mapAlumnosDestino[$a->rut_Alumno . '-' . $a->DV] = $a;
        }

        $alumnosOrigen = DB::connection('Modulos')->table('Alumno')->get();

        foreach ($alumnosOrigen as $mod) {
            $clave = $mod->rut_Alumno . '-' . $mod->DV;
            if (!isset($mapAlumnosDestino[$clave])) {
                // Crear nuevo alumno en destino
                $insert = [
                    'rut_Alumno' => $mod->rut_Alumno,
                    'DV' => $mod->DV,
                    'nombre_Alumno' => $mod->nombre_Alumno ?? '',
                    'carrera' => $mod->carrera ?? '',
                    // NOT NULL en destino: usar correo válido, si no, string vacío y registrar observación
                    'correo_Alumno' => ($mod->correo_Alumno && $this->validarCorreoIng($mod->correo_Alumno))
                        ? $mod->correo_Alumno
                        : ($mod->correo_Alumno ?? ''),
                ];
                try {
                    DB::connection('pgsql2')->table('Alumno')->insert($insert);
                    $res['alumnos_creados']++;
                    // Registrar creación (JSON con todos los campos como valor nuevo)
                    $this->registrarCambio('Alumno', $clave, '_creacion', null, json_encode($insert, JSON_UNESCAPED_UNICODE));
                    if (!$this->validarCorreoIng($mod->correo_Alumno ?? '')) {
                        $res['errores'][] = "Correo alumno inválido o dominio no permitido en creación: $clave => '{$mod->correo_Alumno}'";
                    }
                } catch (\Exception $e) {
                    $res['errores'][] = "Error creando alumno $clave: " . $e->getMessage();
                }
                continue; // nada que actualizar porque acaba de crearse
            }

            // Actualizar diferencias
            $dest = $mapAlumnosDestino[$clave];
            $update = [];

            if (!empty($mod->nombre_Alumno) && $mod->nombre_Alumno !== $dest->nombre_Alumno) {
                $update['nombre_Alumno'] = $mod->nombre_Alumno;
                $this->registrarCambio('Alumno', $clave, 'nombre_Alumno', $dest->nombre_Alumno, $mod->nombre_Alumno);
            }
            if (!empty($mod->carrera) && $mod->carrera !== $dest->carrera) {
                $update['carrera'] = $mod->carrera;
                $this->registrarCambio('Alumno', $clave, 'carrera', $dest->carrera, $mod->carrera);
            }
            if (!empty($mod->correo_Alumno) && $mod->correo_Alumno !== $dest->correo_Alumno) {
                if ($this->validarCorreoIng($mod->correo_Alumno)) {
                    $update['correo_Alumno'] = $mod->correo_Alumno;
                    $this->registrarCambio('Alumno', $clave, 'correo_Alumno', $dest->correo_Alumno, $mod->correo_Alumno);
                }
            }
            if (!empty($update)) {
                DB::connection('pgsql2')->table('Alumno')
                    ->where('rut_Alumno', $mod->rut_Alumno)
                    ->where('DV', $mod->DV)
                    ->update($update);
                $res['alumnos_actualizados']++;
            }
        }

        // =====================
        // Profesores: Crear nuevos y actualizar existentes
        // =====================
        $profesoresDestino = DB::connection('pgsql2')->table('Profesor')->get();
        $mapProfesoresDestino = [];
        foreach ($profesoresDestino as $p) {
            $mapProfesoresDestino[$p->rut_Profesor . '-' . $p->DV] = $p;
        }

        $profesoresOrigen = DB::connection('Modulos')->table('Profesor')->get();

        foreach ($profesoresOrigen as $modP) {
            $clave = $modP->rut_Profesor . '-' . $modP->DV;
            if (!isset($mapProfesoresDestino[$clave])) {
                // Crear nuevo profesor
                $insert = [
                    'rut_Profesor' => $modP->rut_Profesor,
                    'DV' => $modP->DV,
                    'nombre_Profesor' => $modP->nombre_Profesor ?? '',
                    // NOT NULL en destino: usar correo válido, si no, string vacío y registrar observación
                    'correo_Profesor' => ($modP->correo_Profesor && $this->validarCorreoUcsc($modP->correo_Profesor))
                        ? $modP->correo_Profesor
                        : ($modP->correo_Profesor ?? ''),
                ];
                try {
                    DB::connection('pgsql2')->table('Profesor')->insert($insert);
                    $res['profesores_creados']++;
                    $this->registrarCambio('Profesor', $clave, '_creacion', null, json_encode($insert, JSON_UNESCAPED_UNICODE));
                    if (!$this->validarCorreoUcsc($modP->correo_Profesor ?? '')) {
                        $res['errores'][] = "Correo profesor inválido o dominio no permitido en creación: $clave => '{$modP->correo_Profesor}'";
                    }
                } catch (\Exception $e) {
                    $res['errores'][] = "Error creando profesor $clave: " . $e->getMessage();
                }
                continue;
            }

            $dest = $mapProfesoresDestino[$clave];
            $update = [];
            if (!empty($modP->nombre_Profesor) && $modP->nombre_Profesor !== $dest->nombre_Profesor) {
                $update['nombre_Profesor'] = $modP->nombre_Profesor;
                $this->registrarCambio('Profesor', $clave, 'nombre_Profesor', $dest->nombre_Profesor, $modP->nombre_Profesor);
            }
            if (!empty($modP->correo_Profesor) && $modP->correo_Profesor !== $dest->correo_Profesor) {
                if ($this->validarCorreoUcsc($modP->correo_Profesor)) {
                    $update['correo_Profesor'] = $modP->correo_Profesor;
                    $this->registrarCambio('Profesor', $clave, 'correo_Profesor', $dest->correo_Profesor, $modP->correo_Profesor);
                }
            }
            if (!empty($update)) {
                DB::connection('pgsql2')->table('Profesor')
                    ->where('rut_Profesor', $modP->rut_Profesor)
                    ->where('DV', $modP->DV)
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

            $notaAnterior = $hab->nota;
            
            DB::connection('pgsql2')->table('Habilitacion_Profesional')
                ->where('id_Habilitacion', $hab->id_Habilitacion)
                ->update([
                    'nota' => $n->nota_Alumno,
                    // 'nota_status' => $estado, // si luego agregan la columna
                ]);

            // Registrar cambio de nota si es diferente
            if ($notaAnterior != $n->nota_Alumno) {
                $this->registrarCambio('Habilitacion_Profesional', $n->rut_Alumno . '-' . $n->DV, 'nota', $notaAnterior, $n->nota_Alumno);
            }

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

    /**
     * Registra cada cambio individual en un archivo JSON
     */
    private function registrarCambio(string $tipo, string $rut, string $campo, $valorAnterior, $valorNuevo): void
    {
        $cambio = [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'tipo' => $tipo,
            'rut' => $rut,
            'campo' => $campo,
            'valor_anterior' => $valorAnterior,
            'valor_nuevo' => $valorNuevo,
        ];

        $archivo = storage_path('logs/sync_changes.json');
        
        // Crear directorio si no existe
        if (!file_exists(dirname($archivo))) {
            mkdir(dirname($archivo), 0755, true);
        }

        // Leer cambios existentes
        $cambios = [];
        if (file_exists($archivo)) {
            $contenido = file_get_contents($archivo);
            $cambios = json_decode($contenido, true) ?? [];
        }

        // Agregar nuevo cambio
        $cambios[] = $cambio;

        // Guardar de vuelta
        file_put_contents($archivo, json_encode($cambios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
