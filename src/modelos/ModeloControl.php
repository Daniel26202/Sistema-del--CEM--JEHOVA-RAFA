<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\RateLimiter;

class ModeloControl extends ModelBase
{
	private $historial, $id_control, $diagnostico, $sintomas, $indicaciones, $fechaRegreso, $patologias, $nota, $severidad, $cedula, $id_usuario, $nacionalidad, $id_paciente;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	public function buscarPacientes()
	{
		$sql = "SELECT p.id_paciente, p.nacionalidad, p.cedula, p.nombre, p.apellido , p.telefono, p.direccion, p.fn, p.genero, p.estado_salud FROM paciente p INNER JOIN control co ON co.id_paciente = p.id_paciente WHERE p.cedula LIKE :cedula AND co.estado = 'ACT' GROUP BY p.cedula";
		$this->setSQL($sql);
		return $this->search(['cedula' => '%' . $this->getCedula() . '%']);
	}



	public function mostrarControlPacienteA()
	{
		$data = ['cedula' => $this->getCedula(), 'estado' => 'ACT'];
		$sql  = "SELECT co.id_control,co.id_usuario,co.diagnostico,co.medicamentosRecetados,co.fecha_control,co.fechaRegreso,co.nota, co.historiaclinica,co.severidad, p.id_paciente, p.nacionalidad, p.cedula, p.nombre, p.apellido , p.telefono, p.direccion, p.fn, p.genero, p.estado_salud  FROM paciente p INNER JOIN control co ON co.id_paciente = p.id_paciente WHERE p.cedula = :cedula AND co.estado = :estado";
		$this->setSQL($sql);
		return $this->search($data);
	}

	public function mostrarControlPacienteU()
	{
		$data = ['cedula' => $this->getCedula(), 'estado' => 'ACT', 'id' => $this->getIdUsuario()];
		$sql  = "SELECT co.id_control,co.id_usuario,co.diagnostico,co.medicamentosRecetados,co.fecha_control,co.fechaRegreso,co.nota, co.historiaclinica,co.severidad, p.id_paciente, p.nacionalidad, p.cedula, p.nombre, p.apellido , p.telefono, p.direccion, p.fn, p.genero, p.estado_salud, usu.id_usuario FROM control co INNER JOIN paciente p ON co.id_paciente = p.id_paciente INNER JOIN segurity.usuario usu ON co.id_usuario = usu.id_usuario WHERE p.cedula = :cedula AND co.estado = :estado AND usu.id_usuario = :id";
		$this->setSQL($sql);
		return $this->search($data);
	}

	public function mostrarPaciente()
	{
		$data = ['cedula' => $this->getCedula(), 'estado' => 'ACT'];
		$sql  = "SELECT id_paciente, nacionalidad, cedula, nombre, apellido , telefono, direccion, fn, genero FROM paciente WHERE estado = :estado AND cedula = :cedula";
		$this->setSQL($sql);
		return $this->search($data, false);
	}

	public function mostrarDoctor()
	{
		$sql = 'SELECT c.id_categoria, c.nombre AS categoria, sm.id_servicioMedico, ps.personal_id_personal, u.id_usuario, p.nombre AS nombredoc, p.apellido as apellidodoc, sm.precio FROM serviciomedico sm INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN personal p ON ps.personal_id_personal = p.id_personal INNER JOIN segurity.usuario u ON p.usuario = u.id_usuario INNER JOIN categoria_servicio c ON c.id_categoria = sm.id_categoria WHERE sm.estado = "ACT" GROUP BY p.nombre';
		$this->setSQL($sql);
		return $this->read();
	}

	public function mostrarUltimoIdControl()
	{
		$data    = ['cedula' => $this->getCedula()];
		$sql     = "SELECT c.id_control FROM control c INNER JOIN paciente p ON p.id_paciente = c.id_paciente WHERE p.cedula = :cedula ORDER BY c.fecha_control DESC LIMIT 1";
		$this->setSQL($sql);
		$control = $this->search($data, false);
		return $control['id_control'] ?? null;
	}

