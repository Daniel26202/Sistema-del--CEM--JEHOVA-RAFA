<?php

namespace App\models\interfaces;

interface InterfaceValidator
{

    public function validarSesion();

    public function validarCamposObligatorios();

    public function set_campos(array $campos);
}
