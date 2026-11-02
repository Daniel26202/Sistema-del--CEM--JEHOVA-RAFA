<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloDoctores;


class ModeloInicio extends ModelBase
{
	private $idPersonal, $fechaInicio, $fechaFinal;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	public function retrunObjectModel()
	{
		return ["modeloDoctores" => new ModeloDoctores];
	}

	public function pacientes_hospitalizados()
	{
		try {
			$sql = "SELECT COUNT(id_hospitalizacion) AS total_hospitalizados FROM hospitalizacion WHERE estado = 'pendiente'";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function contarCitasPendientes()
	{
		$sql = "SELECT COUNT(DISTINCT c.id_cita) AS total
				FROM bd.serviciomedico sm
				INNER JOIN bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
				INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
				INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
				INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal
				INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
				WHERE c.estado = 'Pendiente' AND c.doctor = psm.personal_id_personal
					AND p.estado = 'ACT' AND c.fecha >= CURRENT_DATE";
		$this->setSQL($sql);
		return $this->read(false);
	}

	public function contarCitasDeHoy()
	{
		$sql = "SELECT COUNT(DISTINCT c.id_cita) AS total
				FROM bd.serviciomedico sm
				INNER JOIN bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
				INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
				INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
				INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal
				INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
				WHERE c.estado = 'Pendiente' AND c.doctor = psm.personal_id_personal
					AND p.estado = 'ACT' AND c.fecha = CURRENT_DATE";
		$this->setSQL($sql);
		return $this->read(false);
	}

	public function obtenerAgendaPersonal($idPersonal)
	{
		$sql = "SELECT c.fecha, c.hora, c.estado, cs.nombre AS categoria
				FROM bd.cita c
				INNER JOIN bd.serviciomedico sm ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico
				INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria
				INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
				WHERE c.doctor = :id_personal
					AND c.fecha >= CURRENT_DATE
					AND c.estado = 'Pendiente'
					AND p.estado = 'ACT'
				ORDER BY c.fecha, c.hora
				LIMIT 5";
		$this->setSQL($sql);
		return $this->search(['id_personal' => (int)$idPersonal]);
	}

	public function obtenerHorarioSemanal($idPersonal)
	{
		$sql = "SELECT h.id_horario, h.diaslaborables, hyd.horaDeEntrada, hyd.horaDeSalida
				FROM bd.horario h
				INNER JOIN bd.horarioydoctor hyd ON hyd.id_horario = h.id_horario
				WHERE hyd.id_personal = :id_personal
					AND NOT EXISTS (
						SELECT 1
						FROM bd.horarioydoctor hyd_reciente
						WHERE hyd_reciente.id_personal = hyd.id_personal
							AND hyd_reciente.id_horario = hyd.id_horario
							AND hyd_reciente.id_horarioydoctor > hyd.id_horarioydoctor
					)
				ORDER BY h.id_horario";
		$this->setSQL($sql);
		return $this->search(['id_personal' => (int)$idPersonal]);
	}


	public function servicios()
	{
		try {
			$sql = "SELECT c.nombre AS categoria, s.precio FROM serviciomedico s INNER JOIN categoria_servicio c ON s.id_categoria = c.id_categoria  WHERE s.estado = 'ACT' ";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function especialidades_solicitadas()
	{
		try {
			$data = [
				'fechaInicio' => $this->getFechaInicio(),
				'fechaFinal' => $this->getFechaFinal()
			];

			if ($this->getFechaInicio() == '' && $this->getFechaFinal() =="") {
				$sql = "SELECT   cs.nombre AS especialidad,
	COUNT(c.id_cita) AS total_solicitudes
					FROM cita c
					INNER JOIN serviciomedico sm 
					ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
					INNER JOIN categoria_servicio cs 
					ON sm.id_categoria = cs.id_categoria
					GROUP BY cs.nombre
					ORDER BY total_solicitudes DESC limit 5;
					";
				$this->setSQL($sql);
				return $this->read();
			} else {
				$sql = "SELECT   cs.nombre AS especialidad,
	COUNT(c.id_cita) AS total_solicitudes
					FROM cita c
					INNER JOIN serviciomedico sm 
					ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
					INNER JOIN categoria_servicio cs 
					ON sm.id_categoria = cs.id_categoria WHERE c.fecha BETWEEN :fechaInicio AND :fechaFinal
					GROUP BY cs.nombre 
					ORDER BY total_solicitudes DESC limit 5;
					";
				$this->setSQL($sql);

				return $this->search($data);
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function todas_las_especialidades()
	{
		try {
			$sql = "SELECT COUNT(c.serviciomedico_id_servicioMedico) AS total_servicios_por_cita FROM cita c INNER JOIN serviciomedico sm ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function sintomas_comunes()
	{
		try {
			$data = [
				'fechaInicio' => $this->getFechaInicio(),
				'fechaFinal' => $this->getFechaFinal()
			];
			if ($this->getFechaInicio() == "" && $this->getFechaFinal() == '') {
				$sql = "SELECT s.nombre AS sintoma, COUNT(sc.id_sintomas_control) AS total
					FROM sintomas_control sc
					INNER JOIN sintomas s ON sc.id_sintomas = s.id_sintomas
					GROUP BY s.nombre
					ORDER BY total DESC lIMIT 5;
						";
				$this->setSQL($sql);
				return $this->read();
			} else {
				$sql = "SELECT c.fecha_control, s.nombre AS sintoma, COUNT(sc.id_sintomas_control) AS total
							FROM sintomas_control sc
							INNER JOIN sintomas s ON sc.id_sintomas = s.id_sintomas INNER JOIN control c ON c.id_control = sc.id_control WHERE c.fecha_control BETWEEN :fechaInicio AND :fechaFinal
							GROUP BY s.nombre
							ORDER BY total DESC lIMIT 5;
								";

				$this->setSQL($sql);
				return $this->search($data);
			}

			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function todos_los_sintomas()
	{
		try {
			$sql = "SELECT COUNT(sc.id_sintomas_control) AS total FROM sintomas s INNER JOIN sintomas_control sc ON sc.id_sintomas = s.id_sintomas INNER JOIN control c ON c.id_control = sc.id_control";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function obtenerDiasConMasCitas()
	{
		try {
			if ($this->getIdPersonal() == 0) {
				$sql = "SELECT 
								c.fecha,
								COUNT(c.id_cita) AS total_citas,
								GROUP_CONCAT(DISTINCT CONCAT(p.nombre, ' ', p.apellido) SEPARATOR ', ') AS personal,
								c.fecha AS date
							FROM cita c
							INNER JOIN serviciomedico sm ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico
							INNER JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
							INNER JOIN personal p ON p.id_personal = psm.personal_id_personal
							GROUP BY c.fecha
							ORDER BY total_citas DESC
							LIMIT 10";
				$this->setSQL($sql);
				return $this->read();
			} else {
				$data = ['id_personal' => $this->getIdPersonal()];
				$sql = "SELECT 
								c.fecha,
								e.nombre AS especialidad,
								COUNT(c.id_cita) AS total_citas,
								GROUP_CONCAT(DISTINCT CONCAT(p.nombre, ' ', p.apellido) SEPARATOR ', ') AS personal,
								c.fecha AS date
							FROM cita c
							INNER JOIN serviciomedico sm ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico
							INNER JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
							INNER JOIN personal p ON p.id_personal = psm.personal_id_personal
							INNER JOIN especialidad e ON e.id_especialidad = p.id_especialidad
							WHERE p.id_personal = :id_personal
							GROUP BY c.fecha
							ORDER BY total_citas DESC";
				$this->setSQL($sql);
				return $this->search($data);
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	// 	//Metodo para validar si un usuario es doctor o no

	public function comprobarCargo()
	{
		try {
			$sql = "SELECT * FROM personal p INNER JOIN segurity.usuario u ON u.id_usuario = p.usuario WHERE p.id_personal =:id_personal AND p.id_especialidad IS NOT null";

			$this->setSQL($sql);
			$listData = $this->search(['id_personal' => $this->getIdPersonal()], true);

			return !empty($listData) ? 1 : 0;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function datos_personal($data)
	{
		$sql = "SELECT p.id_personal, p.nacionalidad, p.cedula, p.nombre, p.apellido,
					p.telefono, p.tipodecategoria, p.id_especialidad,
					e.nombre AS especialidad_nombre, u.id_usuario, u.usuario, u.correo, u.imagen
				FROM bd.personal p
				INNER JOIN segurity.usuario u ON u.id_usuario = p.usuario
				LEFT JOIN bd.especialidad e ON e.id_especialidad = p.id_especialidad
				WHERE p.usuario = :id_usuario";
		$this->setSQL($sql);
		return $this->search($data);
	}



	public function getIdPersonal()
	{
		return $this->idPersonal;
	}


	public function getFechaInicio()
	{
		return $this->fechaInicio;
	}

	public function getFechaFinal()
	{
		return $this->fechaFinal;
	}





	public function setIdPersonal($idPersonal)
	{

		if (!preg_match('/^[0-9]+$/', $idPersonal)) {
			throw new \InvalidArgumentException('El ID no es válido.');
		}

		$this->idPersonal = $idPersonal;
	}





	public function setFechaInicio($fechaInicio = '')
	{

		$dt = \DateTime::createFromFormat('Y-m-d', $fechaInicio);
		$fechaHoy = date("Y-m-d");

		if ($fechaInicio == '') {
			$this->fechaInicio = $fechaInicio;
			return;
		}

		if (!$dt || $dt->format('Y-m-d') !== $fechaInicio) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fechaInicio >= $fechaHoy) {
			throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
		}
		$this->fechaInicio = $fechaInicio;
	}

	public function setFechaFinal($fechaFinal = '')
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fechaFinal);
		$fechaHoy = date("Y-m-d");

		if ($fechaFinal == '') {
			$this->fechaFinal = $fechaFinal;
			return;
		}

		if (!$dt || $dt->format('Y-m-d') !== $fechaFinal) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fechaFinal > $fechaHoy) {
			throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
		}
		$this->fechaFinal = $fechaFinal;
	}
}
