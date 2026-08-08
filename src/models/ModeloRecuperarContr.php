<?php

namespace App\models;

use App\models\ModelBase;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitUpdate;

class ModeloRecuperarContr extends ModelBase
{

    private $id_usuario, $password, $usuario, $correo;
    private $validator;
    use TraitUpdate;

    public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
    {
        parent::__construct($conn);
        $this->validator = $vali;
    }

    // valido el usuario y el correo
    public function validarUC()
    {
        $coditions = [
            'condiciones' => ['usuario' => $this->getUsuario(), 'correo' => $this->getCorreo(),'estado'=>'ACT'],
            'conectores' => ['AND','AND'],
            'operadores' => ['=', '=','=']
        ];
        $this->set_tables(["usuario"]);
        $this->set_colums(['id_usuario', 'usuario', 'correo']);
        $this->set_condicion_aditional($coditions);
        return $this->read(false);
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
