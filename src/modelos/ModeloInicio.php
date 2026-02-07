<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloDoctores;


class ModeloInicio extends ModelBase
{
	private $idPersonal;

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

	public function especialidades_solicitadas($data = [])
	{
		try {
			if ($data == []) {
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

	public function sintomas_comunes($data = [])
	{
		try {
			if ($data == []) {
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


	public function obtenerDiasConMasCitas($data)
	{
		try {
			if ($data == '') {
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
				$data = ['id_personal' => $this->retrunObjectModel()['modeloDoctores']->getIdDoctor()];
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
			$listData = $this->search(['id_personal'=>$this->getIdPersonal()], true);

			return !empty($listData) ? 1 : 0;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// 	//Treae los datos del doctor como los personlaes y los profesionales
	public function datos_doctor($data)
	{
		try {
			$sql = "SELECT * FROM bd.personal p INNER JOIN segurity.usuario u ON u.id_usuario = p.usuario WHERE p.usuario =:id_usuario AND p.id_especialidad IS NOT null";

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function setIdPersonal($idPersonal)
	{

		if (!preg_match('/^[0-9]+$/', $idPersonal)) {
			throw new \InvalidArgumentException('El ID no es válido.');
		}
		if ((int)$idPersonal <= 0) {
			throw new \InvalidArgumentException('El ID debe ser mayor que cero.');
		}
		$this->idPersonal = $idPersonal;
	}
	public function getIdPersonal()
	{
		return $this->idPersonal;
	}
}
