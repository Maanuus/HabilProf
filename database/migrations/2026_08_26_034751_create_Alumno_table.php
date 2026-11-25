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
        Schema::create('Alumno', function (Blueprint $table) {
            $table->integer('rut_Alumno');
            $table->char('DV', 1);
            $table->string('nombre_Alumno', 40);
            $table->string('carrera', 50);
            $table->string('correo_Alumno', 35);

            $table->primary(['rut_Alumno', 'DV']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Alumno');
    }
};
