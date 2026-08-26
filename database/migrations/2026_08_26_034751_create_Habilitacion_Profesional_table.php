<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Habilitacion_Profesional', function (Blueprint $table) {
            $table->integer('id_Habilitacion')->primary();
            $table->float('nota')->nullable();
            $table->string('descripcion', 500);
            $table->integer('rut_Alumno')->nullable();
            $table->char('DV')->nullable();
            $table->string('semestre_inicio', 6)->nullable();
        });
        DB::statement("alter table \"Habilitacion_Profesional\" add column \"tipo_HabilProf\" tipo_habilprof null");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Habilitacion_Profesional');
    }
};
