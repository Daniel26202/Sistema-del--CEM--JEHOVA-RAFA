<?php

namespace App\models;

use App\models\ModelBase;
use App\models\TraitCreate;
use App\models\TraitUpdate;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use DateTime;
use PDO;

class ModeloCita extends ModelBase
{
	private $id_cita, $fecha, $hora, $estado, $horaSalida;
	private $validator;

	use TraitCreate, TraitUpdate;

	public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
	{
		parent::__construct($conn);
		$this->validator = $vali;
	}


	private function existeCita(string $doctor,string $fecha,string $hora)
	{
		//consulta puntual por ello uso pdo directamente
		$sql = "SELECT id_cita FROM cita 
	                   WHERE doctor = :doctor 
	                     AND fecha = :fecha 
	                     AND hora = :hora 
	                     AND (
	                          estado IN ('Pendiente', 'Realizadas') 
	                          OR (estado = 'Reservado' AND creado_en >= NOW() - INTERVAL 5 MINUTE)
	                         )";
		$query = $this->getPDO()->prepare($sql);
		$query->execute([
			':doctor' => $doctor,
			':fecha' => $fecha,
			':hora' => $hora
		]);
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return !empty($result) ? 1 : 0;
	}

	// ── READ ────────────────────────────────────────────────

	public function mostrarCita($start = 0, $limit = 10, $search = '', $ordenColumn = 'id_cita', $ordenDir = 'DESC')
	{
		$tables = [
			'bd.serviciomedico',
			'bd.cita',
			'bd.paciente',
			'bd.personal_has_serviciomedico',
			'bd.personal',
			'bd.especialidad',
			'segurity.usuario',
			'bd.categoria_servicio'
		];
		$colums = [
			'c.doctor',
			'p.id_paciente',
			'c.serviciomedico_id_servicioMedico',
			'cs.id_categoria',
			'cs.nombre AS categoria',
			'c.id_cita',
			'e.nombre AS especialidad',
			'sm.precio',
			'sm.estado',
			'c.fecha',
			'c.hora',
			'c.estado',
			'pe.nacionalidad',
			'pe.cedula',
			'pe.nombre AS doctor_nombre',
			'pe.apellido AS apellido_d',
			'pe.telefono',
			'pe.id_especialidad',
			'p.nacionalidad',
			'p.cedula  AS paciente_cedula',
			'p.nombre AS paciente_nombre',
			'p.apellido AS apellido_p',
			'p.telefono AS telefono_p',
			'p.fn',
			'p.direccion'
		];
		$alias = [
			'sm',
			'c',
			'p',
			'psm',
			'pe',
			'e',
			'u',
			'cs'
		];
		$unions = [
			'c.serviciomedico_id_servicioMedico = sm.id_servicioMedico',
			'p.id_paciente = c.paciente_id_paciente',
			'psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico',
			'pe.id_personal = psm.personal_id_personal',
			'e.id_especialidad = pe.id_especialidad',
			'pe.usuario = u.id_usuario',
			'cs.id_categoria = sm.id_categoria'
		];
		$coditions = [
			'condiciones' => ['c.estado' => 'Pendiente', 'p.estado' => 'ACT', 'c.fecha' => 'CURRENT_DATE'],
			'conectores' => ['AND', 'AND'],
			'operadores' => ['=', '=', '>=']
		];
		$this->set_tables($tables);
		$this->set_colums($colums);
		$this->set_alias($alias);
		$this->set_union($unions);
		$this->set_condicion_aditional($coditions);

		$this->set_search($search);
		$this->set_start($start);
		$this->set_limit($limit);
		$this->set_orden_dir($ordenDir);
		$this->set_orden_column($ordenColumn);

		return $this->pagination();
	}

	public function mostrarCitaHoy()
	{
		$tables = [
			'bd.serviciomedico',
			'bd.cita',
			'bd.paciente',
			'bd.personal_has_serviciomedico',
			'bd.personal',
			'bd.especialidad',
			'segurity.usuario',
			'bd.categoria_servicio'
		];
		$colums = [
			'c.doctor',
			'p.id_paciente',
			'c.serviciomedico_id_servicioMedico',
			'cs.id_categoria',
			'cs.nombre AS categoria',
			'c.id_cita',
			'e.nombre AS especialidad',
			'sm.precio',
			'sm.estado',
			'c.fecha',
			'c.hora',
			'c.estado',
			'pe.nacionalidad',
			'pe.cedula',
			'pe.nombre AS doctor_nombre',
			'pe.apellido AS apellido_d',
			'pe.telefono',
			'pe.id_especialidad',
			'p.nacionalidad',
			'p.cedula  AS paciente_cedula',
			'p.nombre AS paciente_nombre',
			'p.apellido AS apellido_p',
			'p.telefono AS telefono_p',
			'p.fn',
			'p.direccion'
		];
		$alias = [
			'sm',
			'c',
			'p',
			'psm',
			'pe',
			'e',
			'u',
			'cs'
		];
		$unions = [
			'c.serviciomedico_id_servicioMedico = sm.id_servicioMedico',
			'p.id_paciente = c.paciente_id_paciente',
			'psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico',
			'pe.id_personal = psm.personal_id_personal',
			'e.id_especialidad = pe.id_especialidad',
			'pe.usuario = u.id_usuario',
			'cs.id_categoria = sm.id_categoria'
		];
		$coditions = [
			'condiciones' => ['c.estado' => 'Pendiente', 'p.estado' => 'ACT', 'c.fecha' => 'CURRENT_DATE'],
			'conectores' => ['AND', 'AND'],
			'operadores' => ['=', '=', '>=']
		];
		$this->set_tables($tables);
		$this->set_colums($colums);
		$this->set_alias($alias);
		$this->set_union($unions);
		$this->set_condicion_aditional($coditions);

		return $this->read();
	}
	//checkaer despues es importante

