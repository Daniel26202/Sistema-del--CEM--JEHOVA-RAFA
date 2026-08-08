<?php

namespace App\models;

use App\models\interfaces\InterfaceConnection;
use App\models\ModelBase;
use PDO;


class ModeloInicio extends ModelBase
{
	private $idPersonal, $fechaInicio, $fechaFinal;
	private $validator;

	public function __construct(InterfaceConnection $conn)
	{
		parent::__construct($conn);
	}


	public function pacientes_hospitalizados()
	{
		$this->set_tables(["hospitalizacion"]);
		$this->set_condicion_aditional([
			'condiciones' => ['estado' => 'pendiente'],
			'conectores' => [],
			'operadores' => ['=']
		]);
		return $this->read(false, 'COUNT', 'id_hospitalizacion');
	}


	public function servicios()
	{
		$alias = ['c', 's'];
		$union = ['s.id_categoria = c.id_categoria'];
		$coditions = [
			'condiciones' => ['s.estado' => 'ACT'],
			'conectores' => [],
			'operadores' => ['=']
		];
		$this->set_tables(['categoria_servicio', 'serviciomedico']);
		$this->set_colums(['c.nombre AS categoria', 's.precio']);
		$this->set_alias($alias);
		$this->set_union($union);
		$this->set_condicion_aditional($coditions);
		return $this->read();
	}

	public function especialidades_solicitadas()
	{
		try {
			$data = [
				'fechaInicio' => $this->getFechaInicio(),
				'fechaFinal' => $this->getFechaFinal()
			];

			if ($this->getFechaInicio() == '' && $this->getFechaFinal() == "") {
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
				$query = $this->getPDO()->prepare($sql);
				return($query->fetchAll(PDO::FETCH_ASSOC));
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
				$query = $this->getPDO()->prepare($sql);
				$query->execute([
					'fechaInicio' => $this->getFechaInicio(),
					'fechaFinal' => $this->getFechaFinal()
				]);

				return ($query->fetchAll(PDO::FETCH_ASSOC));
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function todas_las_especialidades()
	{
		$alias = ['c', 's'];
		$union = ['sm.id_servicioMedico = c.serviciomedico_id_servicioMedico'];
		$this->set_tables(["cita", 'serviciomedico']);
		$this->set_alias($alias);
		$this->set_union($union);
		return $this->read(false, 'COUNT', 'c.serviciomedico_id_servicioMedico');
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
				$query = $this->getPDO()->prepare($sql);
				return ($query->fetchAll(PDO::FETCH_ASSOC));
			} else {
				$sql = "SELECT c.fecha_control, s.nombre AS sintoma, COUNT(sc.id_sintomas_control) AS total
							FROM sintomas_control sc
							INNER JOIN sintomas s ON sc.id_sintomas = s.id_sintomas INNER JOIN control c ON c.id_control = sc.id_control WHERE c.fecha_control BETWEEN :fechaInicio AND :fechaFinal
							GROUP BY s.nombre
							ORDER BY total DESC lIMIT 5;
								";

				$query = $this->getPDO()->prepare($sql);
				$query->execute([
					'fechaInicio' => $this->getFechaInicio(),
					'fechaFinal' => $this->getFechaFinal()
				]);

				return ($query->fetchAll(PDO::FETCH_ASSOC));
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function todos_los_sintomas()
	{
		$alias = ['s', 'sc'];
		$union = ['s.id_sintomas = sc.id_sintomas'];
		$this->set_tables(["sintomas", 'sintomas_control']);
		$this->set_alias($alias);
		$this->set_union($union);
		return $this->read(false, 'COUNT', 'sc.id_sintomas_control');
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
				$query = $this->getPDO()->prepare($sql);
				return ($query->fetchAll(PDO::FETCH_ASSOC));
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
				$query = $this->getPDO()->prepare($sql);
				return ($query->fetchAll(PDO::FETCH_ASSOC));
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	// 	//Metodo para validar si un usuario es doctor o no

	public function comprobarCargo()
	{
		$alias = ['p', 'u'];
		$union = ['u.id_usuario = p.usuario'];
		$coditions = [
			'condiciones' => ['p.id_personal' => $this->getIdPersonal(), 'p.id_especialidad' => 'IS NOT NULL'],
			'conectores' => ['AND'],
			'operadores' => ['=', '!=']
		];
		$this->set_tables(['personal', 'segurity.usuario']);
		$this->set_colums(['id_personal']);
		$this->set_alias($alias);
		$this->set_union($union);
		$this->set_condicion_aditional($coditions);
		$listData =  $this->read(false);

		return !empty($listData) ? 1 : 0;
	}

	// 	//Treae los datos del doctor como los personlaes y los profesionales
	public function datos_doctor($id_usuario)
	{

		$alias = ['p', 'u'];
		$union = ['u.id_usuario = p.usuario'];
		$coditions = [
			'condiciones' => ['p.id_personal' => $id_usuario, 'p.id_especialidad' => 'IS NOT NULL'],
			'conectores' => ['AND'],
			'operadores' => ['=', '!=']
		];
		$this->set_tables(['bd.personal', 'segurity.usuario']);
		$this->set_colums(['id_personal']);
		$this->set_alias($alias);
		$this->set_union($union);
		$this->set_condicion_aditional($coditions);
		return $this->read(false);
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
		if ($fechaFinal >= $fechaHoy) {
			throw new \InvalidArgumentException("La fecha no puede ser del futuro.");
		}
		$this->fechaFinal = $fechaFinal;
	}
}
