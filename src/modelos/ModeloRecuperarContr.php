<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloUsuarios;

class ModeloRecuperarContr extends ModelBase
{

    private $id_usuario, $password;

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
        $data = [
            'usuario' => $this->retrunObjectModel()->getUsuario(),
            'correo' => $this->retrunObjectModel()->getCorreo(),
            'estado' => 'ACT'
        ];
        $sql = "SELECT id_usuario, usuario, correo FROM usuario WHERE usuario = :usuario AND correo = :correo AND estado =:estado";
        $this->setSQL($sql);
        return $this->search($data, false);
    }


    public function updatePassword()
    {

        $data = [
            'password' => $this->getPassword()
        ];
        $sql = "UPDATE usuario SET  password = :password WHERE id_usuario = :id";
        $this->setSQL($sql);
        return $this->update($data, $this->getIdUsuario());
    }


    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getPassword()
    {
        return $this->password;
    }




    public function setIdUsuario($id_usuario)
    {
        if (!preg_match("/^[0-9]+$/", $id_usuario)) {
            throw new \InvalidArgumentException("El ID del usuario debe ser un número entero positivo.");
        }

        if ((int)$id_usuario <= 0) {
            throw new \InvalidArgumentException("El ID del usuario debe ser mayor que cero.");
        }

        $this->id_usuario = (int)$id_usuario;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }
}