	public function validarHorariosDisponlibles()
	{
		$diasEsp = [
			1 => 'lunes',
			2 => 'martes',
			3 => 'miercoles',
			4 => 'jueves',
			5 => 'viernes',
			6 => 'sabado',
			7 => 'domingo'
		];

		$date       = new DateTime($this->getFecha());
		$nombreDia  = $diasEsp[$date->format('N')];

		$coditions1 = [
			'condiciones' => ['fecha' => $this->getFecha(), 'id_personal' => $this->getIdDoctor()],
			'conectores' => ['AND'],
			'operadores' => ['=', '=']
		];
		$coditions2 = [
			'condiciones' => ['p.id_personal' => $this->getIdDoctor(), 'h.diaslaborables' => $nombreDia],
			'conectores' => ['AND'],
			'operadores' => ['=', '=']
		];
		$this->set_tables(["cita", "personal"]);
		$this->set_colums(["c.hora AS hora_entrada", "c.hora_salida"]);
		$this->set_alias(['c', 'p']);
		$this->set_union(['p.id_personal = c.doctor']);
		$this->set_condicion_aditional($coditions1);

		$horasOcupadas = $this->read();

		$this->set_tables(["personal", "horarioydoctor", "horario"]);
		$this->set_colums(["hd.horaDeEntrada", "hd.horaDeSalida"]);
		$this->set_alias(['p', 'hd', 'h']);
		$this->set_union(['hd.id_personal = p.id_personal', 'h.id_horario = hd.id_horario']);
		$this->set_condicion_aditional($coditions2);

		$horasCompletas = $this->read();

		$listHoraOcupada = [];
		foreach ($horasOcupadas as $hora) {
			array_push($listHoraOcupada, $this->seccionarHoras($hora['hora_entrada'], $hora['hora_salida']));
		}

		$intervalo = [$this->seccionarHoras($horasCompletas['horaDeEntrada'], $horasCompletas['horaDeSalida'])];

		return [$intervalo, $listHoraOcupada];
	}

	public function reservarCita()
	{
		try {
			$this->beginTransaction();
			$coditions = [
				'condiciones' => ['id_categoria' => $this->getIdCategoria(), 'estado' => 'ACT'],
				'conectores' => ['AND'],
				'operadores' => ['=', '=']
			];
			$this->set_tables(["serviciomedico"]);
			$this->set_colums(['id_servicioMedico']);
			$this->set_condicion_aditional($coditions);
			$listData = $this->read(false);
			$id_servicioMedico = $listData['id_servicioMedico'];

			if (!$id_servicioMedico) {
				throw new \Exception("El servicio seleccionado no se encuentra activo.");
			}

			// 1. si hubo cambio de opinion libero el cupo viejo poniendolo en Expirado
			if ($this->getIdCita() !== null && $this->getIdCita()  > 0) {
				$this->actualizar(['estado' => 'Expirado'], ['id_cita' => $this->getIdCita(), 'estado' => 'Reservado'], $this->validator);
			}

			// validacion optimista concurrente
			$coditions = [
				'condiciones' => ['id_categoria' => $this->getIdCategoria(), 'estado' => 'ACT'],
				'conectores' => ['AND'],
				'operadores' => ['=', '=']
			];
			$this->set_tables(["serviciomedico"]);
			$this->set_colums(['id_servicioMedico']);
			$this->set_condicion_aditional($coditions);
			$listData = $this->read(false);


			$cita_existente = $this->existeCita($this->getIdDoctor(),$this->getFecha(),$this->getHora());
			//consulta puntual por ello uso pdo directamente
			$sqlValidar = "SELECT id_cita FROM cita 
	                   WHERE doctor = :doctor 
	                     AND fecha = :fecha 
	                     AND hora = :hora 
	                     AND (
	                          estado IN ('Pendiente', 'Realizadas') 
	                          OR (estado = 'Reservado' AND creado_en >= NOW() - INTERVAL 5 MINUTE)
	                         )";

			if (!$cita_existente) {
				throw new \Exception("Este horario ya fue seleccionado por otro usuario en tiempo real.");
			}

			$this->set_tables(['cita']);

			//registro de la nueva resevar
			$dataInsert = [
				'fecha'             => $this->getFecha(),
				'hora'              => $this->getHora(),
				'estado'            => 'Reservado',
				'id_servicio'       => $id,
				'id_paciente'       => $this->getIdPaciente(),
				'hora_salida'       => $this->getHoraSalida(),
				'doctor'            => $this->getIdDoctor()
			];

			$data = $this->guardar($dataInsert,$this->validator);
			$this->commit();
			return [$data];
		} catch (\Exception $e) {
			$this->rollBack();
			return $e->getMessage();
		}
	}


