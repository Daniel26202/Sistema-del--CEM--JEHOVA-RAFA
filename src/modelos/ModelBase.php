<?php

namespace App\modelos;

use PDO;
use App\modelos\Db;

class ModelBase extends Db
{


    private $sql;
    private $pdo;

    public function __construct($dbSystem)
    {
        $this->pdo = ($dbSystem) ? $this->connectionSistema() : $this->connectionSegurity();
    }


    protected function create(array $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = $this->getSQL();
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    protected function read()
    {
        $stmt = $this->pdo->prepare($this->getSQL());
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function update(array $data, $id)
    {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ', ');

        $sql = $this->getSQL();
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    protected function delete($id)
    {
        $sql = $this->getSQL();
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    protected function search($params)
    {

        $sql = $this->getSQL();
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getSQL()
    {
        return $this->sql;
    }

    public function setSQL($sql)
    {
        $this->sql = $sql;
    }
}
