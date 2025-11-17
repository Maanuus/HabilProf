<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ModulosSyncService;

class SyncModulosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:modulos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza datos de alumnos, profesores y notas desde la BD Modulos';

    /**
     * Execute the console command.
     */
    public function handle(ModulosSyncService $sync)
    {
        $this->info('Iniciando sincronización con Modulos...');

        try {
            // Completar campos incompletos
            $incompletos = $sync->completarIncompletos();
            $this->line("✓ Alumnos creados: {$incompletos['alumnos_creados']} | actualizados: {$incompletos['alumnos_actualizados']}");
            $this->line("✓ Profesores creados: {$incompletos['profesores_creados']} | actualizados: {$incompletos['profesores_actualizados']}");

            if (!empty($incompletos['errores'])) {
                $this->warn('Observaciones:');
                foreach ($incompletos['errores'] as $error) {
                    $this->warn("  - $error");
                }
            }

            // Sincronizar notas
            $notas = $sync->sincronizarNotas();
            $this->line("✓ Notas sincronizadas: {$notas['total_notas']} (Aprobadas: {$notas['aprobadas']}, Reprobadas: {$notas['reprobadas']})");

            // Guardar resultado en cache para mostrar en las vistas
            \Cache::put('last_sync_notification', [
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'alumnos_creados' => $incompletos['alumnos_creados'],
                'alumnos' => $incompletos['alumnos_actualizados'],
                'profesores_creados' => $incompletos['profesores_creados'],
                'profesores' => $incompletos['profesores_actualizados'],
                'notas_total' => $notas['total_notas'],
                'notas_aprobadas' => $notas['aprobadas'],
                'notas_reprobadas' => $notas['reprobadas'],
                'errores' => $incompletos['errores'],
            ], now()->addMinutes(5)); // Disponible por 5 minutos

            $this->info('Sincronización completada exitosamente.');
            return 0;

        } catch (\Exception $e) {
            $this->error('Error durante la sincronización: ' . $e->getMessage());
            \Log::error('SyncModulosCommand error', ['exception' => $e]);
            
            // Guardar error en cache
            \Cache::put('last_sync_notification', [
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'error' => $e->getMessage(),
            ], now()->addMinutes(5));
            
            return 1;
        }
    }
}
