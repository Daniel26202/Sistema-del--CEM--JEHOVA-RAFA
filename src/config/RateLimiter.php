<?php

namespace App\config;

use App\modelos\ModelBase;


class RateLimiter extends ModelBase
{
    private $limite_ip = 60;
    private $ventana_tiempo_IP = 10;
    
    private $limite_user = 20;
    private $ventana_tiempo_user = 1;
    private $sessionId = '';
    
    private $ip = '';
    // private $endpoind = '';

    public function __construct($dbSystem = false)
    {
        parent::__construct($dbSystem);
    }


    public function evaluarLimiteDB()
    {
        $ahora = date('Y-m-d H:i:s');
        $haceUnMinuto = date('Y-m-d H:i:s', strtotime($ahora . ' - ' . $this->ventana_tiempo_IP . ' seconds'));

        // Contar peticiones dentro de la ventana de tiempo
        $query = $this->getPDO()->prepare("SELECT COUNT(*) as total FROM control_rate_limit WHERE ip = :ip AND creado_en >= :haceUnMinuto");
        $query->execute([
            'ip' => $this->ip,
            'haceUnMinuto' => $haceUnMinuto
        ]);

        $result = $query->fetch();
        $totalPeticiones = $result['total'] ?? 0;


        if ($totalPeticiones >= $this->limite_ip) {
            return true; // bloqueado por exceso de peticiones
        }

        // Insertar nueva petición
        $query = $this->getPDO()->prepare("INSERT INTO control_rate_limit (ip, creado_en) VALUES (:ip, :creado_en)");
        $query->execute([
            'ip' => $this->ip,
            'creado_en' => $ahora
        ]);

        // Limpiar registros viejos periódicamente (opcional, para mantener la tabla limpia)
        if (rand(1, 10) === 1) { // 10% de las veces
            $query = $this->getPDO()->prepare("DELETE FROM control_rate_limit WHERE creado_en < :haceUnMinuto");
            $query->execute(['haceUnMinuto' => $haceUnMinuto]);
        }

        return false;

        // $haceUnMinuto = $ahora - $this->ventana_tiempo;
        // $data = ['haceUnMinuto' => $haceUnMinuto];
        // $sql = "DELETE FROM control_rate_limit WHERE creado_en < :haceUnMinuto";
        // $this->setSQL($sql);
        // $this->delete($data);

        // $data = [
        //     'ip' => $this->getIPUser(),
        //     'endpoind' => $this->getEndpoind(),
        //     'haceUnMinuto' => $haceUnMinuto
        // ];
        // $sql = "SELECT COUNT(*) as total FROM control_rate_limit WHERE ip = :ip AND endpoind = :endpoind AND creado_en >= :haceUnMinuto";
        // $this->setSQL($sql);
        // $datos = $this->search($data, false);
        // $totalPeticiones = $datos['total'];

        // if ($totalPeticiones >= $this->limite_ip) {
        //     return true; // bloqueado por exceso de peticiones
        // }

        // $data = [
        //     'ip' => $this->getIPUser(),
        //     'endpoind' => $this->getEndpoind(),
        // ];
        // $sql = "INSERT INTO control_rate_limit (id, ip, endpoind) VALUES (null, :ip, :endpoind)";
        // $this->setSQL($sql);
        // $this->create($data);

        // return false; //se permite
    }

    public function evaluar_rate_limit_by_user()
    {
        $ahora = time();
        if (!isset($_SESSION['rate_limit_by_user'])) {
            $_SESSION['rate_limit_by_user'] = [];
        }
        $_SESSION['rate_limit_by_user'] = array_filter($_SESSION['rate_limit_by_user'], function ($item) use ($ahora) {
            return $item > $ahora - $this->ventana_tiempo_user;
        });

        if (count($_SESSION['rate_limit_by_user']) >= $this->limite_user) {
            return true; // bloqueado por exceso de peticiones
        }

        $_SESSION['rate_limit_by_user'][] = $ahora;
        return false; // se permite
    }

    public function checkRateLimitByIP()
    {
        return $this->evaluarLimiteDB();
    }

    public function getIPUser()
    {
        return $this->ip;
    }

    public function getventana_tiempo_IP(){
        return $this->ventana_tiempo_IP;
    }
    
    public function getSessionId(){
        return $this->sessionId;
    }

    // public function getEndpoind()
    // {
    //     return $this->endpoind;
    // }

    public function getLimitePeticiones()
    {
        return $this->limite_ip;
    }
    
    public function getLimiteUser()
    {
        return $this->limite_user;
    }
    
    public function getVentanaTiempoUser()
    {
        return $this->ventana_tiempo_user;
    }


    public function setIP($ip)
    {
        $this->ip = (string)$ip;
    }
    public function setVentanaTiempoIP($time){
        $this->ventana_tiempo_IP = (int)$time;
    }
    public function setVentanaTiempoUser($time){
        $this->ventana_tiempo_user = (int)$time;
    }


    // public function setEndpoind($endpoind)
    // {
    //     $this->endpoind = $endpoind;
    // }

    public function setLimitePeticiones(int $limite_ip)
    {
        $this->limite_ip = (int)$limite_ip;
        // if ($limite_ip !== null) {
        //     $this->limite_ip = $limite_ip;
        //     return;
        // }

        // $equivalentes = require __DIR__ . "/../../src/config/equivalencias.php";
        // $permiso = $equivalentes[$this->endpoind] ?? null;

        // switch ($permiso) {
        //     case 'guardar':
        //     case 'editar':
        //     case 'eliminar':
        //         $this->limite_ip = 50;
        //         break;
        //     case 'consultar':
        //         $this->limite_ip = 100;
        //         break;
        //     default:
        //         $this->limite_ip = 80; 
        // }
    }
    
    public function setSessionId($sessionId)
    {
        $this->sessionId = (string)$sessionId;
    }
}
