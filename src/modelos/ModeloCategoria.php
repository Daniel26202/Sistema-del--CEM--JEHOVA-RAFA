<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloCategoria extends Db
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = $this->connectionSistema();
    }


    public function seleccionarCategoria()
    {
        try {
            $consulta = $this->conexion->prepare(" SELECT * FROM categoria_servicio WHERE estado = 'ACT'  ");
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function seleccionarTodasLasCategoria()
    {
        try {
            $consulta = $this->conexion->prepare(" SELECT * FROM categoria_servicio WHERE estado = 'ACT'  ");
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function registrarCategoria($nombre)
    {
        try {
            $consulta = $this->conexion->prepare("INSERT INTO categoria_servicio VALUES (null, :nombre, 'ACT')");
            $consulta->bindParam(":nombre", $nombre);
            $consulta->execute();

            $id_categoria = $this->conexion->lastInsertId();
            $consulta = $this->conexion->prepare("SELECT * from categoria_servicio where id_categoria=:id_categoria");
            $consulta->bindParam(":id_categoria", $id_categoria);
            $consulta->execute();
            $data = ($consulta->execute()) ? $consulta->fetch() : false;
            
            return ["exito", $data];
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function eliminarCategoria($id_categoria)
    {
        try {
            $consulta = $this->conexion->prepare("UPDATE categoria_servicio SET estado = 'DES' WHERE id_categoria = :id_categoria");
            $consulta->bindParam(":id_categoria", $id_categoria);
            $consulta->execute();
            return "exito";
        } catch (\Exception $e) {
            return 0;
        }
    }
}
