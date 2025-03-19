<?php

namespace App\modelos;
use App\modelos\Db;

class ModeloPacientes extends Db
{

	private $conexion;
	
	public function __construct(){
        // Llama al constructor de la clase padre para establecer la conexión
        parent::__construct();
        
        // Aquí puedes usar $this para acceder a la conexión

        $this->conexion = $this; // Guarda la instancia de la conexión

    }
	
	public function index()
	{
		$consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE estado = 'ACT' ");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}
	public function indexPapelera()
	{
		$consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE estado = 'DES' ");
		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	}


	public function insertar($nacionalidad, $cedula, $nombre, $apellido, $telefono, $direccion, $fn)
	{

		$consulta = $this->conexion->prepare("INSERT INTO paciente (nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, estado) VALUES (:nacionalidad, :cedula, :nombre, :apellido, :telefono, :direccion, :fn, 'ACT')");
		$consulta->bindParam(":nacionalidad", $nacionalidad);
		$consulta->bindParam(":cedula", $cedula);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":apellido", $apellido);
		$consulta->bindParam(":telefono", $telefono);
		$consulta->bindParam(":direccion", $direccion);
		$consulta->bindParam(":fn", $fn);
		$consulta->execute();

	}


	public function update($id_paciente, $nacionalidad,  $cedula, $nombre, $apellido, $telefono, $direccion, $fn)
	{
		// UPDATE paciente SET id_nacionalidad=,cedula=],nombre=,apellido=,telefono=,direccion=,fn= WHERE 1
		$consulta = $this->conexion->prepare("UPDATE paciente SET nacionalidad=:nacionalidad,cedula=:cedula,nombre=:nombre,apellido=:apellido,telefono=:telefono,direccion=:direccion,fn=:fn WHERE id_paciente = :id_paciente");
		$consulta->bindParam(":id_paciente", $id_paciente);
		$consulta->bindParam(":nacionalidad", $nacionalidad);
		$consulta->bindParam(":cedula", $cedula);
		$consulta->bindParam(":nombre", $nombre);
		$consulta->bindParam(":apellido", $apellido);
		$consulta->bindParam(":telefono", $telefono);
		$consulta->bindParam(":direccion", $direccion);
		$consulta->bindParam(":fn", $fn);
		return ($consulta->execute()) ? true : false;
	}

	public function delete($id_paciente)
	{
		$consulta = $this->conexion->prepare("UPDATE paciente SET estado = 'DES' WHERE id_paciente = :id_paciente");
		$consulta->bindParam(":id_paciente", $id_paciente);
		return ($consulta->execute()) ? true : false;
	}
	public function restablecer($id_paciente)
	{
		$consulta = $this->conexion->prepare("UPDATE paciente SET estado = 'ACT' WHERE id_paciente = :id_paciente");
		$consulta->bindParam(":id_paciente", $id_paciente);
		return ($consulta->execute()) ? true : false;
	}

	public function buscar($cedula){
		$consulta = $this->conexion->prepare("SELECT paciente.id_paciente, paciente.nacionalidad, paciente.cedula, paciente.nombre, paciente.apellido, paciente.telefono, paciente.direccion, paciente.fn, patologia.id_patologia, patologia.nombre_patologia FROM paciente JOIN patologiadepaciente ON paciente.id_paciente = patologiadepaciente.id_paciente JOIN patologia ON patologiadepaciente.id_patologia = patologia.id_patologia WHERE paciente.cedula = :cedula AND paciente.estado = 'ACT' ");
			$consulta->bindParam(":cedula", $cedula);
			$consulta->execute();
			return ($consulta->execute()) ? $consulta->fetchAll() : false;	
	}


	public function validarCedula($cedula)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE cedula =:cedula");

        $consulta->bindParam(":cedula", $cedula);
        $consulta->execute();

        while ($consulta->fetch()) {
            return "existeC";
        }

        return 0;
    }

}
