<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\RateLimiter;


class ModeloPacientes extends ModelBase
{
	private $id_paciente, $nacionalidad, $cedula, $cedulaRegistrada, $nombre, $apellido, $telefono, $direccion, $fn, $genero;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	// ── READ (sin protección según el profe) ────────────────────────────────

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

	public function indexHistorial()
	{
		try {
			$sql = "SELECT 
                        c.id_control,
                        c.id_paciente,
                        p.cedula,
                        p.nacionalidad,
                        p.nombre       AS nombre_paciente,
                        p.apellido     AS apellido_paciente,
                        p.estado_salud,
                        c.diagnostico
                    FROM  control c
                    JOIN  paciente p ON c.id_paciente = p.id_paciente";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e;
		}
	}

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

	// ── PRIVADOS (lógica pura de BD) ─────────────────────────────────────────

	private function insertar()
	{
		try {
			$data = [
				'nacionalidad' => $this->getNacionalidad(),
				'cedula'       => $this->getCedula(),
				'nombre'       => $this->getNombre(),
				'apellido'     => $this->getApellido(),
				'telefono'     => $this->getTelefono(),
				'direccion'    => $this->getDireccion(),
				'fn'           => $this->getFn(),
				'genero'       => $this->getGenero(),
				'estado'       => 'ACT'
			];

			if ($this->validarCedula(['cedula' => $this->getCedula()])) {
				throw new \Exception("La cédula ya está registrada.");
			}

			$sql = "INSERT INTO paciente 
                        (nacionalidad, cedula, nombre, apellido, telefono, direccion, fn, genero, estado)
                    VALUES 
                        (:nacionalidad, :cedula, :nombre, :apellido, :telefono, :direccion, :fn, :genero, :estado)";
			$this->setSQL($sql);
			$this->create($data);

			return ['exito', $data];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	private function update_paciente()
	{
		try {
			$data  = [
				'nacionalidad' => $this->getNacionalidad(),
				'cedula'       => $this->getCedula(),
				'nombre'       => $this->getNombre(),
				'apellido'     => $this->getApellido(),
				'telefono'     => $this->getTelefono(),
				'direccion'    => $this->getDireccion(),
				'fn'           => $this->getFn(),
				'genero'       => $this->getGenero()
			];
			$data2 = ['id_paciente' => $this->getIdPaciente()];

			$sql = "SELECT * FROM paciente WHERE id_paciente = :id_paciente";
			$this->setSQL($sql);
			if ($this->search($data2, false) == []) {
				throw new \Exception("El id del paciente no existe.");
			}

			$cedulaEnBD = $this->validarCedula(['cedula' => $this->getCedula()], true);

			// Si la cédula no cambió, actualiza directo; si cambió, verifica duplicado
			if ($this->getCedulaRegistrada() !== $cedulaEnBD) {
				if ($this->validarCedula(['cedula' => $this->getCedula()])) {
					throw new \Exception("La cédula ya está registrada.");
				}
			}

			$sql = "UPDATE paciente 
                    SET nacionalidad=:nacionalidad, cedula=:cedula, nombre=:nombre,
                        apellido=:apellido, telefono=:telefono, direccion=:direccion,
                        fn=:fn, genero=:genero
                    WHERE id_paciente = :id";
			$this->setSQL($sql);
			$this->update($data, $this->getIdPaciente());

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	private function delete_paciente()
	{
		try {
			$data = ['id_paciente' => $this->getIdPaciente()];

			$sql = "SELECT * FROM paciente WHERE id_paciente = :id_paciente";
			$this->setSQL($sql);
			if ($this->search($data, false) == []) {
				throw new \Exception("El id del paciente no existe.");
			}

			$sql = "UPDATE paciente SET estado = 'DES' WHERE id_paciente = :id";
			$this->setSQL($sql);
			$this->update_logic($data['id_paciente']);

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	private function restablecer()
	{
		try {
			$data = ['id_paciente' => $this->getIdPaciente()];

			$sql = "SELECT * FROM paciente WHERE id_paciente = :id_paciente";
			$this->setSQL($sql);
			if ($this->search($data, false) == []) {
				throw new \Exception("El id del paciente no existe.");
			}

			$sql = "UPDATE paciente SET estado = 'ACT' WHERE id_paciente = :id";
			$this->setSQL($sql);
			$this->update_logic($data['id_paciente']);

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	private function validarCedula($data, $returnCedula = false)
	{
		try {
			$sql = "SELECT * FROM paciente WHERE cedula = :cedula";
			$this->setSQL($sql);
			$listData = $this->search($data, false);

			if ($returnCedula) {
				return !empty($listData) ? $listData['cedula'] : 0;
			}
			return !empty($listData) ? 1 : 0;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// ── PÚBLICOS con seguridad (INSERT / UPDATE / DELETE) ────────────────────

	private function validarSesion($idUsuario): void
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		if (!isset($_SESSION['id_usuario']) && $idUsuario === null) {
			throw new \Exception('No hay sesión activa o usuario no autenticado.');
		}
	}

	private function validarCamposObligatorios(array $campos): void
	{
		foreach ($campos as $campo) {
			if (empty($campo)) {
				throw new \Exception('No se permiten campos vacíos.');
			}
		}
	}

	public function guardarPaciente($idUsuario = null)
	{
		$this->validarSesion($idUsuario);

		$this->validarCamposObligatorios([
			$this->nacionalidad,
			$this->cedula,
			$this->nombre,
			$this->apellido,
			$this->telefono,
			$this->direccion,
			$this->fn,
			$this->genero
		]);

		(new RateLimiter())->verificar('guardar_paciente_' . $idUsuario, 5, 1);

		return $this->insertar();
	}

	public function editarPaciente($idUsuario = null)
	{
		$this->validarSesion($idUsuario);

		$this->validarCamposObligatorios([
			$this->id_paciente,
			$this->nacionalidad,
			$this->cedula,
			$this->cedulaRegistrada,
			$this->nombre,
			$this->apellido,
			$this->telefono,
			$this->direccion,
			$this->fn,
			$this->genero
		]);

		(new RateLimiter())->verificar('editar_paciente_' . $idUsuario, 5, 1);

		return $this->update_paciente();
	}

	public function eliminarPaciente($idUsuario = null)
	{
		$this->validarSesion($idUsuario);

		$this->validarCamposObligatorios([$this->id_paciente]);

		(new RateLimiter())->verificar('eliminar_paciente_' . $idUsuario, 5, 1);

		return $this->delete_paciente();
	}

	public function restablecerPaciente($idUsuario = null)
	{
		$this->validarSesion($idUsuario);

		$this->validarCamposObligatorios([$this->id_paciente]);

		(new RateLimiter())->verificar('restablecer_paciente_' . $idUsuario, 5, 1);

		return $this->restablecer();
	}

	// ── Getters & Setters ────────────────────────────────────────────────────

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
		if (!preg_match("/^[0-9]+$/", $id_paciente) || (int)$id_paciente <= 0) {
			throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
		}
		$this->id_paciente = (int)$id_paciente;
	}

	public function setNacionalidad($nacionalidad)
	{
		// ✅ Bug corregido: era (!$nacionalidad == 'V' || ...)
		if ($nacionalidad !== 'V' && $nacionalidad !== 'E') {
			throw new \InvalidArgumentException("La nacionalidad debe ser V o E.");
		}
		$this->nacionalidad = $nacionalidad;
	}

	public function setCedula($cedula)
	{
		if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
		}
		$this->cedula = $cedula;
	}

	public function setCedulaRegistrada($cedula)
	{
		if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula registrada debe contener entre 7 y 8 dígitos.");
		}
		$this->cedulaRegistrada = $cedula;
	}

	public function setNombre($nombre)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $nombre)) {
			throw new \InvalidArgumentException("El nombre debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
		}
		$this->nombre = $nombre;
	}

	public function setApellido($apellido)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,}(\s[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,})*$/", $apellido)) {
			throw new \InvalidArgumentException("El apellido debe iniciar con mayúscula, tener al menos 3 letras y puede incluir un segundo nombre separado por un espacio.");
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
		if (!$dt || $dt->format('Y-m-d') !== $fn) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fn >= date("Y-m-d")) {
			throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
		}
		$this->fn = $fn;
	}

	public function setGenero($genero)
	{
		if (!preg_match("/^(Masculino|Femenino)$/", $genero)) {
			throw new \InvalidArgumentException("El género debe ser 'Masculino' o 'Femenino'.");
		}
		$this->genero = $genero;
	}
}
