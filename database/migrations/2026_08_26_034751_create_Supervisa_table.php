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
        Schema::create('Supervisa', function (Blueprint $table) {
            $table->integer('id_Habilitacion');
            $table->integer('rut_Profesor');
            $table->char('DV');

            $table->primary(['id_Habilitacion', 'rut_Profesor', 'DV']);
        });
        DB::statement("alter table \"Supervisa\" add column \"tipo_Profeosr\" tipo_profesor_enum null default 'Profesor Comisión'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Supervisa');
    }
};
