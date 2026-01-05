<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\Validations;

class ModeloPacientes extends ModelBase
{
	private $id_paciente, $nacionalidad, $cedula, $cedulaRegistrada, $nombre, $apellido, $telefono, $direccion, $fn, $genero;


	// Validaciones con expresiones regulares
	public $validaciones;

	public function __construct($dbSystem)
	{
		parent::__construct($dbSystem);
	}

	public function index()
	{
		try {
			$sql = "SELECT * FROM paciente WHERE estado = 'ACT'";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// public function indexHistorial()
	// {
	// 	try {
	// 		$consulta = $this->conexion->prepare("SELECT 
	// 			h.id_historial,
	// 			h.id_paciente,
	// 			p.nombre AS nombre_paciente,
	// 			p.apellido AS apellido_paciente,
	// 			p.cedula AS cedula_paciente,
	// 			h.estado_anterior,
	// 			h.estado_nuevo,
	// 			h.fecha_cambio,
	// 			h.id_control,
	// 			h.id_usuario
	// 		FROM 
	// 			historial_estados h
	// 		JOIN 
	// 			paciente p ON h.id_paciente = p.id_paciente");
	// 		return ($consulta->execute()) ? $consulta->fetchAll() : false;
	// 	} catch (\Exception $e) {
	// 		return 0;
	// 	}
	// }

	public function indexPapelera()
	{
		try {
			$sql = "SELECT * FROM paciente WHERE estado = 'DES'";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function insertar()
	{

		try {
			$data = [
				'nacionalidad' => $this->getNacionalidad(),
				'cedula' => $this->getCedula(),
				'nombre' => $this->getNombre(),
				'apellido' => $this->getApellido(),
				'telefono' => $this->getTelefono(),
				'direccion' => $this->getDireccion(),
				'fn' => $this->getFn(),
				'genero' => $this->getGenero(),
				'estado' => 'ACT'
			];

			$fecha = date("Y-m-d");
			$dt = \DateTime::createFromFormat('Y-m-d', $this->getFn());

			// obtener validaciones desde la clase
			$validaciones = Validations::patientRules(
				$this->getNombre(),
				$this->getApellido(),
				$this->getCedula(),
				$this->getTelefono(),
				$this->getDireccion(),
				$this->getFn(),
				$this->getGenero()
			);

			foreach ($validaciones as $v) {
				if (!preg_match($v['regex'], $v['valor'])) {
					throw new \Exception($v['mensaje']);
				}
			}

			// Validación de fecha
			if (!$dt || $dt->format('Y-m-d') !== $this->getFn()) {
				throw new \Exception("La fecha debe tener el formato YYYY-MM-DD.");
			}
			if ($fecha <= $this->getFn()) {
				throw new \Exception("La fecha no puede ser del futuro.");
			}
			// Validación de cédula duplicada
			if ($this->validarCedula(['cedula' => $this->getCedula()])) {
				throw new \Exception("La cédula ya está registrada.");
			}

			$sql = "INSERT INTO paciente (nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, genero,estado) VALUES (:nacionalidad, :cedula, :nombre, :apellido, :telefono, :direccion, :fn, :genero, :estado)";
			$this->setSQL($sql);

			$this->create($data);

			return ['exito', $data];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function update_paciente()
	{
		try {

			$data = [
				'nacionalidad' => $this->getNacionalidad(),
				'cedula' => $this->getCedula(),
				'nombre' => $this->getNombre(),
				'apellido' => $this->getApellido(),
				'telefono' => $this->getTelefono(),
				'direccion' => $this->getDireccion(),
				'fn' => $this->getFn(),
				'genero' => $this->getGenero()
			];

			$fecha = date("Y-m-d");
			$dt = \DateTime::createFromFormat('Y-m-d', $this->getFn());

			// obtener validaciones desde la clase
			$validaciones = Validations::patientRules(
				$this->getNombre(),
				$this->getApellido(),
				$this->getCedula(),
				$this->getTelefono(),
				$this->getDireccion(),
				$this->getFn(),
				$this->getGenero()
			);

			foreach ($validaciones as $v) {
				if (!preg_match($v['regex'], $v['valor'])) {
					throw new \Exception($v['mensaje']);
				}
			}

			// Validación de fecha
			if (!$dt || $dt->format('Y-m-d') !== $this->getFn()) {
				throw new \Exception("La fecha debe tener el formato YYYY-MM-DD.");
			}
			if ($fecha <= $this->getFn()) {
				throw new \Exception("La fecha no puede ser del futuro.");
			}

			$data2 = [
				'id_paciente' => $this->getIdPaciente()
			];

			$sql = "SELECT * from paciente where id_paciente=:id_paciente";
			$this->setSQL($sql);

			$validar  = $this->search($data2, false);

			if ($validar == []) {
				throw new \Exception("El id del paciente no existe");
			}

			$cedula = $this->validarCedula(['cedula' => $this->getCedula()], true);


			if ($this->getCedulaRegistrada() == $cedula) {

				$sql = "UPDATE paciente SET nacionalidad=:nacionalidad, cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono, direccion=:direccion, fn=:fn, genero=:genero WHERE id_paciente = :id";

				$this->setSQL($sql);
				$this->update($data, $this->getIdPaciente());
			} else {
				// Validación de cédula duplicada
				if ($this->validarCedula(['cedula' => $this->getCedula()])) {
					throw new \Exception("La cédula ya está registrada.");
				} else {
					$sql = "UPDATE paciente SET nacionalidad=:nacionalidad, cedula=:cedula, nombre=:nombre, apellido=:apellido, telefono=:telefono, direccion=:direccion, fn=:fn, genero=:genero WHERE id_paciente = :id";

					$this->setSQL($sql);
					$this->update($data, $this->getIdPaciente());
				}

			}

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function delete()
	{
		try {

			$data = [
				'id_paciente' => $this->getIdPaciente()
			];

			$sql = "SELECT * from paciente where id_paciente=:id_paciente";
			$this->setSQL($sql);

			$validar  = $this->search($data, false);

			if ($validar == []) {
				throw new \Exception("El id del paciente no existe");
			}

			$sql = "UPDATE paciente SET estado = 'DES' WHERE id_paciente =:id";
			$this->setSQL($sql);

			$this->update_logic($data['id_paciente']);
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	public function restablecer()
	{
		try {

			$data = [
				'id_paciente' => $this->getIdPaciente()
			];

			$sql = "SELECT * from paciente where id_paciente=:id_paciente";
			$this->setSQL($sql);

			$validar  = $this->search($data, false);

			if ($validar == []) {
				throw new \Exception("El id del paciente no existe");
			}

			$sql = "UPDATE paciente SET estado = 'ACT' WHERE id_paciente =:id";
			$this->setSQL($sql);

			$this->update_logic($data['id_paciente']);

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function validarCedula($data, $returnCedula = false)
	{
		try {
			$sql = "SELECT * FROM paciente WHERE cedula =:cedula";
			$this->setSQL($sql);
			$listData = $this->search($data, false);

			if ($returnCedula) {
				return !empty($listData) ? $listData['cedula'] : 0;
			} else {
				return !empty($listData) ? 1 : 0;
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function getIdPaciente()
	{
		return $this->id_paciente;
	}

	public function setIdPaciente($id_paciente)
	{
		$this->id_paciente = $id_paciente;
	}

	public function getNacionalidad()
	{
		return $this->nacionalidad;
	}

	public function setNacionalidad($nacionalidad)
	{
		$this->nacionalidad = $nacionalidad;
	}

	public function getCedula()
	{
		return $this->cedula;
	}

	public function setCedula($cedula)
	{
		$this->cedula = $cedula;
	}

	public function getCedulaRegistrada()
	{
		return $this->cedulaRegistrada;
	}

	public function setCedulaRegistrada($cedula)
	{
		$this->cedulaRegistrada = $cedula;
	}

	public function getNombre()
	{
		return $this->nombre;
	}

	public function setNombre($nombre)
	{
		$this->nombre = $nombre;
	}

	public function getApellido()
	{
		return $this->apellido;
	}

	public function setApellido($apellido)
	{
		$this->apellido = $apellido;
	}

	public function getTelefono()
	{
		return $this->telefono;
	}

	public function setTelefono($telefono)
	{
		$this->telefono = $telefono;
	}

	public function getDireccion()
	{
		return $this->direccion;
	}

	public function setDireccion($direccion)
	{
		$this->direccion = $direccion;
	}

	public function getFn()
	{
		return $this->fn;
	}

	public function setFn($fn)
	{
		$this->fn = $fn;
	}

	public function getGenero()
	{
		return $this->genero;
	}

	public function setGenero($genero)
	{
		$this->genero = $genero;
	}
}
