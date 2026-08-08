<?php
namespace App\models;

use App\models\interfaces\InterfaceValidator;

trait TraitDelete
{
    public function eliminar(array $data, InterfaceValidator $validator)
    {
        $validator->set_campos(array_values($data));
        $validator->validarSesion();
        $validator->validarCamposObligatorios();
        return $this->delete($data);
    }
}
