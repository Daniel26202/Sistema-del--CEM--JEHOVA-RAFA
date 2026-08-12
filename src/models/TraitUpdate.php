<?php

namespace App\models;

use App\models\interfaces\InterfaceValidator;

trait TraitUpdate
{
    public function actualizar(array $colums, array $data_id, InterfaceValidator $validator)
    {
        if (empty($validator)) {
            throw new \Exception('No se permite que la validacion sea null.');
        }
        $validator->set_campos(array_values($colums));
        $validator->validarSesion();
        $validator->validarCamposObligatorios();
        $this->set_colums($colums);
        return $this->update($data_id);
    }
}
