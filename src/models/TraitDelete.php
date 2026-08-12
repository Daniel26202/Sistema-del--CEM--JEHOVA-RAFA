<?php
namespace App\models;

use App\models\interfaces\InterfaceValidator;

trait TraitDelete
{
    public function eliminar(array $data, InterfaceValidator $validator)
    {
        if (empty($validator)) {
            throw new \Exception('No se permite que la validacion sea null.');
        }
        $validator->set_campos(array_values($data));
        $validator->validarSesion();
        $validator->validarCamposObligatorios();
        return $this->delete($data);
    }
}
