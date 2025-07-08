<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloPacientes extends Db
{

	private $conexion;

	public function __construct()
	{
		$this->conexion = $this->connectionSistema();
	}

	public function index()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE estado = 'ACT' ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function indexHistorial()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT 
				h.id_historial,
				h.id_paciente,
				p.nombre AS nombre_paciente,
				p.apellido AS apellido_paciente,
				p.cedula AS cedula_paciente,
				h.estado_anterior,
				h.estado_nuevo,
				h.fecha_cambio,
				h.id_control,
				h.id_usuario
			FROM 
				historial_estados h
			JOIN 
				paciente p ON h.id_paciente = p.id_paciente");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function indexPapelera()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE estado = 'DES' ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function insertar($nacionalidad, $cedula, $nombre, $apellido, $telefono, $direccion, $fn, $genero)
	{

		try {
			$consulta = $this->conexion->prepare("INSERT INTO paciente (nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, genero,estado) VALUES (:nacionalidad, :cedula, :nombre, :apellido, :telefono, :direccion, :fn, :genero, 'ACT')");
			$consulta->bindParam(":nacionalidad", $nacionalidad);
			$consulta->bindParam(":cedula", $cedula);
			$consulta->bindParam(":nombre", $nombre);
			$consulta->bindParam(":apellido", $apellido);
			$consulta->bindParam(":telefono", $telefono);
			$consulta->bindParam(":direccion", $direccion);
			$consulta->bindParam(":fn", $fn);
			$consulta->bindParam(":genero", $genero);
			$consulta->execute();
			return 1;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function update($id_paciente, $nacionalidad,  $cedula, $nombre, $apellido, $telefono, $direccion, $fn, $genero)
	{
		try {
			// UPDATE paciente SET id_nacionalidad=,cedula=],nombre=,apellido=,telefono=,direccion=,fn= WHERE 1
			$consulta = $this->conexion->prepare("UPDATE paciente SET nacionalidad=:nacionalidad,cedula=:cedula,nombre=:nombre,apellido=:apellido,telefono=:telefono,direccion=:direccion,fn=:fn, genero=:genero WHERE id_paciente = :id_paciente");
			$consulta->bindParam(":id_paciente", $id_paciente);
			$consulta->bindParam(":nacionalidad", $nacionalidad);
			$consulta->bindParam(":cedula", $cedula);
			$consulta->bindParam(":nombre", $nombre);
			$consulta->bindParam(":apellido", $apellido);
			$consulta->bindParam(":telefono", $telefono);
			$consulta->bindParam(":direccion", $direccion);
			$consulta->bindParam(":fn", $fn);
			$consulta->bindParam(":genero", $genero);
			$consulta->execute();
			return 1;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function delete($cedula)
	{
		try {
			$consulta = $this->conexion->prepare("DELETE from paciente  WHERE cedula = :cedula");
			$consulta->bindParam(":cedula", $cedula);
			$consulta->execute();
			return 1;
		} catch (\Exception $e) {
			return 0;
		}
	}
	public function restablecer($id_paciente)
	{
		try {
			$consulta = $this->conexion->prepare("UPDATE paciente SET estado = 'ACT' WHERE id_paciente = :id_paciente");
			$consulta->bindParam(":id_paciente", $id_paciente);
			$consulta->execute();
			return 1;
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
			$consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE cedula =:cedula");

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
