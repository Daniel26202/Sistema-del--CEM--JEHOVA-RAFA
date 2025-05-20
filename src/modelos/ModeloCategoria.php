<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloCategoria extends Db
{

    private $conexion;

    public function __construct()
    {
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();

        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
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
            return 1;
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
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
