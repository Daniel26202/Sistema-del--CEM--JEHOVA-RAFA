<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloPatologia extends Db
{

    private $conexion;

    public function __construct()
    {
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();

        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión
    }


    public function mostrarPatologias()
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM patologia WHERE estado = 'ACT' ");
            $consulta->execute();
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function mostrarPatologiasEliminadas()
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM patologia WHERE estado = 'DES' ");
            $consulta->execute();
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function nombrePatologia($nombrePatologia)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM patologia WHERE estado = 'ACT' AND nombre_patologia = :nombrePatologia ");
            $consulta->bindParam(":nombrePatologia", $nombrePatologia);
            $consulta->execute();
            while ($consulta->fetch()) {
                return "existeC";
            }

            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function buscarPatologia($nombre)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM patologia WHERE nombre_patologia LIKE :nombre");
            $busqueda = "%$nombre%";
            $consulta->bindParam(":nombre", $busqueda);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function buscarPatologiaPaciente($cedula)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM patologia pat INNER JOIN patologiadepaciente pdp ON pdp.id_patologia = pat.id_patologia INNER JOIN paciente pac ON pac.id_paciente = pdp.id_paciente WHERE pac.cedula =:cedula");
            $consulta->bindParam(":cedula", $cedula);
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function insertarPatologia($nombrePatologia)
    {
        try {
            $consulta = $this->conexion->prepare("INSERT INTO patologia VALUES (null, :nombrePatologia, 'ACT')");
            $consulta->bindParam(":nombrePatologia", $nombrePatologia);
            $consulta->execute();
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function eliminarPatologia($id_patologia)
    {
        try {
            $consulta = $this->conexion->prepare("UPDATE patologia SET estado= 'DES' WHERE id_patologia=:id_patologia ");
            $consulta->bindParam(":id_patologia", $id_patologia);
            $consulta->execute();
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function restablecer($id_patologia)
    {
        try {
            $consulta = $this->conexion->prepare("UPDATE patologia SET estado= 'ACT' WHERE id_patologia=:id_patologia ");
            $consulta->bindParam(":id_patologia", $id_patologia);
            $consulta->execute();
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }


    // mostrar patologia del paciente
    public function mostrarPatologiaP($id_paciente)
    {
        try {

            $sql = $this->conexion->prepare('SELECT pat.id_patologia, pat.nombre_patologia FROM patologiadepaciente pdp INNER JOIN patologia pat ON pdp.id_patologia = pat.id_patologia INNER JOIN paciente pac ON pdp.id_paciente = pac.id_paciente WHERE pac.id_paciente = :id_paciente');
            $sql->bindParam(":id_paciente", $id_paciente);

            return ($sql->execute()) ? $sql->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
