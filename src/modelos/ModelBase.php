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


    protected function create($data)
    {

        $sql = $this->getSQL();
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    protected function read($all = true)
    {
        $stmt = $this->pdo->prepare($this->getSQL());
        $stmt->execute();
        return $all ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
    
    }

    protected function update($data, $id)
    {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ', ');

        $sql = $this->getSQL() . " SET $set WHERE id = :id";
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

    protected function search($params, $all = true)
    {

        $sql = $this->getSQL();
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();

        return $all ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
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
