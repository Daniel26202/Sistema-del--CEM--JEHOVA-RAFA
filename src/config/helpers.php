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
