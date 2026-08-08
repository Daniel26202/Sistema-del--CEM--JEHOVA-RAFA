<?php

namespace App\models;
use App\models\interfaces\InterfaceConnection;

require_once __DIR__ . "/../config/config.php";

use PDO;
use PDOException;

class Db implements InterfaceConnection
{
    private $host = host_cos;
    private $user = user_cos;
    private $pass = pass_cos;
    private $dbname = dbname_cos;
    private $dbsegname = dbsegname_cos;
    private $pdo;


    // Conexión a base de datos principal
    function __construct($db_sistem = true){
        try {
            $dbname = $db_sistem ? $this->dbname : $this->dbsegname;
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$dbname}", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }

    public function getConn(){
        return $this->pdo;
    }

    public function beginTransaction(){
        return $this->pdo->beginTransaction();
    }

    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }
}