	public function mostrarSintomasPaId()
	{
		$data = ['idControl' => $this->getIdControl()];
		$sql  = "SELECT s.id_sintomas, s.nombre AS nombreS, c.id_control FROM sintomas s INNER JOIN sintomas_control sc ON sc.id_sintomas = s.id_sintomas INNER JOIN control c ON sc.id_control = c.id_control INNER JOIN paciente p ON c.id_paciente = p.id_paciente WHERE c.id_control = :idControl";
		$this->setSQL($sql);
		return $this->search($data);
	}

	public function mostrarPatologiaP()
	{
		$data = ['idControl' => $this->getIdControl()];
		$sql  = "SELECT pat.id_patologia, pat.nombre_patologia FROM control c INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN patologiadepaciente pdp ON p.id_paciente = pdp.id_paciente INNER JOIN patologia pat ON pdp.id_patologia = pat.id_patologia WHERE c.id_control = :idControl AND pdp.fecha_registro = c.fecha_control ORDER BY c.fecha_control ASC";
		$this->setSQL($sql);
		return $this->search($data);
	}

	public function mostrarPatologiaC()
	{
		$data = ['id_paciente' => $this->getIdPaciente()];
		$sql  = 'SELECT pat.id_patologia, pat.nombre_patologia FROM control c INNER JOIN paciente p ON c.id_paciente = p.id_paciente INNER JOIN patologiadepaciente pdp ON p.id_paciente = pdp.id_paciente INNER JOIN patologia pat ON pdp.id_patologia = pat.id_patologia WHERE c.id_control = (SELECT id_control FROM control WHERE id_paciente = :id_paciente AND estado = "ACT" ORDER BY fecha_control DESC LIMIT 1) AND pdp.fecha_registro = c.fecha_control ORDER BY c.fecha_control ASC';
		$this->setSQL($sql);
		return $this->search($data);
	}

	//  PRIVADOS 

	private function insertarControlDB()
	{
		$transaccionActiva = false;
		try {
			// 1. INICIAMOS LA TRANSACCIÓN DIRECTAMENTE
			$this->beginTransaction();
			$transaccionActiva = true;
			$fechaHoy = date("Y-m-d");


			// 2. BLOQUEO PESIMISTA A NIVEL DE FILA (FOR UPDATE)
			// Congelamos el registro del paciente para que ningún otro módulo 
			// altere sus datos médicos mientras se procesa este control histórico.
			$sqlPaciente = "SELECT id_paciente, estado_salud FROM paciente WHERE id_paciente = :id_paciente FOR UPDATE";
			$this->setSQL($sqlPaciente);
			$paciente = $this->search(['id_paciente' => $this->id_paciente], false);

			if (!$paciente) {
				throw new \Exception("El paciente especificado no existe.");
			}


			$validar = $this->search(['id_usuario' => $this->getIdUsuario()], false);
			if (empty($validar)) {
				throw new \Exception("El id del usuario no existe.");
			}

			if (!empty($this->getPatologias())) {
				foreach ($this->getPatologias() as $patologia) {
					$data = [
						'id_paciente'    => $this->getIdPaciente(),
						'id_patologia'   => $patologia,
						'fecha_registro' => $fechaHoy
					];
					$sql = "INSERT INTO patologiadepaciente (id_paciente, id_patologia, fecha_registro) VALUES (:id_paciente, :id_patologia, :fecha_registro)";
					$this->setSQL($sql);
					$this->create($data);
				}
			}

			$data = [
				'idPaciente'   => $this->getIdPaciente(),
				'idUsuario'    => $this->getIdUsuario(),
				'diagnostico'  => $this->getDiagnostico(),
				'indicaciones' => $this->getIndicaciones(),
				'fecha_control' => $fechaHoy,
				'fechaRegreso' => $this->getFechaDeRegreso(),
				'nota'         => $this->getNota(),
				'historial'    => $this->getHistorial(),
				'estado'       => 'ACT',
				'severidad'    => $this->getSeveridad()
			];
			$sql = "INSERT INTO control (id_paciente, id_usuario, diagnostico, medicamentosRecetados, fecha_control, fechaRegreso, nota, historiaclinica, estado, severidad) VALUES (:idPaciente, :idUsuario, :diagnostico, :indicaciones, :fecha_control, :fechaRegreso, :nota, :historial, :estado, :severidad)";
			$this->setSQL($sql);
			$idControl = $this->create($data);

			foreach ($this->getSintomas() as $sintoma) {
				$data = ['sintoma' => $sintoma, 'idControl' => $idControl];
				$sql  = "INSERT INTO sintomas_control (id_sintomas_control, id_sintomas, id_control) VALUES (null, :sintoma, :idControl)";
				$this->setSQL($sql);
				$this->create($data);
			}

			$this->commit();
			return ["exito"];
		} catch (\Exception $e) {
			if ($transaccionActiva) {
				$this->rollBack();
			}
			return $e->getMessage();
		}
	}

