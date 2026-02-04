<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloServicios;
use DateTime;

class ModeloCita extends ModelBase
{

	private $id_cita, $fecha, $hora, $estado, $doctor, $horaSalida;


	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}


	public function selectPaciente($objPaciente)
	{
		try {

			$data = [
				'nacionalidad' => $objPaciente->getNacionalidad(),
				'cedula' => $objPaciente->getCedula(),
				'estado' => 'ACT'
			];

			$sql = "SELECT * FROM paciente WHERE nacionalidad = :nacionalidad AND cedula =:cedula AND estado =:estado";
			$this->setSQL($sql);
			return $this->search($data, false);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarServicioDoctor()
	{
		try {
			$sql = "SELECT * FROM categoria_servicio WHERE estado = 'ACT'";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarDoctores($obj)
	{
		try {

			$data = ['id_servicio' => $obj->getIdServicioMedico()];

			$sql = "SELECT p.id_personal, p.nombre AS nombre_doctor , p.apellido AS apellido_doctor FROM serviciomedico sm INNER JOIN personal_has_serviciomedico psm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN personal p ON p.id_personal = psm.personal_id_personal WHERE sm.estado = 'ACT' AND sm.id_categoria =:id_servicio";

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function mostrarHorarioDoctores($obj)
	{
		try {
			$data = ['id_doctor' => $obj->getIdDoctor()];

			$sql = " SELECT sm.*, hyd.*, h.diaslaborables FROM horarioydoctor hyd INNER JOIN personal d ON d.id_personal = hyd.id_personal INNER JOIN horario h ON h.id_horario = hyd.id_horario INNER JOIN personal_has_serviciomedico psm ON d.id_personal = psm.personal_id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico WHERE d.id_personal = :id_doctor GROUP by hyd.id_horarioydoctor ";
			$this->setSQL($sql);

			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	//esto es lo de la base de datos mas actualizadas lo de arriba lo Acomodo otro dia

	public function mostrarCita()
	{
		try {
			$sql = 'SELECT p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria ,c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado,c.fecha, c.hora, c.estado, pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, pe.id_especialidad,  p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion FROM bd.serviciomedico sm INNER JOIN  bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal INNER  JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad  INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND c.fecha >= CURRENT_DATE';
			$this->setSQL($sql);
			return [];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function insertarCita($paciente, $servicio, $doctor)
	{
		try {

			$sql = " SELECT id_servicioMedico FROM serviciomedico WHERE id_categoria =:id AND estado  ='ACT' ";
			$this->setSQL($sql);
			$id_servicioMedico = $this->search(['id' => $servicio->getIdServicioMedico()], false);
			$id = $id_servicioMedico['id_servicioMedico'];

			$data = [
				'id_paciente' => $paciente->getIdPaciente(),
				'id_servicioMedico' => $id,
				'fecha' => $this->getFecha(),
				'hora' => $this->getHora(),
				'estado' => $this->getEstado(),
				'doctor' => $doctor->getIdDoctor(),
				'hora_salida' => $this->getHoraSalida()
			];



			$sql = "INSERT INTO cita(id_cita, fecha, hora, estado, serviciomedico_id_servicioMedico, paciente_id_paciente, hora_salida, doctor) VALUES (NULL, :fecha, :hora, :estado, :id_servicioMedico, :id_paciente,:hora_salida, :doctor)";


			$this->setSQL($sql);
			$this->create($data);

			return ["exito", $data];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function eliminarCita()
	{
		try {
			$data = [
				'id_cita' => $this->getIdCita()
			];

			$sql = "SELECT * from cita where id_cita=:id_cita";
			$this->setSQL($sql);

			$validar  = $this->search($data, false);

			if ($validar == []) {
				throw new \Exception("El id de la cita no existe");
			}

			$sql = "UPDATE cita SET estado = 'DES' WHERE id_cita =:id ";
			$this->setSQL($sql);

			$this->update_logic($data['id_cita']);
			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	//citas de hoy
	public function mostrarCitaHoy()
	{
		try {
			$data = [
				'fecha' => date("Y-m-d")
			];

			$sql = 'SELECT p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria ,c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado,c.fecha, c.hora, c.estado, pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, u.correo,  pe.id_especialidad,  p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion FROM bd.serviciomedico sm INNER JOIN  bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal INNER  JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad  INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND c.fecha = :fecha';

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//citas de realizadas
	public function mostrarCitaR()
	{
		try {
			$sql = "SELECT p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria ,c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado,c.fecha, c.hora, c.estado, pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, u.correo,  pe.id_especialidad,  p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion FROM bd.serviciomedico sm INNER JOIN  bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal INNER  JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad  INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE  c.estado ='Realizadas' AND c.doctor = psm.personal_id_personal ";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	//editar

	public function update_cita()
	{
		try {

			$data = [
				'id_cita' => $this->getIdCita(),
				'id_servicioMedico' => $this->getIdServicioMedico(),
				'fecha' => $this->getFecha(),
				'hora' => $this->getHora()
			];

			$sql = "SELECT * from cita where id_cita=:id_cita";

			$this->setSQL($sql);
			$listData   = $this->search($data);

			if ($listData == []) {
				throw new \Exception("El id de la cita no existe");
			}

			$sql = "UPDATE cita SET serviciomedico_id_servicioMedico=:id_servicioMedico,fecha=:fecha,hora=:hora WHERE id_cita =:id_cita";

			$this->setSQL($sql);
			$this->update($data, $this->getIdCita());

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function validarCita()
	{
		try {

			$data = [
				'id_paciente' => $this->returnObjectModel()['modeloPaciente']->getIdPaciente(),
				'fecha' => $this->getFecha(),
				'hora' => $this->getHora()
			];

			$sql = "SELECT * FROM cita WHERE paciente_id_paciente = :id_paciente AND fecha=:fecha AND hora = :hora";
			$this->setSQL($sql);
			$listData = $this->search($data, false);

			return !empty($listData) ? 1 : 0;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	/* metodo para validar que tiempos libres tiene el doctor */

	public function validarHorariosDisponlibles($obj)
	{
		try {

			$diasEsp = [
				1 => 'lunes',
				2 => 'martes',
				3 => 'miercoles',
				4 => 'jueves',
				5 => 'viernes',
				6 => 'sabado',
				7 => 'domingo'
			];

			$date = new DateTime($this->getFecha());
			$posicion = $date->format('N');
			$nombreDia  = $diasEsp[$posicion];
			$data1 = [
				'fecha' => $this->getFecha(),
				'id_personal' => $obj->getIdDoctor()
			];

			$data2 = [
				'dia' => $nombreDia,
				'id_personal' => $obj->getIdDoctor()
			];

			$sql = 'SELECT c.hora as hora_entrada, c.hora_salida FROM  cita c INNER JOIN personal p ON p.id_personal = c.doctor  WHERE c.fecha = :fecha and p.id_personal =:id_personal  AND c.estado="Pendiente" ';
			$this->setSQL($sql);
			$horasOcupadas = $this->search($data1);

			$sql = 'SELECT hd.horaDeEntrada, hd.horaDeSalida FROM personal p INNER JOIN horarioydoctor hd ON hd.id_personal = p.id_personal  INNER JOIN horario  h ON h.id_horario = hd.id_horario WHERE p.id_personal =:id_personal AND h.diaslaborables = :dia';
			$this->setSQL($sql);
			$horasCompletas =  $this->search($data2, false);


			//agregar todas las citas que tiene el doctor en un array
			$listHoraOcupada = [];
			$intervalo = [];
			foreach ($horasOcupadas as $hora) {
				array_push($listHoraOcupada, $this->seccionarHoras($hora['hora_entrada'], $hora['hora_salida']));
			}



			$inicio = $horasCompletas['horaDeEntrada'];
			$final = $horasCompletas['horaDeSalida'];


			array_push($intervalo, $this->seccionarHoras($inicio, $final));

			return [$intervalo, $listHoraOcupada];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



	private function convertTo24Hour($time)
	{
		$time = strtolower($time); // Convertir a minúsculas
		$parts = explode(' ', $time);
		$hourPart = $parts[0];
		$modifier = isset($parts[1]) ? $parts[1] : '';
		list($hours, $minutes) = explode(':', $hourPart);

		$totalMinutes = ($modifier === 'pm' && (int)$hours < 12 ? (int)$hours + 12 : (int)$hours % 12) * 60 + ((int)$minutes ?? 0);
		return $totalMinutes; // Devuelve el total en minutos
	}

	private function convertTo12Hour($minutes)
	{
		$hours = floor($minutes / 60) % 24;
		$mins = $minutes % 60;
		$modifier = $hours >= 12 ? 'PM' : 'AM'; // Usar mayúsculas
		$formattedHours = ($hours % 12) ?: 12; // Convertir 0 a 12
		return sprintf('%d:%02d %s', $formattedHours, $mins, $modifier);
	}

	private function seccionarHoras($start, $end)
	{
		$startMinutes = $this->convertTo24Hour($start);
		$endMinutes = $this->convertTo24Hour($end);
		$intervals = [];

		for ($minutes = $startMinutes; $minutes < $endMinutes; $minutes += 60) {
			$intervals[] = $this->convertTo12Hour($minutes) . ' a ' . $this->convertTo12Hour($minutes + 60);
		}

		return $intervals;
	}


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



	public function setIdCita($id_cita)
	{
		if (!preg_match("/^[0-9]+$/", $id_cita)) {
			throw new \InvalidArgumentException("El ID de la cita debe ser un número entero positivo.");
		}

		if ((int)$id_cita <= 0) {
			throw new \InvalidArgumentException("El ID de la cita debe ser mayor que cero.");
		}

		$this->id_cita = $id_cita;
	}


	public function setFecha($fecha)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fecha);
		$fechaHoy = date("Y-m-d");

		if (!$dt || $dt->format('Y-m-d') !== $fecha) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fecha < $fechaHoy) {
			throw new \InvalidArgumentException("La fecha no puede ser del pasado.");
		}

		$this->fecha = $fecha;
	}
	public function setHora($hora)
	{
		// if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $hora)) {
		// 	throw new \InvalidArgumentException("Hora inválida. Formato esperado: HH:MM (24h).");
		// }
		$this->hora = $hora;
	}
	public function setHoraSalida($horaSalida)
	{
		// if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $horaSalida)) {
		// 	throw new \InvalidArgumentException("Hora inválida. Formato esperado: HH:MM (24h).");
		// }
		$this->horaSalida = $horaSalida;
	}
	public function setEstado($estado)
	{
		if ($estado === "Pendiente" || $estado === "Realizadas" || $estado === "DES") {
		} else {
			throw new \InvalidArgumentException("Es estado es incorrecto.");
		}
		$this->estado = $estado;
	}
	public function setDoctor($doctor)
	{

		if (!preg_match("/^[0-9]+$/", $doctor)) {
			throw new \InvalidArgumentException("El ID del doctor debe ser un número entero positivo.");
		}

		if ((int)$doctor <= 0) {
			throw new \InvalidArgumentException("El ID del doctor debe ser mayor que cero.");
		}

		$this->doctor = $doctor;
	}
}
