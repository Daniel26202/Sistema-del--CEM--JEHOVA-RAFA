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



	public function getNacionalidad()
	{
		return $this->nacionalidad;
	}



	public function getCedula()
	{
		return $this->cedula;
	}



	public function getCedulaRegistrada()
	{
		return $this->cedulaRegistrada;
	}



	public function getNombre()
	{
		return $this->nombre;
	}


	public function getApellido()
	{
		return $this->apellido;
	}



	public function getTelefono()
	{
		return $this->telefono;
	}



	public function getDireccion()
	{
		return $this->direccion;
	}

	public function getFn()
	{
		return $this->fn;
	}


	public function getGenero()
	{
		return $this->genero;
	}



	public function setIdPaciente($id_paciente)
	{
		if (!preg_match("/^[0-9]+$/", $id_paciente)) {
			throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
		}

		if ((int)$id_paciente <= 0) {
			throw new \InvalidArgumentException("El ID del paciente debe ser mayor que cero.");
		}

		$this->id_paciente = (int)$id_paciente;
	}


	public function setNacionalidad($nacionalidad)
	{
		if (!preg_match("/^[A-Z]{1,3}$/", $nacionalidad)) {
			throw new \InvalidArgumentException("La nacionalidad debe ser V o E.");
		}
		$this->nacionalidad = $nacionalidad;
	}

	public function setCedula($cedula)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
		}
		$this->cedula = $cedula;
	}

	public function setCedulaRegistrada($cedula)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula registrada debe contener entre 7 y 8 dígitos.");
		}
		$this->cedulaRegistrada = $cedula;
	}

	public function setNombre($nombre)
	{
		if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,50}$/", $nombre)) {
			throw new \InvalidArgumentException("El nombre solo puede contener letras y espacios (2-50 caracteres).");
		}
		$this->nombre = $nombre;
	}

	public function setApellido($apellido)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}$/", $apellido)) {
			throw new \InvalidArgumentException("El Apellido debe contener solo letras, iniciar con mayúscula y tener al menos 3 caracteres.");
		}
		$this->apellido = $apellido;
	}

	public function setTelefono($telefono)
	{
		if (!preg_match("/^(0?)(412|422|414|416|424|426|212|24[1-9]|25[1-9])\d{7}$/", $telefono)) {
			throw new \InvalidArgumentException("El teléfono debe comenzar con un código válido y contener solo números.");
		}
		$this->telefono = $telefono;
	}

	public function setDireccion($direccion)
	{
		if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $direccion)) {
			throw new \InvalidArgumentException("La dirección debe estar completa y detallada.");
		}
		$this->direccion = $direccion;
	}

	public function setFn($fn)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fn);
		$fechaHoy = date("Y-m-d");

		if (!$dt || $dt->format('Y-m-d') !== $fn) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fn >= $fechaHoy) {
			throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
		}
		$this->fn = $fn;
	}

	public function setGenero($genero)
	{
		if (!preg_match("/^(Masculino|Femenino)$/", $genero)) {
			throw new \InvalidArgumentException("El género debe ser 'Masculino'  o 'Femenino' .");
		}
		$this->genero = $genero;
	}
}
