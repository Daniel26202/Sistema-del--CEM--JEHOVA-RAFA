<?php

namespace App\modelos;

require_once __DIR__ . "/../config/config.php";

use PDO;
use PDOException;

class Db
{
    private $host = host_cos;
    private $user = user_cos;
    private $pass = pass_cos;
    private $dbname = dbname_cos;
    private $dbsegname = dbsegname_cos;

    // Conexión a base de datos principal
    public function connectionSistema()
    {
        try {
            $pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error en conexión a bd_sistema: " . $e->getMessage());
        }
    }

    // Conexión a base de datos secundaria
    public function connectionSegurity()
    {
        try {
            $pdo = new PDO("mysql:host={$this->host};dbname={$this->dbsegname}", $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error en conexión a bd_reportes: " . $e->getMessage());
        }
    }
}