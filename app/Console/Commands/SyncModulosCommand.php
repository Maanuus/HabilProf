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
            $this->line("✓ Alumnos actualizados: {$incompletos['alumnos_actualizados']}");
            $this->line("✓ Profesores actualizados: {$incompletos['profesores_actualizados']}");

            if (!empty($incompletos['errores'])) {
                $this->warn('Observaciones:');
                foreach ($incompletos['errores'] as $error) {
                    $this->warn("  - $error");
                }
            }

            // Sincronizar notas
            $notas = $sync->sincronizarNotas();
            $this->line("✓ Notas sincronizadas: {$notas['total_notas']} (Aprobadas: {$notas['aprobadas']}, Reprobadas: {$notas['reprobadas']})");

            $this->info('Sincronización completada exitosamente.');
            return 0;

        } catch (\Exception $e) {
            $this->error('Error durante la sincronización: ' . $e->getMessage());
            \Log::error('SyncModulosCommand error', ['exception' => $e]);
            return 1;
        }
    }
}
