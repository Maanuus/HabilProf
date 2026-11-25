<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Crea los tipos ENUM de PostgreSQL que usan las tablas Habilitacion_Profesional
 * y Supervisa. Deben existir antes de crear esas tablas.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::statement(<<<'SQL'
            DO $$ BEGIN
                CREATE TYPE tipo_habilprof AS ENUM ('Pring', 'Prinv', 'PrTut');
            EXCEPTION WHEN duplicate_object THEN NULL;
            END $$;
        SQL);

        DB::statement(<<<'SQL'
            DO $$ BEGIN
                CREATE TYPE tipo_profesor_enum AS ENUM (
                    'Profesor Guía',
                    'Profesor Comisión',
                    'Profesor Co-Guía',
                    'Profesor Tutor de Práctica'
                );
            EXCEPTION WHEN duplicate_object THEN NULL;
            END $$;
        SQL);
    }

    public function down(): void
    {
        DB::statement('DROP TYPE IF EXISTS tipo_profesor_enum');
        DB::statement('DROP TYPE IF EXISTS tipo_habilprof');
    }
};
