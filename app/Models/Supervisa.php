<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supervisa extends Model
{
    protected $table = 'Supervisa';
    protected $primaryKey = 'id_Supervisa';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_Supervisa',
        'id_Habilitacion',
        'rut_Profesor',
        'DV',
        'tipo_Profesor',
    ];

    public function habilitacion(): BelongsTo
    {
        return $this->belongsTo(HabilitacionProfesional::class, 'id_Habilitacion', 'id_Habilitacion');
    }

    public function profesor(): BelongsTo
    {
        return $this->belongsTo(Profesor::class, 'rut_Profesor', 'rut_Profesor');
    }
}
