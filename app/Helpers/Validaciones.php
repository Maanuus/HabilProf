<?php

namespace App\Helpers;

class Validaciones
{
    public static function validar_rut($rut): bool
    {
        return preg_match("/^[1-9][0-9]{6,7}$/", $rut);
    }

    public static function validar_DV($DV): bool
    {
        return preg_match("/^[0-9Kk]$/", $DV);
    }

    public static function validar_semestre($semestre_inicio): bool
    {
        return preg_match("/^(199[0-9]|20[0-3][0-9]|204[0-5])-(1|2)$/", $semestre_inicio);
    }
}
