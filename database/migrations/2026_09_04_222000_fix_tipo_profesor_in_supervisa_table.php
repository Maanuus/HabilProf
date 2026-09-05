<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('Supervisa') && Schema::hasColumn('Supervisa', 'tipo_Profeosr') && !Schema::hasColumn('Supervisa', 'tipo_Profesor')) {
            DB::statement('ALTER TABLE "Supervisa" RENAME COLUMN "tipo_Profeosr" TO "tipo_Profesor"');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('Supervisa') && Schema::hasColumn('Supervisa', 'tipo_Profesor')) {
            DB::statement('ALTER TABLE "Supervisa" RENAME COLUMN "tipo_Profesor" TO "tipo_Profeosr"');
        }
    }
};
