<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HabilitacionProfesional extends Model
{
    protected $table = 'Habilitacion_Profesional';
    protected $primaryKey = 'id_Habilitacion';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_Habilitacion',
        'nota',
        'descripcion',
        'rut_Alumno',
        'DV',
        'semestre_inicio',
        'tipo_HabilProf',
    ];

    protected $casts = [
        'nota' => 'float',
    ];

    /**
     * Alumno titular de la habilitación
     */
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class, 'rut_Alumno', 'rut_Alumno');
    }

    /**
     * Datos específicos de Proyecto de Ingeniería
     */
    public function pring(): HasOne
    {
        return $this->hasOne(Pring::class, 'id_Habilitacion', 'id_Habilitacion');
    }

    /**
     * Datos específicos de Proyecto de Investigación
     */
    public function prinv(): HasOne
    {
        return $this->hasOne(Prinv::class, 'id_Habilitacion', 'id_Habilitacion');
    }

    /**
     * Datos específicos de Práctica Tutelada
     */
    public function prtut(): HasOne
    {
        return $this->hasOne(PrTut::class, 'id_Habilitacion', 'id_Habilitacion');
    }

    /**
     * Profesores asignados a esta habilitación (comisión, guía, etc.)
     */
    public function profesores(): BelongsToMany
    {
        return $this->belongsToMany(
            Profesor::class,
            'Supervisa',
            'id_Habilitacion',
            'rut_Profesor'
        )->withPivot('tipo_Profesor', 'id_Supervisa');
    }

    /**
     * Registros de supervisión detallados
     */
    public function supervisiones(): HasMany
    {
        return $this->hasMany(Supervisa::class, 'id_Habilitacion', 'id_Habilitacion');
    }
}
