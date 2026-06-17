<?php

namespace App\config;

use App\modelos\ModelBase;


class RateLimiter extends ModelBase
{
    private $limite_ip = 60;
    private $ventana_tiempo = 60;
    private $ip = '';
    private $endpoind = '';

    public function __construct($dbSystem = false)
    {
        parent::__construct($dbSystem);
    }


    private function evaluarLimiteDB()
    {

        $ahora = time();
        $haceUnMinuto = $ahora - $this->ventana_tiempo;

        $data = ['haceUnMinuto' => $haceUnMinuto];
        $sql = "DELETE FROM control_rate_limit WHERE creado_en < :haceUnMinuto";
        $this->setSQL($sql);
        $this->delete($data);

        $data = [
            'ip' => $this->getIPUser(),
            'endpoind' => $this->getEndpoind(),
            'haceUnMinuto' => $haceUnMinuto
        ];
        $sql = "SELECT COUNT(*) as total FROM control_rate_limit WHERE ip = :ip AND endpoind = :endpoind AND creado_en >= :haceUnMinuto";
        $this->setSQL($sql);
        $datos = $this->search($data, false);
        $totalPeticiones = $datos['total'];

        if ($totalPeticiones >= $this->getLimitePeticiones()) {
            return true; // bloqueado por exceso de peticiones
        }
        
        $data = [
            'ip' => $this->getIPUser(),
            'endpoind' => $this->getEndpoind(),
        ];
        $sql = "INSERT INTO control_rate_limit (id, ip, endpoind) VALUES (null, :ip, :endpoind)";
        $this->setSQL($sql);
        $this->create($data);

        return false; //se permite
    }


    public function checkRateLimitByIP()
    {
        return $this->evaluarLimiteDB();
    }

    public function getIPUser()
    {
        return $this->ip;
    }

    public function getEndpoind()
    {
        return $this->endpoind;
    }

    public function getLimitePeticiones()
    {
        return $this->limite_ip;
    }



    public function setIP($ip)
    {
        $this->ip = $ip;
    }


    public function setEndpoind($endpoind)
    {
        $this->endpoind = $endpoind;
    }

    //se le coloco limite por ip de 80 solo para probarlo
    public function setLimitePeticiones($limite_ip = 80)
    {
        $this->limite_ip = $limite_ip;
    }
}

