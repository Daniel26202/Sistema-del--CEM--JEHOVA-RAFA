<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloCliente extends Db
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = $this->connectionSistema();
    }

    public function index()
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM cliente WHERE estado = 'ACT' ");
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function indexPapelera()
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM cliente WHERE estado = 'DES' ");
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function insertar($nacionalidad, $cedula, $nombre, $apellido, $telefono, $direccion, $fn, $genero)
    {

        try {
            $consulta = $this->conexion->prepare("INSERT INTO cliente (nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, genero,estado) VALUES (:nacionalidad, :cedula, :nombre, :apellido, :telefono, :direccion, :fn, :genero, 'ACT')");
            $consulta->bindParam(":nacionalidad", $nacionalidad);
            $consulta->bindParam(":cedula", $cedula);
            $consulta->bindParam(":nombre", $nombre);
            $consulta->bindParam(":apellido", $apellido);
            $consulta->bindParam(":telefono", $telefono);
            $consulta->bindParam(":direccion", $direccion);
            $consulta->bindParam(":fn", $fn);
            $consulta->bindParam(":genero", $genero);
            $consulta->execute();
            $id_cliente = $this->conexion->lastInsertId();
            return ["exito", $id_cliente];
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function update($id_cliente, $nacionalidad,  $cedula, $nombre, $apellido, $telefono, $direccion, $fn, $genero)
    {
        try {
            // UPDATE paciente SET id_nacionalidad=,cedula=],nombre=,apellido=,telefono=,direccion=,fn= WHERE 1
            $consulta = $this->conexion->prepare("UPDATE cliente SET nacionalidad=:nacionalidad,cedula=:cedula,nombre=:nombre,apellido=:apellido,telefono=:telefono,direccion=:direccion,fn=:fn, genero=:genero WHERE id_cliente = :id_cliente");
            $consulta->bindParam(":id_cliente", $id_cliente);
            $consulta->bindParam(":nacionalidad", $nacionalidad);
            $consulta->bindParam(":cedula", $cedula);
            $consulta->bindParam(":nombre", $nombre);
            $consulta->bindParam(":apellido", $apellido);
            $consulta->bindParam(":telefono", $telefono);
            $consulta->bindParam(":direccion", $direccion);
            $consulta->bindParam(":fn", $fn);
            $consulta->bindParam(":genero", $genero);
            $consulta->execute();
            return "exito";
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function delete($cedula)
    {
        try {
            $consulta = $this->conexion->prepare("UPDATE cliente SET estado = 'DES' WHERE cedula = :cedula");
            $consulta->bindParam(":cedula", $cedula);
            $consulta->execute();
            return "exito";
        } catch (\Exception $e) {
            return 0;
        }
    }
    public function restablecer($cedula)
    {
        try {
            $consulta = $this->conexion->prepare("UPDATE cliente SET estado = 'ACT' WHERE cedula = :cedula");
            $consulta->bindParam(":cedula", $cedula);
            $consulta->execute();
            return "exito";
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function buscar($cedula)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT paciente.id_paciente, paciente.nacionalidad, paciente.cedula, paciente.nombre, paciente.apellido, paciente.telefono, paciente.direccion, paciente.fn, patologia.id_patologia, patologia.nombre_patologia FROM paciente JOIN patologiadepaciente ON paciente.id_paciente = patologiadepaciente.id_paciente JOIN patologia ON patologiadepaciente.id_patologia = patologia.id_patologia WHERE paciente.cedula = :cedula AND paciente.estado = 'ACT' ");
            $consulta->bindParam(":cedula", $cedula);
            $consulta->execute();
            return ($consulta->execute()) ? $consulta->fetchAll() : false;
        } catch (\Exception $e) {
            return 0;
        }
    }


    public function validarCedula($cedula)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM cliente WHERE cedula =:cedula");

            $consulta->bindParam(":cedula", $cedula);
            $consulta->execute();

            while ($consulta->fetch()) {
                return "existeC";
            }

            return "noExiste";
        } catch (\Exception $e) {
            return 0;
        }
    }
}
