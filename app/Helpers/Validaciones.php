<?php

namespace App\Helpers;

class Validaciones
{
    public static function validar_rut($rut): bool
    {
        return is_numeric($rut) && $rut >= 5000000 && $rut <= 99999999;
    }

    public static function validar_DV($DV): bool
    {
        return preg_match("/^[0-9Kk]$/", $DV);
    }

    public static function validar_semestre($semestre_inicio): bool
    {
        return preg_match("/^(199[0-9]|20[0-3][0-9]|204[0-5])-(1|2)$/", $semestre_inicio);
    }

    public static function validar_nombre($nombre): bool
    {
        return preg_match("/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ ]{1,40}$/", $nombre);
    }

    public static function validar_tipoProfesor($tipo): bool
    {
        $validos = [
            "Profesor Guía",
            "Profesor Tutor de Práctica",
            "Profesor Co-Guía",
            "Profesor Comisión"
        ];

        return in_array($tipo, $validos, true);
    }
    public static function validar_tipoHabilitacion($tipo): bool
    {
        $validos = [
            "Prinv",
            "Pring",
            "PrTut"
        ];

        return in_array($tipo, $validos, true);
    }

    public static function validar_nombre_empresa($nombre): bool
    {
        return preg_match("/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ ]{0,100}$/", (string) ($nombre ?? ''));
    }

    public static function validar_nombre_supervisor($nombre): bool
    {
        return preg_match("/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ ]{0,80}$/", (string) ($nombre ?? ''));
    }

    public static function validar_titulo($nombre): bool
    {
        return preg_match("/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9.,;:()\- ]{0,100}$/", (string) ($nombre ?? ''));
    }

    public static function validar_descripcion($txt): bool
    {
        return preg_match("/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ0-9.,;:!¿?()\-_\n ]{0,500}$/", (string) ($txt ?? ''));
    }
}
