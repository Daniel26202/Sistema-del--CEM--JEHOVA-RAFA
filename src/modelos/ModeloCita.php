<?php

namespace App\modelos;

use App\modelos\Db;
use DateTime;

class ModeloCita extends Db
{

	private $conexion;

	public function __construct()
	{
		$this->conexion = $this->connectionSistema();
	}

	public function selectPaciente($nacionalidad, $cedula)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM paciente WHERE nacionalidad = :nacionalidad AND cedula =:cedula AND estado = 'ACT'");
			$consulta->bindParam(":nacionalidad", $nacionalidad);
			$consulta->bindParam(":cedula", $cedula);
			$consulta->execute();
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function mostrarServicioDoctor()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM categoria_servicio WHERE estado = 'ACT'");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function mostrarDoctores($id_servicio)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT p.id_personal, p.nombre AS nombre_doctor , p.apellido AS apellido_doctor FROM serviciomedico sm INNER JOIN personal_has_serviciomedico psm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico INNER JOIN personal p ON p.id_personal = psm.personal_id_personal WHERE sm.estado = 'ACT' AND sm.id_categoria =:id_servicio");
			$consulta->bindParam(":id_servicio", $id_servicio);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function mostrarHorarioDoctores($id_doctor)
	{
		try {
			$consulta = $this->conexion->prepare(" SELECT sm.*, hyd.*, h.diaslaborables FROM horarioydoctor hyd INNER JOIN personal d ON d.id_personal = hyd.id_personal INNER JOIN horario h ON h.id_horario = hyd.id_horario INNER JOIN personal_has_serviciomedico psm ON d.id_personal = psm.personal_id_personal INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico WHERE d.id_personal = :id_doctor GROUP by hyd.id_horarioydoctor ");
			$consulta->bindParam(":id_doctor", $id_doctor);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}


	//esto es lo de la base de datos mas actualizadas lo de arriba lo Acomodo otro dia

	public function mostrarCita()
	{
		try {
			$consulta = $this->conexion->prepare('SELECT p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria ,c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado,c.fecha, c.hora, c.estado, pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, pe.id_especialidad,  p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion FROM bd.serviciomedico sm INNER JOIN  bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal INNER  JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad  INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND c.fecha >= CURRENT_DATE');
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	public function insertarCita($id_paciente, $id_servicioMedico, $fecha, $hora, $estado, $doctor)
	{
		try {

			$this->conexion->beginTransaction();

			$fecha_hora = new DateTime($hora);
			$fecha_hora->modify('+1 hour');
			$hora_salida = $fecha_hora->format("H:m:s");
			
			// Si no existe, inserta la cita
			$consulta = $this->conexion->prepare("INSERT INTO cita(id_cita, fecha, hora, estado, serviciomedico_id_servicioMedico, paciente_id_paciente, hora_salida, doctor) VALUES (NULL, :fecha, :hora, :estado, :id_servicioMedico, :id_paciente,:hora_salida, :doctor)");
			$consulta->bindParam(":id_paciente", $id_paciente);
			$consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
			$consulta->bindParam(":fecha", $fecha);
			$consulta->bindParam(":hora", $hora);
			$consulta->bindParam(":estado", $estado);
			$consulta->bindParam(":hora_salida", $hora_salida);
			$consulta->bindParam(":doctor", $doctor);
			$consulta->execute();

			$this->conexion->commit();
			return "exito";
		} catch (\Exception $e) {
			$this->conexion->rollBack();
			return false;
		}
	}


	public function eliminarCita($id_cita)
	{
		try {
			$consulta = $this->conexion->prepare("UPDATE cita SET estado = 'DES' WHERE id_cita =:id_cita ");
			$consulta->bindParam(":id_cita", $id_cita);
			$consulta->execute();
			return "exito";
		} catch (\Exception $e) {
			return 0;
		}
	}


	//citas de hoy
	public function mostrarCitaHoy($fecha)
	{
		try {
			$consulta = $this->conexion->prepare('SELECT p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria ,c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado,c.fecha, c.hora, c.estado, pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, u.correo,  pe.id_especialidad,  p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion FROM bd.serviciomedico sm INNER JOIN  bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal INNER  JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad  INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND c.fecha = :fecha');
			$consulta->bindParam(":fecha", $fecha);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	//citas de realizadas
	public function mostrarCitaR()
	{
		try {
			$consulta = $this->conexion->prepare("SELECT p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria ,c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado,c.fecha, c.hora, c.estado, pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, u.correo,  pe.id_especialidad,  p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion FROM bd.serviciomedico sm INNER JOIN  bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal INNER  JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad  INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE  c.estado ='Realizadas' AND c.doctor = psm.personal_id_personal ");
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

	//editar

	public function update($id_servicioMedico, $fecha, $hora, $id_cita)
	{
		try {
			$consulta = $this->conexion->prepare("UPDATE cita SET serviciomedico_id_servicioMedico=:id_servicioMedico,fecha=:fecha,hora=:hora WHERE id_cita =:id_cita");
			$consulta->bindParam(":id_servicioMedico", $id_servicioMedico);
			$consulta->bindParam(":fecha", $fecha);
			$consulta->bindParam(":hora", $hora);
			$consulta->bindParam(":id_cita", $id_cita);
			$consulta->execute();
			return "exito";
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function validarCita($id_paciente, $fecha, $hora)
	{
		try {
			$consulta = $this->conexion->prepare("SELECT * FROM cita WHERE paciente_id_paciente = :id_paciente AND fecha=:fecha AND hora = :hora");
			$consulta->bindParam(":id_paciente", $id_paciente);
			$consulta->bindParam(":fecha", $fecha);
			$consulta->bindParam(":hora", $hora);
			$consulta->execute();

			while ($consulta->fetch()) {
				return "existeC";
			}

			return "noExisteC";
		} catch (\Exception $e) {
			return 0;
		}
	}

	/* metodo para validar que tiempos libres tiene el doctor */

	public function validarHorariosDisponlibles($fecha, $id_personal){
		try {
			$consulta = $this->conexion->prepare('SELECT c.fecha , c.hora, c.hora_salida FROM cita c INNER JOIN serviciomedico sm ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN personal p ON p.id_personal = psm.personal_id_personal WHERE fecha =:fecha AND p.id_personal = :id_personal');
			$consulta->bindParam(":fecha", $fecha);
			$consulta->bindParam(":id_personal", $id_personal);
			return ($consulta->execute()) ? $consulta->fetchAll() : false;
		} catch (\Exception $e) {
			return 0;
		}
	}

}
