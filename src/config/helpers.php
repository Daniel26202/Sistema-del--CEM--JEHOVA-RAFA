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


//valida que un ID real sea numérico y mayor a 0

function validarIdReal(int $id)
{
    return is_numeric($id) && (int)$id > 0;
}