	public function insertarCita()
	{
		try {
			$this->beginTransaction();
			$coditions = [
				'condiciones' => ['id_categoria' => $this->getIdCategoria(), 'estado' => 'ACT'],
				'conectores' => ['AND'],
				'operadores' => ['=', '=']
			];
			$this->set_tables(["serviciomedico"]);
			$this->set_colums(['id_servicioMedico']);
			$this->set_condicion_aditional($coditions);
			$listData = $this->read(false);
			$id_servicioMedico = $listData['id_servicioMedico'];

			if (!$id_servicioMedico) {
				throw new \Exception("El servicio seleccionado no se encuentra activo.");
			}

			$coditions2 = [
				'condiciones' => ['id_categoria' => $this->getIdCategoria(), 'estado' => 'ACT'],
				'conectores' => ['AND'],
				'operadores' => ['=', '=']
			];
			$this->set_tables(['cita']);
			$this->set_condicion_aditional($coditions2);

			$columns_edit =[
				'estado'=>$this->getEstado(),
				'serviciomedico_id_servicioMedico' =>$id_servicioMedico,
				'paciente_id_paciente'=>$this->getIdPaciente(),
				'hora_salida'=>$this->getHoraSalida()
			];
			$data_condicion = [
				'doctor'=>$this->getIdDoctor(),
				'fecha'=>$this->getFecha(),
				'hora'=>$this->getHora(),
				'estado'=> 'Reservado'
			];
			$this->actualizar($columns_edit,$data_condicion,$this->validator);

			$query = $this->getPDO()->prepare("SELECT ROW_COUNT()");
			$query->execute();
			$filas = $query->fetch(PDO::FETCH_ASSOC);
			$filasAfectadas = $filas->fetchColumn();

			if ($filasAfectadas == 0) {
				throw new \Exception("Su tiempo límite de reserva (5 minutos) ha expirado en el servidor. Seleccione el horario nuevamente.");
			}
			$this->commit();
			return [1];
		} catch (\Exception $e) {
			$this->rollBack();
			return $e->getMessage();
		}
	}


	// ── privados ─────────────────────────────────────────────────────

	private function convertTo24Hour($time)
	{
		$parts  = explode(':', $time);
		return ((int)$parts[0] * 60) + (int)$parts[1];
	}

	private function convertTo12Hour($minutes)
	{
		$hours    = floor($minutes / 60) % 24;
		$mins     = $minutes % 60;
		$modifier = $hours >= 12 ? 'PM' : 'AM';
		$formatted = ($hours % 12) ?: 12;
		return sprintf('%d:%02d %s', $formatted, $mins, $modifier);
	}

	private function seccionarHoras($start, $end)
	{
		$startMinutes = $this->convertTo24Hour($start);
		$endMinutes   = $this->convertTo24Hour($end);
		$intervals    = [];

		if ($startMinutes >= $endMinutes) return [];

		for ($m = $startMinutes; $m < $endMinutes; $m += 60) {
			$siguiente = min($m + 60, $endMinutes);
			$intervals[] = $this->convertTo12Hour($m) . ' a ' . $this->convertTo12Hour($siguiente);
		}
		return $intervals;
	}

	// ── Getters ───────────────────────────────────────────────────────────────

	public function getIdCita()
	{
		return $this->id_cita;
	}
	public function getFecha()
	{
		return $this->fecha;
	}
	public function getHora()
	{
		return $this->hora;
	}
	public function getHoraSalida()
	{
		return $this->horaSalida;
	}
	public function getEstado()
	{
		return $this->estado;
	}

	// ── Setters ───────────────────────────────────────────────────────────────

	public function setIdCita($id_cita, $aceptedNull = false)
	{
		if ($aceptedNull) {
			$this->id_cita = $id_cita;
			return;
		}
		if (!preg_match("/^[0-9]+$/", $id_cita) || (int)$id_cita <= 0) {
			throw new \InvalidArgumentException("El ID de la cita debe ser un número entero positivo.");
		}
		$this->id_cita = $id_cita;
	}



	public function setFecha($fecha)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fecha);
		if (!$dt || $dt->format('Y-m-d') !== $fecha) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fecha < date("Y-m-d")) {
			throw new \InvalidArgumentException("La fecha no puede ser del pasado.");
		}
		$this->fecha = $fecha;
	}

	public function setHora($hora)
	{
		$this->hora = $hora;
	}

	public function setHoraSalida($horaSalida)
	{
		$this->horaSalida = $horaSalida;
	}

	public function setEstado($estado)
	{
		//  ..................
		$validos = ['Pendiente', 'Realizadas', 'DES'];
		if (!in_array($estado, $validos)) {
			throw new \InvalidArgumentException("El estado es incorrecto.");
		}
		$this->estado = $estado;
	}
}
