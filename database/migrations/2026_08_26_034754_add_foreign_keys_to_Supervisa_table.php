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
        Schema::table('Supervisa', function (Blueprint $table) {
            $table->foreign(['DV', 'rut_Profesor'], 'Supervisa_DV_rut_Profesor_fkey')->references(['DV', 'rut_Profesor'])->on('Profesor')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['id_Habilitacion'], 'Supervisa_id_Habilitacion_fkey')->references(['id_Habilitacion'])->on('Habilitacion_Profesional')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Supervisa', function (Blueprint $table) {
            $table->dropForeign('Supervisa_DV_rut_Profesor_fkey');
            $table->dropForeign('Supervisa_id_Habilitacion_fkey');
        });
    }
};
