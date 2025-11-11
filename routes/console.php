<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sincronización automática con Modulos cada 60 segundos
Schedule::command('sync:modulos')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground()
    ->onFailure(function () {
        \Log::error('Scheduled sync:modulos failed');
    })
    ->onSuccess(function () {
        \Log::info('Scheduled sync:modulos completed successfully');
    });
