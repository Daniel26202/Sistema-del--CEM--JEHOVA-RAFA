<?php

namespace App\modelos;

require_once __DIR__ . "/../config/config.php";

use PDO;
use PDOException;

class Db extends PDO
{
    private $host;
    private $user;
    private $pass;
    private $dbname;


    public function __construct()
    {

        $this->host = host_cos;
        $this->user = user_cos;
        $this->pass = pass_cos;
        $this->dbname = dbsegname_cos;


        try {
            // Conexión a la base de datos con soporte para caracteres especiales
            parent::__construct("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->user, $this->pass);
            // Configuración de atributos para manejar errores
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Configuración para manejar caracteres especiales
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