	private function editarControlDB()
	{
		try {
			$data  = [
				'diagnostico'  => $this->getDiagnostico(),
				'indicaciones' => $this->getIndicaciones(),
				'fechaRegreso' => $this->getFechaDeRegreso(),
				'nota'         => $this->getNota(),
				'historial'    => $this->getHistorial(),
				'severidad'    => $this->getSeveridad()
			];
			$data2 = ['id_control' => $this->getIdControl()];

			$sql = "SELECT id_control FROM control WHERE id_control = :id_control";
			$this->setSQL($sql);
			if ($this->search($data2, false) == []) {
				throw new \Exception("El id del control no existe.");
			}

			$sql = "UPDATE control SET diagnostico=:diagnostico, medicamentosRecetados=:indicaciones, fechaRegreso=:fechaRegreso, nota=:nota, historiaclinica=:historial, severidad=:severidad WHERE id_control = :id";
			$this->setSQL($sql);
			$this->update($data, $this->getIdControl());

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// PÚBLICOS

	private function validarSesion($idUsuario): void
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		if (!isset($_SESSION['id_usuario']) && $idUsuario === null) {
			throw new \Exception('No hay sesión activa o usuario no autenticado.');
		}
	}

	private function validarCamposObligatorios(array $campos, string $contexto = ''): void
	{
		foreach ($campos as $campo) {
			if (empty($campo)) {
				throw new \Exception("No se permiten campos vacíos{$contexto}.");
			}
		}
	}

	public function insertControl($idUsuario = null)
	{
		$this->validarSesion($idUsuario);
		$this->validarCamposObligatorios([
			$this->id_usuario,
			$this->id_paciente,
			$this->historial,
			$this->diagnostico,
			$this->indicaciones,
			$this->fechaRegreso,
			$this->severidad
		], ' al registrar un control');
		(new RateLimiter())->verificar('guardar_control_' . $idUsuario, 5, 1);
		return $this->insertarControlDB();
	}

	public function editarControl($idUsuario = null)
	{
		$this->validarSesion($idUsuario);
		$this->validarCamposObligatorios([
			$this->id_control,
			$this->historial,
			$this->diagnostico,
			$this->indicaciones,
			$this->fechaRegreso,
			$this->severidad
		], ' al editar un control');
		(new RateLimiter())->verificar('editar_control_' . $idUsuario, 5, 1);
		return $this->editarControlDB();
	}

	// ── Getters ───────────────────────────────────────────────────────────────

	public function getIdControl()
	{
		return $this->id_control;
	}
	public function getHistorial()
	{
		return $this->historial;
	}
	public function getDiagnostico()
	{
		return $this->diagnostico;
	}
	public function getSintomas()
	{
		return $this->sintomas;
	}
	public function getIndicaciones()
	{
		return $this->indicaciones;
	}
	public function getFechaDeRegreso()
	{
		return $this->fechaRegreso;
	}
	public function getPatologias()
	{
		return $this->patologias;
	}
	public function getNota()
	{
		return $this->nota;
	}
	public function getSeveridad()
	{
		return $this->severidad;
	}
	public function getCedula()
	{
		return $this->cedula;
	}
	public function getNacionalidad()
	{
		return $this->nacionalidad;
	}
	public function getIdUsuario()
	{
		return $this->id_usuario;
	}
	public function getIdPaciente()
	{
		return $this->id_paciente;
	}

	// ── Setters ───────────────────────────────────────────────────────────────

	public function setIdControl($id_control)
	{
		if (!preg_match("/^[0-9]+$/", $id_control)) {
			throw new \InvalidArgumentException("El ID del control debe ser un número entero positivo.");
		}
		$this->id_control = $id_control;
	}

	public function setHistorial($historial)
	{
		if (!preg_match("/^([A-Za-z0-9\s\.,#-]{8,})$/", $historial)) {
			throw new \InvalidArgumentException("El historial debe estar completo y detallado.");
		}
		$this->historial = $historial;
	}

	public function setDiagnostico($diagnostico)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][A-Za-záéíóúñ0-9\s,.\n\r]{7,}$/", $diagnostico)) {
			throw new \InvalidArgumentException("El diagnóstico debe iniciar con mayúscula y tener al menos 8 caracteres.");
		}
		$this->diagnostico = $diagnostico;
	}

	public function setSintomas($sintomas = [])
	{
		if (!is_array($sintomas)) {
			throw new \InvalidArgumentException("Síntomas no puede estar vacío.");
		}
		$this->sintomas = $sintomas;
	}

	public function setIndicaciones($indicaciones)
	{
		if (!preg_match("/^[A-ZÁÉÍÓÚÑ][A-Za-záéíóúñ0-9\s]{7,}$/", $indicaciones)) {
			throw new \InvalidArgumentException("Debe iniciar con mayúscula y tener al menos 8 caracteres.");
		}
		$this->indicaciones = $indicaciones;
	}

	public function setFechaRegreso($fechaRegreso)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fechaRegreso);
		if (!$dt || $dt->format('Y-m-d') !== $fechaRegreso) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fechaRegreso <= date("Y-m-d")) {
			throw new \InvalidArgumentException("La fecha no puede ser del pasado.");
		}
		$this->fechaRegreso = $fechaRegreso;
	}

	public function setPatologias($patologias = [])
	{
		if (!is_array($patologias)) {
			throw new \InvalidArgumentException("La patología no puede estar vacía.");
		}
		$this->patologias = $patologias;
	}

	public function setNota($nota)
	{
		$this->nota = $nota;
	}
	public function setSeveridad($severidad)
	{
		$this->severidad = $severidad;
	}

	public function setCedula($cedula)
	{
		if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
		}
		$this->cedula = $cedula;
	}

	public function setNacionalidad($nacionalidad)
	{

		if ($nacionalidad !== 'V' && $nacionalidad !== 'E') {
			throw new \InvalidArgumentException("La nacionalidad debe ser V o E.");
		}
		$this->nacionalidad = $nacionalidad;
	}

	public function setIdUsuario($id_usuario)
	{
		if (!preg_match("/^[0-9]+$/", $id_usuario) || (int)$id_usuario <= 0) {
			throw new \InvalidArgumentException("El ID del usuario debe ser un número entero positivo.");
		}
		$this->id_usuario = (int)$id_usuario;
	}

	public function setIdPaciente($id_paciente)
	{
		if (!preg_match("/^[0-9]+$/", $id_paciente) || (int)$id_paciente <= 0) {
			throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
		}
		$this->id_paciente = (int)$id_paciente;
	}
}
