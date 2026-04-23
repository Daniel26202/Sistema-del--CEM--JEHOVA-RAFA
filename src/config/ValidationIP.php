<?php
namespace App\config;

use App\modelos\ModelBase;


class ValidationIP extends ModelBase
{

    private $id_usuario, $ip_usuario;

    public function __construct()
    {
        parent::__construct(false);
    }


    public function verificationIp()
    {
        $data = [
            'ip_usuario' => $this->getIpUsuario(),
            'id_usuario' => $this->getIdUsuario(),
        ];
        $sql = 'SELECT bloqueado FROM intentos_login WHERE ip_usuario =:ip_usuario AND id_usuario=:id_usuario';
        $this->setSQL($sql);
        $listData = $this->search($data, false);
        return !empty($listData) ? 1 : 0;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getIpUsuario()
    {
        return $this->ip_usuario;
    }


    public function setIpUsuario($ip_usuario)
    {
        $this->ip_usuario = $ip_usuario;
    }


    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }
}
