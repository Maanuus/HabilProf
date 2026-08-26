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
        Schema::table('Prinv', function (Blueprint $table) {
            $table->foreign(['id_Habilitacion'], 'Prinv_id_Habilitacion_fkey')->references(['id_Habilitacion'])->on('Habilitacion_Profesional')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Prinv', function (Blueprint $table) {
            $table->dropForeign('Prinv_id_Habilitacion_fkey');
        });
    }
};
