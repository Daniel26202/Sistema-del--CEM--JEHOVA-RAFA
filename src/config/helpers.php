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
    return $decoded[0] ?? null;
}


//valida que un ID real sea numérico y mayor a 0

function validarIdReal(int $id)
{
    return is_numeric($id) && (int)$id > 0;
}
