<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profesor extends Model
{
    protected $table = 'Profesor';
    protected $primaryKey = 'rut_Profesor';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'rut_Profesor',
        'DV',
        'nombre_Profesor',
        'correo_Profesor',
    ];

    /**
     * Accesor para RUT formateado con DV (ej: 9876543-K)
     */
    public function getRutCompletoAttribute(): string
    {
        return "{$this->rut_Profesor}-{$this->DV}";
    }

    /**
     * Habilitaciones que supervisa el profesor
     */
    public function habilitaciones(): BelongsToMany
    {
        return $this->belongsToMany(
            HabilitacionProfesional::class,
            'Supervisa',
            'rut_Profesor',
            'id_Habilitacion'
        )->withPivot('tipo_Profesor', 'id_Supervisa');
    }

    /**
     * Registros de supervisión detallados
     */
    public function supervisiones(): HasMany
    {
        return $this->hasMany(Supervisa::class, 'rut_Profesor', 'rut_Profesor');
    }
}
