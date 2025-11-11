<?php

namespace App\modelos;

use App\modelos\Db;

class ModeloPacientes extends Db
{

	private $conexion;
	// Validaciones con expresiones regulares
	public $validaciones;

	public function __construct()
	{
		$this->conexion = $this->connectionSistema();
		// $this->validaciones = require '../config/expresionesRegulares.php';
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
			$fecha = date("Y-m-d");
			$dt = \DateTime::createFromFormat('Y-m-d', $fn);

			$validaciones = [
				['valor' => $nombre, 'regex' => '/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/', 'mensaje' => "El Nombre debe contener solo letras, iniciar con mayúscula y tener al menos 3 caracteres."],
				['valor' => $apellido, 'regex' => '/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/', 'mensaje' => "El Apellido debe contener solo letras, iniciar con mayúscula y tener al menos 3 caracteres."],
				['valor' => $cedula, 'regex' => '/^([1-9]{1})([0-9]{5,7})$/', 'mensaje' => "La cédula debe contener solo números y tener entre 6 y 7 caracteres."],
				['valor' => $telefono, 'regex' => '/^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/', 'mensaje' => 'El teléfono debe comenzar con un código válido y contener solo números.'],
				['valor' => $direccion, 'regex' => '/^([A-Za-z0-9\s\.,#-]{8,})$/', 'mensaje' => "La dirección debe estar completa y detallada."],
				['valor' => $fn, 'regex' => '/^\d{4}-\d{2}-\d{2}$/', 'mensaje' => "Fecha de nacimiento inválida: debe estar en formato YYYY-MM-DD."],
				['valor' => $genero, 'regex' => '/^(Masculino|Femenino)$/i', 'mensaje' => "Género inválido: debe ser 'Masculino' o 'Femenino'."]
			];

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

            $id = $this->conexion->lastInsertId();

			$consulta = $this->conexion->prepare("SELECT * from paciente where id_paciente=:id_paciente");
			$consulta->bindParam(":id_paciente", $id);
			$consulta->execute();
			$data = ($consulta->execute()) ? $consulta->fetch() : false;

			return ["exito", $data];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function update($id_paciente, $nacionalidad, $cedula, $nombre, $apellido, $telefono, $direccion, $fn, $genero, $cedulaRegistrada)
	{
		try {
			$fecha = date("Y-m-d");
			$dt = \DateTime::createFromFormat('Y-m-d', $fn);

			$validaciones = [
				['valor' => $nombre, 'regex' => '/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/', 'mensaje' => "El Nombre debe contener solo letras, iniciar con mayúscula y tener al menos 3 caracteres."],
				['valor' => $apellido, 'regex' => '/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/', 'mensaje' => "El Apellido debe contener solo letras, iniciar con mayúscula y tener al menos 3 caracteres."],
				['valor' => $cedula, 'regex' => '/^([1-9]{1})([0-9]{5,7})$/', 'mensaje' => "La cédula debe contener solo números y tener entre 6 y 7 caracteres."],
				['valor' => $telefono, 'regex' => '/^(0?)(412|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/', 'mensaje' => 'El teléfono debe comenzar con un código válido y contener solo números.'],
				['valor' => $direccion, 'regex' => '/^([A-Za-z0-9\s\.,#-]{8,})$/', 'mensaje' => "La dirección debe estar completa y detallada."],
				['valor' => $fn, 'regex' => '/^\d{4}-\d{2}-\d{2}$/', 'mensaje' => "Fecha de nacimiento inválida: debe estar en formato YYYY-MM-DD."],
				['valor' => $genero, 'regex' => '/^(Masculino|Femenino)$/i', 'mensaje' => "Género inválido: debe ser 'Masculino' o 'Femenino'."]
			];

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

			$validar = $this->conexion->prepare("SELECT * from paciente where id_paciente=:id_paciente");
			$validar->bindParam(":id_paciente", $id_paciente);
			$validar->execute();
			if ($validar->rowCount() <= 0) {
				throw new \Exception("Fallo");
			}

			 if ($cedulaRegistrada == $cedula) {
			// 	// UPDATE paciente SET id_nacionalidad=,cedula=],nombre=,apellido=,telefono=,direccion=,fn= WHERE 1
				$consulta = $this->conexion->prepare("UPDATE paciente SET nacionalidad=:nacionalidad, cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono, direccion=:direccion, fn=:fn, genero=:genero WHERE id_paciente = :id_paciente");
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
			} else {
				// Validación de cédula duplicada
				if ($this->validarCedula($cedula) === "existeC") {
					throw new \Exception("La cédula ya está registrada.");
				} else {
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
				}
			}

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();

		}
	}

	public function delete($cedula)
	{
		try {
			$validar = $this->conexion->prepare("SELECT * from paciente where cedula=:cedula");
			$validar->bindParam(":cedula", $cedula);
			$validar->execute();
			if ($validar->rowCount() <= 0) {
				throw new \Exception("El id del paciente no existe");
			}

			$consulta = $this->conexion->prepare("UPDATE paciente SET estado = 'DES' WHERE cedula = :cedula");
			$consulta->bindParam(":cedula", $cedula);
			$consulta->execute();
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function restablecer($id_paciente)
	{
		try {
			$validar = $this->conexion->prepare("SELECT * from paciente where id_paciente=:id_paciente");
			$validar->bindParam(":id_paciente", $id_paciente);
			$validar->execute();
			if ($validar->rowCount() <= 0) {
				throw new \Exception("Fallo");
			}
			
			$consulta = $this->conexion->prepare("UPDATE paciente SET estado = 'ACT' WHERE id_paciente = :id_paciente");
			$consulta->bindParam(":id_paciente", $id_paciente);
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
