<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('Habilitacion_Profesional', function (Blueprint $table) {
            $table->foreign(['rut_Alumno', 'DV'], 'Habilitacion_Profesional_rut_Alumno_DV_fkey')->references(['rut_Alumno', 'DV'])->on('Alumno')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Habilitacion_Profesional', function (Blueprint $table) {
            $table->dropForeign('Habilitacion_Profesional_rut_Alumno_DV_fkey');
        });
    }
};
