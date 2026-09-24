<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrTut extends Model
{
    protected $table = 'PrTut';
    protected $primaryKey = 'id_Habilitacion';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_Habilitacion',
        'nombre_Empresa',
        'nombre_Supervisor',
    ];

    public function habilitacion(): BelongsTo
    {
        return $this->belongsTo(HabilitacionProfesional::class, 'id_Habilitacion', 'id_Habilitacion');
    }
}
