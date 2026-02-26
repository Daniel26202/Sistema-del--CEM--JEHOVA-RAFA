<?php

namespace App\modelos;

use App\modelos\ModelBase;

class ModeloRecuperarContr extends ModelBase
{

    private $id_usuario, $password, $usuario, $correo;

    public function __construct($dbSystem = false)
    {
        parent::__construct($dbSystem);
    }

    // valido el usuario y el correo
    public function validarUC()
    {
        $data = [
            'usuario' => $this->getUsuario(),
            'correo' => $this->getCorreo(),
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

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getCorreo()
    {
        return $this->correo;
    }




    public function setCorreo($correo)
    {
        if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $correo)) {
            throw new \InvalidArgumentException("El correo debe estar bien escrito.");
        }
        $this->correo = $correo;
    }

    public function setUsuario($usuario)
    {
        if (!preg_match("/^[a-zA-Z0-9._-]{8,16}$/", $usuario)) {
            throw new \InvalidArgumentException("El usuario esta mal escrito.");
        }
        $this->usuario = $usuario;
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
