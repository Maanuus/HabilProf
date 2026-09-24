<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pring extends Model
{
    protected $table = 'Pring';
    protected $primaryKey = 'id_Habilitacion';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_Habilitacion',
        'titulo',
    ];

    public function habilitacion(): BelongsTo
    {
        return $this->belongsTo(HabilitacionProfesional::class, 'id_Habilitacion', 'id_Habilitacion');
    }
}
