<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloUsuarios;

class ModeloRecuperarContr extends ModelBase
{


    public function __construct($dbSystem = false)
    {
        parent::__construct($dbSystem);
    }

    private function retrunObjectModel()
    {
        return new ModeloUsuarios;
    }

    // valido el usuario y el correo
    public function validarUC()
    {
        $data=[
            'usuario'=>$this->retrunObjectModel()->getUsuario(),
            'correo'=>$this->retrunObjectModel()->getCorreo(),
            'estado'=>'ACT'
        ];
        $sql = "SELECT id_usuario, usuario, correo FROM usuario WHERE usuario = :usuario AND correo = :correo AND estado =:estado";
        $this->setSQL($sql);
        return $this->search($data, false);
    }


    public function updatePassword()
    {

        $data = [
            'password' => $this->retrunObjectModel()->getPassword()
        ];
        $sql = "UPDATE usuario SET  password = :password WHERE id_usuario = :id";
        $this->setSQL($sql);
        return $this->search($data, $this->retrunObjectModel()->getIdUsuario());
    }


}
