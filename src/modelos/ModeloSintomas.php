<?php
namespace App\modelos;

use App\modelos\Db;

class ModeloSintomas extends Db
{

    private $conexion;

    public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }

    public function selects()
    {

        $consulta = $this->conexion->prepare('SELECT * FROM sintomas WHERE estado = "ACT"');

        return ($consulta->execute()) ? $consulta->fetchAll() : false;
    }

    public function insertar($nombre)
    {

        $consulta = $this->conexion->prepare('INSERT INTO sintomas(nombre, estado) VALUES (:nombre,"ACT");');

        $consulta->bindParam(":nombre", $nombre);

        $consulta->execute();
    }

    public function eliminarL($id)
    {

        $consulta = $this->conexion->prepare('UPDATE sintomas SET estado= "DES" WHERE id_sintomas= :id');
        $consulta->bindParam(":id", $id);

        $consulta->execute();
    }

}