<?php

namespace App\models\interfaces;

interface InterfaceConnection
{
    public function getConn();

    public function beginTransaction();

    public function commit();

    public function rollBack();
}
