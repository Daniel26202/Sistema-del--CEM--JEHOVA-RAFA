<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\config\RateLimiter;
use DateTime;

class ModeloCita extends ModelBase
{
	private $id_cita, $fecha, $hora, $estado, $id_doctor, $horaSalida, $id_servicioMedico, $id_paciente, $nacionalidad, $cedula;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	// ── READ ────────────────────────────────────────────────

	public function selectPaciente()
	{
		try {
			$data = [
				'nacionalidad' => $this->getNacionalidad(),
				'cedula'       => $this->getCedula(),
				'estado'       => 'ACT'
			];
			$sql = "SELECT id_paciente, nacionalidad, cedula, nombre, apellido , telefono, direccion, fn, genero FROM paciente WHERE nacionalidad = :nacionalidad AND cedula = :cedula AND estado = :estado";
			$this->setSQL($sql);
			return $this->search($data, false);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarServicioDoctor()
	{
		try {
			$sql = "SELECT id_categoria, nombre FROM categoria_servicio WHERE estado = 'ACT'";
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
			$sql  = "SELECT p.id_personal, p.nombre AS nombre_doctor, p.apellido AS apellido_doctor 
                     FROM serviciomedico sm 
                     INNER JOIN personal_has_serviciomedico psm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico 
                     INNER JOIN personal p ON p.id_personal = psm.personal_id_personal 
                     WHERE sm.estado = 'ACT' AND sm.id_categoria = :id_servicio";
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
			$sql  = "SELECT sm.*, hyd.*, h.diaslaborables 
                    FROM horarioydoctor hyd 
                    INNER JOIN personal d ON d.id_personal = hyd.id_personal 
                    INNER JOIN horario h ON h.id_horario = hyd.id_horario 
                    INNER JOIN personal_has_serviciomedico psm ON d.id_personal = psm.personal_id_personal 
                    INNER JOIN serviciomedico sm ON sm.id_servicioMedico = psm.serviciomedico_id_servicioMedico 
                    WHERE d.id_personal = :id_doctor 
                    GROUP BY hyd.id_horarioydoctor";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarCita()
	{
		try {
			$sql = 'SELECT c.doctor, p.id_paciente, c.serviciomedico_id_servicioMedico, cs.id_categoria, cs.nombre as categoria,
                        c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado, c.fecha, c.hora, c.estado,
                        pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, pe.id_especialidad,
                        p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion
                    FROM bd.serviciomedico sm
                    INNER JOIN bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
                    INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal
                    INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
                    INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario
                    INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria
                    WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND c.fecha >= CURRENT_DATE';
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarCitaHoy()
	{
		try {
			$data = ['fecha' => date("Y-m-d")];
			$sql  = 'SELECT c.doctor, cs.id_categoria, p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria,
                            c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado, c.fecha, c.hora, c.estado,
                            pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, u.correo, pe.id_especialidad,
                            p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion
                    FROM bd.serviciomedico sm
                    INNER JOIN bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
                    INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal
                    INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
                    INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario
                    INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria
                    WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND c.fecha = :fecha';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarCitaR()
	{
		try {
			$sql = "SELECT c.doctor, cs.id_categoria, p.id_paciente, c.serviciomedico_id_servicioMedico, cs.nombre as categoria,
                        c.id_cita, e.nombre as especialidad, u.*, sm.precio, sm.estado, c.fecha, c.hora, c.estado,
                        pe.nacionalidad, pe.cedula, pe.nombre as nombre_d, pe.apellido as apellido_d, pe.telefono, u.correo, pe.id_especialidad,
                        p.nacionalidad, p.cedula, p.nombre AS nombre_p, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion
                    FROM bd.serviciomedico sm
                    INNER JOIN bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
                    INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal
                    INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
                    INNER JOIN segurity.usuario u ON pe.usuario = u.id_usuario
                    INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria
                    WHERE c.estado = 'Realizadas' AND c.doctor = psm.personal_id_personal";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarTodasCitasHoy()
	{
		try {
			$data = ['fecha' => date("Y-m-d")];
			$sql  = 'SELECT c.id_cita, c.doctor, c.fecha, c.hora, c.estado,
                    cs.id_categoria, cs.nombre AS categoria, e.nombre AS especialidad, pe.nombre AS nombre_d,
                    pe.apellido AS apellido_d, p.id_paciente, p.nombre AS nombre_p, p.apellido AS apellido_p,
                    p.telefono AS telefono_p FROM bd.cita c INNER JOIN bd.serviciomedico sm
                    ON sm.id_servicioMedico = c.serviciomedico_id_servicioMedico INNER JOIN bd.categoria_servicio cs
                    ON cs.id_categoria = sm.id_categoria INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
                INNER JOIN bd.personal pe ON pe.id_personal = c.doctor INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
                WHERE c.fecha  = :fecha AND c.estado IN ("Pendiente", "Realizadas") ORDER BY pe.nombre, c.hora';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

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

			$date       = new DateTime($this->getFecha());
			$nombreDia  = $diasEsp[$date->format('N')];

			$data1 = ['fecha'      => $this->getFecha(), 'id_personal' => $this->getIdDoctor()];
			$data2 = ['dia'        => $nombreDia,        'id_personal' => $this->getIdDoctor()];

			$sql = 'SELECT c.hora as hora_entrada, c.hora_salida 
                    FROM cita c 
                    INNER JOIN personal p ON p.id_personal = c.doctor 
                    WHERE c.fecha = :fecha AND p.id_personal = :id_personal AND c.estado = "Pendiente"';
			$this->setSQL($sql);
			$horasOcupadas = $this->search($data1);

			$sql = 'SELECT hd.horaDeEntrada, hd.horaDeSalida 
                    FROM personal p 
                    INNER JOIN horarioydoctor hd ON hd.id_personal = p.id_personal 
                    INNER JOIN horario h ON h.id_horario = hd.id_horario 
                    WHERE p.id_personal = :id_personal AND h.diaslaborables = :dia';
			$this->setSQL($sql);
			$horasCompletas = $this->search($data2, false);

			$listHoraOcupada = [];
			foreach ($horasOcupadas as $hora) {
				array_push($listHoraOcupada, $this->seccionarHoras($hora['hora_entrada'], $hora['hora_salida']));
			}

			$intervalo = [$this->seccionarHoras($horasCompletas['horaDeEntrada'], $horasCompletas['horaDeSalida'])];

			return [$intervalo, $listHoraOcupada];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// ── PRIVADOS─────────────────────────────────────────

	private function reservar()
	{
		try {
			$this->beginTransaction();

			$sql = "SELECT id_servicioMedico FROM serviciomedico WHERE id_categoria = :id AND estado = 'ACT'";
			$this->setSQL($sql);
			$id_servicioMedico = $this->search(['id' => $this->getIdServicioMedico()], false);
			$id = $id_servicioMedico['id_servicioMedico'];

			// 1. SI HUBO CAMBIO DE OPINIÓN: Liberamos el cupo viejo poniéndolo en 'Expirado'
			if ($this->getIdCita() !== null && $this->getIdCita()  > 0) {
				$sqlLiberar = "UPDATE cita SET estado = 'Expirado' WHERE id_cita = :id_ant AND estado = 'Reservado'";
				$this->setSQL($sqlLiberar);
				$this->update_logic(['id_ant' => $this->getIdCita()]);
			}

			// 2. VALIDACIÓN OPTIMISTA CONCURRENTE
			$data = [
				'doctor' => $this->getIdDoctor(),
				'fecha'  => $this->getFecha(),
				'hora'   => $this->getHora()
			];

			$sqlValidar = "SELECT id_cita FROM cita 
                       WHERE doctor = :doctor 
                         AND fecha = :fecha 
                         AND hora = :hora 
                         AND (
                              estado IN ('Pendiente', 'Realizadas') 
                              OR (estado = 'Reservado' AND creado_en >= NOW() - INTERVAL 5 MINUTE)
                             )";

			$this->setSQL($sqlValidar);
			if (!empty($this->search($data, false))) {
				throw new \Exception("Este horario ya fue seleccionado por otro usuario en tiempo real.");
			}

			// 3. REGISTRO DE LA NUEVA RESERVA
			$dataInsert = [
				'fecha'             => $this->getFecha(),
				'hora'              => $this->getHora(),
				'estado'            => 'Reservado',
				'id_servicio'       => $id,
				'id_paciente'       => $this->getIdPaciente(),
				'hora_salida'       => $this->getHoraSalida(),
				'doctor'            => $this->getIdDoctor()
			];

			$sqlInsert = "INSERT INTO cita (fecha, hora, estado, serviciomedico_id_servicioMedico, paciente_id_paciente, hora_salida, doctor)
                      VALUES (:fecha, :hora, :estado, :id_servicio, :id_paciente, :hora_salida, :doctor)";

			$this->setSQL($sqlInsert);
			$idCitaGenerada = $this->create($dataInsert);

			$this->commit();
			return ["exito", $data];
		} catch (\Exception $e) {
			$this->rollBack();
			return $e->getMessage();
		}
	}


	private function insertarCita()
	{
		try {
			$this->beginTransaction();


			$sql = "SELECT id_servicioMedico FROM serviciomedico WHERE id_categoria = :id AND estado =:estado ";
			$this->setSQL($sql);
			$id_servicioMedico = $this->search(['id' => $this->getIdServicioMedico(), 'estado' => 'ACT'], false);

			if (!$id_servicioMedico) {
				throw new \Exception("El servicio seleccionado no se encuentra activo.");
			}
			$idService = $id_servicioMedico['id_servicioMedico'];

			$sqlConfirmar = "UPDATE cita 
						 SET estado = :estado, 
							 serviciomedico_id_servicioMedico = :id_servicio, 
							 paciente_id_paciente = :id_paciente, 
							 hora_salida = :hora_salida
						 WHERE doctor = :id 
						   AND fecha = :fecha 
						   AND hora = :hora 
						   AND estado = 'Reservado'";

			$dataUpdate = [
				'id_paciente' => $this->getIdPaciente(),
				'id_servicio' => $idService,
				'fecha'       => $this->getFecha(),
				'hora'        => $this->getHora(),
				'estado'      => $this->getEstado(), // Pasará a 'Pendiente'
				'hora_salida' => $this->getHoraSalida()
			];

			$this->setSQL($sqlConfirmar);
			$this->update($dataUpdate, $this->getIdDoctor());


			$this->setSQL("SELECT ROW_COUNT()");
			$filas = $this->query();
			$filasAfectadas = $filas->fetchColumn();

			if ($filasAfectadas == 0) {
				throw new \Exception("Su tiempo límite de reserva (5 minutos) ha expirado en el servidor. Seleccione el horario nuevamente.");
			}

			$this->commit();
			return ["exito", $dataUpdate];
		} catch (\Exception $e) {
			$this->rollBack();
			return $e->getMessage();
		}
	}

	private function eliminarCitaPrivada()
	{
		try {
			$data = ['id_cita' => $this->getIdCita()];

			$sql = "SELECT id_cita FROM cita WHERE id_cita = :id_cita";
			$this->setSQL($sql);
			if ($this->search($data, false) == []) {
				throw new \Exception("El id de la cita no existe.");
			}

			$sql = "UPDATE cita SET estado = 'DES' WHERE id_cita = :id";
			$this->setSQL($sql);
			$this->update_logic($data['id_cita']);

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	private function update_cita()
	{
		try {
			$sql = "SELECT id_servicioMedico FROM serviciomedico WHERE id_categoria = :id AND estado = 'ACT'";
			$this->setSQL($sql);
			$id_servicioMedico = $this->search(['id' => $this->getIdServicioMedico()], false);
			$id = $id_servicioMedico['id_servicioMedico'];

			$data = [
				'id_paciente'       => $this->getIdPaciente(),
				'id_servicioMedico' => $id,
				'fecha'             => $this->getFecha(),
				'hora'              => $this->getHora(),
				'estado'            => $this->getEstado(),
				'doctor'            => $this->getIdDoctor(),
				'hora_salida'       => $this->getHoraSalida()
			];

			$sql = "UPDATE cita SET fecha=:fecha, hora=:hora, estado=:estado,
                        serviciomedico_id_servicioMedico=:id_servicioMedico,
                        paciente_id_paciente=:id_paciente, hora_salida=:hora_salida, doctor=:doctor
                    WHERE id_cita = :id";
			$this->setSQL($sql);
			$this->update($data, $this->getIdCita());

			return ["exito", $data];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// ── PÚBLICOS────────────────────

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
		$x = 1;
		foreach ($campos as $campo) {
			if (empty($campo)) {
				throw new \Exception("No se permiten campos vacíos {$contexto} campo {$x}.");
			}
			$x++;
		}
	}

	public function reservarCita($idUsuario = null)
	{
		$this->validarSesion($idUsuario);
		$this->validarCamposObligatorios([
			$this->id_paciente,
			$this->id_servicioMedico,
			$this->fecha,
			$this->hora,
			$this->id_doctor,
			$this->horaSalida
		], ' al reservar cita una cita');
		(new RateLimiter())->verificar('reservar_cita_' . $idUsuario, 5, 1);
		return $this->reservar();
	}


	public function guardarCita($idUsuario = null)
	{
		$this->validarSesion($idUsuario);
		$this->validarCamposObligatorios([
			$this->id_paciente,
			$this->id_servicioMedico,
			$this->fecha,
			$this->hora,
			$this->estado,
			$this->id_doctor,
			$this->horaSalida
		], ' al registrar una cita');
		(new RateLimiter())->verificar('guardar_cita_' . $idUsuario, 5, 1);
		return $this->insertarCita();
	}

	public function eliminarCitaPublic($idUsuario = null)
	{
		$this->validarSesion($idUsuario);
		$this->validarCamposObligatorios([$this->id_cita], ' al eliminar una cita');
		(new RateLimiter())->verificar('eliminar_cita_' . $idUsuario, 5, 1);
		return $this->eliminarCitaPrivada();
	}

	public function editarCita($idUsuario = null)
	{
		$this->validarSesion($idUsuario);
		$this->validarCamposObligatorios([
			$this->id_cita,
			$this->id_paciente,
			$this->id_servicioMedico,
			$this->fecha,
			$this->hora,
			$this->estado,
			$this->id_doctor,
			$this->horaSalida
		], ' al editar una cita');
		(new RateLimiter())->verificar('editar_cita_' . $idUsuario, 5, 1);
		return $this->update_cita();
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

	public function setIdServicioMedico($id)
	{
		if (!preg_match("/^[0-9]+$/", $id) || (int)$id <= 0) {
			throw new \InvalidArgumentException("El ID del servicio debe ser un número entero positivo.");
		}
		$this->id_servicioMedico = $id;
	}

	public function setIdPaciente($id)
	{
		if (!preg_match("/^[0-9]+$/", $id) || (int)$id <= 0) {
			throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
		}
		$this->id_paciente = $id;
	}

	public function setIdDoctor($id)
	{
		if (!preg_match("/^[0-9]+$/", $id) || (int)$id <= 0) {
			throw new \InvalidArgumentException("El ID del doctor debe ser un número entero positivo.");
		}
		$this->id_doctor = $id;
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

	public function setNacionalidad($nacionalidad)
	{
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
}
