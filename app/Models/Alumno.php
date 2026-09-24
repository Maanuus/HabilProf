<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumno extends Model
{
    protected $table = 'Alumno';
    protected $primaryKey = 'rut_Alumno';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'rut_Alumno',
        'DV',
        'nombre_Alumno',
        'carrera',
        'correo_Alumno',
    ];

    /**
     * Accesor para RUT formateado con DV (ej: 12345678-9)
     */
    public function getRutCompletoAttribute(): string
    {
        return "{$this->rut_Alumno}-{$this->DV}";
    }

    /**
     * Relación con las habilitaciones profesionales del alumno
     */
    public function habilitaciones(): HasMany
    {
        return $this->hasMany(HabilitacionProfesional::class, 'rut_Alumno', 'rut_Alumno');
    }
}
