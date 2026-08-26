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
        Schema::create('Profesor', function (Blueprint $table) {
            $table->integer('rut_Profesor');
            $table->char('DV');
            $table->string('nombre_Profesor', 40);
            $table->string('correo_Profesor', 35);

            $table->primary(['rut_Profesor', 'DV']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Profesor');
    }
};
