<?php

namespace App\modelos;

use App\modelos\Db;
use App\config\Validations;

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
            $fecha = date("Y-m-d");
            $dt = \DateTime::createFromFormat('Y-m-d', $fn);

            $validaciones = Validations::patientRules($nombre, $apellido, $cedula, $telefono, $direccion, $fn, $genero);


            foreach ($validaciones as $v) {
                if (!preg_match($v['regex'], $v['valor'])) {
                    throw new \Exception($v['mensaje']);
                }
            }

            // Validación de fecha
            if (!$dt || $dt->format('Y-m-d') !== $fn) {
                throw new \Exception("La fecha debe tener el formato YYYY-MM-DD.");
            }
            if ($fecha <= $fn) {
                throw new \Exception("La fecha no puede ser del futuro.");
            }
            // Validación de cédula duplicada
            if ($this->validarCedula($cedula) === "existeC") {
                throw new \Exception("La cédula ya está registrada.");
            }

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
            return $e->getMessage();
        }
    }


    public function update($id_cliente, $nacionalidad,  $cedula, $nombre, $apellido, $telefono, $direccion, $fn, $genero,$cedulaRegistrada)
    {
        try {
            $fecha = date("Y-m-d");
            $dt = \DateTime::createFromFormat('Y-m-d', $fn);

            $validaciones = Validations::patientRules($nombre, $apellido, $cedula, $telefono, $direccion, $fn, $genero);


            foreach ($validaciones as $v) {
                if (!preg_match($v['regex'], $v['valor'])) {
                    throw new \Exception($v['mensaje']);
                }
            }

            // Validación de fecha
            if (!$dt || $dt->format('Y-m-d') !== $fn) {
                throw new \Exception("La fecha debe tener el formato YYYY-MM-DD.");
            }
            if ($fecha <= $fn) {
                throw new \Exception("La fecha no puede ser del futuro.");
            }

            $validar = $this->conexion->prepare("SELECT * from cliente where id_cliente=:id_cliente");
            $validar->bindParam(":id_cliente", $id_cliente);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo");
            }

            if ($cedulaRegistrada == $cedula) {
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
            } else {
                // Validación de cédula duplicada
                if ($this->validarCedula($cedula) === "existeC") {
                    throw new \Exception("La cédula ya está registrada.");
                } else {

                }
            }
            return ["exito"];
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function delete($cedula)
    {
        try {
            $validar = $this->conexion->prepare("SELECT * from cliente where cedula=:cedula");
            $validar->bindParam(":cedula", $cedula);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo");
            }

            $consulta = $this->conexion->prepare("UPDATE cliente SET estado = 'DES' WHERE cedula = :cedula");
            $consulta->bindParam(":cedula", $cedula);
            $consulta->execute();
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function restablecer($id_cliente)
    {
        try {
            $validar = $this->conexion->prepare("SELECT * from cliente where id_cliente=:id_cliente");
            $validar->bindParam(":id_cliente", $id_cliente);
            $validar->execute();
            if ($validar->rowCount() <= 0) {
                throw new \Exception("Fallo");
            }
            
            $consulta = $this->conexion->prepare("UPDATE cliente SET estado = 'ACT' WHERE id_cliente = :id_cliente");
            $consulta->bindParam(":id_cliente", $id_cliente);
            $consulta->execute();
            return ["exito"];
        } catch (\Exception $e) {
            return $e->getMessage();
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
