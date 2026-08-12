<?php

namespace App\models;

use App\models\interfaces\InterfaceValidator;

trait TraitCreate
{

    public function guardar(array $colums, InterfaceValidator $validator)
    {
        if (empty($validator)) {
            throw new \Exception('No se permite que la validacion sea null.');
        }
        
        $validator->set_campos(array_values($colums));
        $validator->validarSesion();
        $validator->validarCamposObligatorios();
        $this->set_colums($colums);
        return $this->create();
    }
}
