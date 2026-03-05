<?php

namespace App\modelos;

use App\modelos\ModelBase;
use DateTime;

class ModeloCita extends ModelBase
{

	private $id_cita, $fecha, $hora, $estado, $id_doctor, $horaSalida, $id_servicioMedico, $id_paciente, $nacionalidad, $cedula;


	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}


	public function selectPaciente()
	{
		try {

			$data = [
				'nacionalidad' => $this->getNacionalidad(),
				'cedula' => $this->getCedula(),
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

	public function mostrarDoctores()
	{
		try {

			$data = ['id_servicio' => $this->getIdServicioMedico()];

			$sql = "SELECT p.id_personal, p.nombre AS nombre_doctor , p.apellido AS apellido_doctor FROM serviciomedico sm INNER JOIN personal_has_serviciomedico psm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN personal p ON p.id_personal = psm.personal_id_personal WHERE sm.estado = 'ACT' AND sm.id_categoria =:id_servicio";

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function mostrarHorarioDoctores()
	{
		try {
			$data = ['id_doctor' => $this->getIdDoctor()];

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
			$sql = 'SELECT c.doctor,p.id_paciente, c.serviciomedico_id_servicioMedico, cs.id_categoria ,cs.nombre as categoria ,c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado,c.fecha, c.hora, c.estado, pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, pe.id_especialidad,  p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion FROM bd.serviciomedico sm INNER JOIN  bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal INNER  JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad  INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND c.fecha >= CURRENT_DATE';
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function insertarCita()
	{
		try {
			$this->beginTransaction();

			$sql = " SELECT id_servicioMedico FROM serviciomedico WHERE id_categoria =:id AND estado  ='ACT' ";
			$this->setSQL($sql);
			$id_servicioMedico = $this->search(['id' => $this->getIdServicioMedico()], false);
			$id = $id_servicioMedico['id_servicioMedico'];

			$data = [
				'id_paciente' => $this->getIdPaciente(),
				'id_servicioMedico' => $id,
				'fecha' => $this->getFecha(),
				'hora' => $this->getHora(),
				'estado' => $this->getEstado(),
				'doctor' => $this->getIdDoctor(),
				'hora_salida' => $this->getHoraSalida()
			];

			$sql = "INSERT INTO cita(id_cita, fecha, hora, estado, serviciomedico_id_servicioMedico, paciente_id_paciente, hora_salida, doctor) VALUES (NULL, :fecha, :hora, :estado, :id_servicioMedico, :id_paciente,:hora_salida, :doctor)";


			$this->setSQL($sql);
			$this->create($data);
			$this->commit();
			return ["exito", $data];
		} catch (\Exception $e) {
			$this->rollBack();
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

			$sql = 'SELECT  c.doctor,cs.id_categoria,p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria ,c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado,c.fecha, c.hora, c.estado, pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, u.correo,  pe.id_especialidad,  p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion FROM bd.serviciomedico sm INNER JOIN  bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal INNER  JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad  INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND c.fecha = :fecha';

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
			$sql = "SELECT  c.doctor,cs.id_categoria,p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria ,c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado,c.fecha, c.hora, c.estado, pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, u.correo,  pe.id_especialidad,  p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion FROM bd.serviciomedico sm INNER JOIN  bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal INNER  JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad  INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE  c.estado ='Realizadas' AND c.doctor = psm.personal_id_personal ";
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

			$sql = " SELECT id_servicioMedico FROM serviciomedico WHERE id_categoria =:id AND estado  ='ACT' ";
			$this->setSQL($sql);
			$id_servicioMedico = $this->search(['id' => $this->getIdServicioMedico()], false);
			$id = $id_servicioMedico['id_servicioMedico'];

			$data = [
				'id_paciente' => $this->getIdPaciente(),
				'id_servicioMedico' => $id,
				'fecha' => $this->getFecha(),
				'hora' => $this->getHora(),
				'estado' => $this->getEstado(),
				'doctor' => $this->getIdDoctor(),
				'hora_salida' => $this->getHoraSalida(),
			];

			$sql = "UPDATE cita SET  fecha=:fecha, hora=:hora, estado=:estado, serviciomedico_id_servicioMedico=:id_servicioMedico, paciente_id_paciente=:id_paciente, hora_salida=:hora_salida, doctor=:doctor  WHERE id_cita=:id";

			$this->setSQL($sql);
			$this->update($data, $this->getIdCita());

			return ["exito", $data];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	/* metodo para validar que tiempos libres tiene el doctor */

	public function validarHorariosDisponlibles()
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
				'id_personal' => $this->getIdDoctor()
			];

			$data2 = [
				'dia' => $nombreDia,
				'id_personal' => $this->getIdDoctor()
			];

			//consulta para traer todas la horas queel doctor tiene ocupada
			$sql = 'SELECT c.hora as hora_entrada, c.hora_salida FROM  cita c INNER JOIN personal p ON p.id_personal = c.doctor  WHERE c.fecha = :fecha and p.id_personal =:id_personal  AND c.estado="Pendiente" ';
			$this->setSQL($sql);
			$horasOcupadas = $this->search($data1);

			//consulta para traer todas la horas queel doctor tiene en total

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
		$parts = explode(':', $time);
		$horas = (int)$parts[0];
		$minutos = (int)$parts[1];

		return ($horas * 60) + $minutos;
	}

	private function convertTo12Hour($minutes)
	{
		$hours = floor($minutes / 60) % 24;
		$mins = $minutes % 60;

		$modifier = $hours >= 12 ? 'PM' : 'AM';
		$formattedHours = ($hours % 12) ?: 12; // Si es 0, lo convierte en 12

		return sprintf('%d:%02d %s', $formattedHours, $mins, $modifier);
	}

	private function seccionarHoras($start, $end)
	{
		// 1. Convertimos los strings "10:00:00" a minutos totales (ej. 600)
		$startMinutes = $this->convertTo24Hour($start);
		$endMinutes = $this->convertTo24Hour($end);
		$intervals = [];

		// Validación: Si el inicio es mayor al fin, el array se queda vacío.
		if ($startMinutes >= $endMinutes) {
			return [];
		}

		// 2. El bucle ahora suma 60 minutos reales en cada vuelta
		for ($minutes = $startMinutes; $minutes < $endMinutes; $minutes += 60) {

			$inicioIntervalo = $this->convertTo12Hour($minutes);

			// Calculamos el final del bloque
			$siguienteBloque = $minutes + 60;

			// Si el siguiente bloque se pasa de la hora de fin, lo recortamos al límite
			if ($siguienteBloque > $endMinutes) {
				$siguienteBloque = $endMinutes;
			}

			$finIntervalo = $this->convertTo12Hour($siguienteBloque);

			$intervals[] = $inicioIntervalo . ' a ' . $finIntervalo;
		}

		return $intervals;
	}


	public function getIdCita()
	{
		return $this->id_cita;
	}

	public function getIdServicioMedico()
	{
		return $this->id_servicioMedico;
	}
	public function getIdPaciente()
	{
		return $this->id_paciente;
	}
	public function getIdDoctor()
	{
		return $this->id_doctor;
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

	public function getNacionalidad()
	{
		return $this->nacionalidad;
	}



	public function getCedula()
	{
		return $this->cedula;
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

	public function setIdServicioMedico($id_servicioMedico)
	{
		if (!preg_match("/^[0-9]+$/", $id_servicioMedico)) {
			throw new \InvalidArgumentException("El ID del servicio debe ser un número entero positivo.");
		}

		if ((int)$id_servicioMedico <= 0) {
			throw new \InvalidArgumentException("El ID del servicio debe ser mayor que cero.");
		}

		$this->id_servicioMedico = $id_servicioMedico;
	}

	public function setIdPaciente($id_paciente)
	{
		if (!preg_match("/^[0-9]+$/", $id_paciente)) {
			throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
		}

		if ((int)$id_paciente <= 0) {
			throw new \InvalidArgumentException("El ID del paciente debe ser mayor que cero.");
		}

		$this->id_paciente = $id_paciente;
	}


	public function setIdDoctor($id_doctor)
	{
		if (!preg_match("/^[0-9]+$/", $id_doctor)) {
			throw new \InvalidArgumentException("El ID del doctor debe ser un número entero positivo.");
		}

		if ((int)$id_doctor <= 0) {
			throw new \InvalidArgumentException("El ID del doctor debe ser mayor que cero.");
		}

		$this->id_doctor = $id_doctor;
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


	public function setNacionalidad($nacionalidad)
	{
		if (!$nacionalidad == 'V' || $nacionalidad == 'E') {
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
}
