<?php

use Hashids\Hashids;
//hashids
$hashids = new Hashids('CEM_JEHOVA_RAFA_SALT_2026', 10);


function hashId(int $id)
{
    global $hashids;
    return $hashids->encode($id);
}

function unhashId(string $hash)
{
    global $hashids;
    $decoded = $hashids->decode($hash);
    //  si es invalido o manipulado el hash, lanza una excepción
    if (!isset($decoded[0])) {
        throw new \InvalidArgumentException('Identificador inválido o manipulado.');
    }

    return $decoded[0];
}


/**
 * Indica si un valor corresponde a un identificador generado por hashId().
 *
 * Permite comprobar el campo ANTES de llamar a unhashId(), para poder
 * responder "vuelva a seleccionar el paciente" en lugar de recibir una
 * excepción genérica que el usuario no sabe interpretar.
 */
function esHashIdValido(string $hash): bool
{
    global $hashids;

    if ($hash === '') {
        return false;
    }

    return !empty($hashids->decode($hash));
}


//valida que un ID real sea numérico y mayor a 0

function validarIdReal(int $id)
{
    return is_numeric($id) && (int)$id > 0;
}


/**
 * Convierte el texto de un precio a float aceptando los formatos que llegan
 * desde la interfaz: "1160.00" (JS con punto decimal), "1.160,00" (formato
 * venezolano) o "1,160.00" (formato inglés).
 *
 * Antes cada controlador hacía str_replace('.', '', ...): si el navegador
 * enviaba "10.00" el punto decimal se eliminaba y se guardaba 1000.
 */
function parsearPrecio($valor): float
{
    $limpio = preg_replace('/[^0-9,.\-]/', '', trim((string)$valor));

    if ($limpio === '') {
        return 0.0;
    }

    $ultimaComa = strrpos($limpio, ',');
    $ultimoPunto = strrpos($limpio, '.');

    if ($ultimaComa !== false && $ultimoPunto !== false) {
        if ($ultimaComa > $ultimoPunto) {
            // 1.160,00 -> separador de miles el punto, decimal la coma
            $limpio = str_replace(',', '.', str_replace('.', '', $limpio));
        } else {
            // 1,160.00 -> separador de miles la coma, decimal el punto
            $limpio = str_replace(',', '', $limpio);
        }
    } elseif ($ultimaComa !== false) {
        $decimales = strlen($limpio) - $ultimaComa - 1;
        // Con 1 o 2 dígitos se asume decimal; con más, separador de miles.
        $limpio = ($decimales > 0 && $decimales <= 2)
            ? str_replace(',', '.', $limpio)
            : str_replace(',', '', $limpio);
    } elseif ($ultimoPunto !== false) {
        $decimales = strlen($limpio) - $ultimoPunto - 1;
        $cantidadPuntos = substr_count($limpio, '.');
        // "1.234.567" o "10.000" son separadores de miles.
        if ($cantidadPuntos > 1 || $decimales > 2) {
            $limpio = str_replace('.', '', $limpio);
        }
    }

    return (float)$limpio;
}
