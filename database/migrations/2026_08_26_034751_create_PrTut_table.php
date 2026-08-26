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
        Schema::create('PrTut', function (Blueprint $table) {
            $table->integer('id_Habilitacion')->primary();
            $table->string('nombre_Empresa', 100);
            $table->string('nombre_Supervisor', 80);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PrTut');
    }
};
