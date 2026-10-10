<?php

namespace App\modelos;

use App\modelos\ModelBase;
use DateTime;

class ModeloCita extends ModelBase
{
	private $id_cita, $fecha, $hora, $estado, $id_doctor, $horaSalida, $id_servicioMedico, $id_paciente, $nacionalidad, $cedula;
	private $columnasPermitidas = ['paciente_cedula', 'paciente_nombre', 'telefono', 'doctor_nombre', 'categoria', 'fecha', 'hora', 'estado', 'c.id_cita'];

	private $ordenesPermitidos = ['ASC', 'DESC'];

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
			$sql = "SELECT cs.id_categoria, cs.nombre FROM categoria_servicio cs INNER JOIN serviciomedico sm ON sm.id_categoria = cs.id_categoria INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = sm.id_servicioMedico WHERE cs.estado = 'ACT' AND sm.estado = 'ACT' GROUP BY cs.id_categoria ";
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

	public function mostrarCita($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_cita', $ordenDir = 'DESC')
	{
		try {
			$sql = 'SELECT c.doctor, p.id_paciente, c.serviciomedico_id_servicioMedico, cs.id_categoria, cs.nombre as categoria,
                        c.id_cita, e.nombre as especialidad, sm.precio, c.fecha, c.hora, c.estado,
                        pe.nacionalidad, pe.cedula, pe.nombre as doctor_nombre, pe.apellido as apellido_d, pe.telefono, pe.id_especialidad,
                        p.nacionalidad as paciente_nacionalidad, p.cedula  as paciente_cedula, p.nombre AS paciente_nombre, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion
                    FROM bd.serviciomedico sm
                    INNER JOIN bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
                    INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal
                    INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
                    INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria
                    WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND p.estado = "ACT" AND c.fecha >= CURRENT_DATE';

			$data = [];
			if (!empty($buscar)) {
				$sql .= " AND (p.cedula LIKE :buscar OR p.nombre LIKE :buscar OR p.apellido LIKE :buscar OR c.fecha LIKE :buscar)";
				$data['buscar'] = "%$buscar%";
			}

			$ordenColumna = in_array($ordenColumna, $this->columnasPermitidas) ? $ordenColumna : 'id_cita';
			$ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidos) ? $ordenDir : 'DESC';

			$sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
			$this->setSQL($sql);

			$data['inicio'] = (int)$inicio;
			$data['limite'] = (int)$limite;

			$resultado = $this->search($data);
			return is_array($resultado) ? $resultado : [];
		} catch (\Exception $e) {
			return [];
		}
	}

	public function mostrarCitaHoy($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_cita', $ordenDir = 'DESC')
	{
		try {
			try {
				$sql = 'SELECT c.doctor, p.id_paciente, c.serviciomedico_id_servicioMedico, cs.id_categoria, cs.nombre as categoria,
                        c.id_cita, e.nombre as especialidad, sm.precio, c.fecha, c.hora, c.estado,
                        pe.nacionalidad, pe.cedula, pe.nombre as doctor_nombre, pe.apellido as apellido_d, pe.telefono, pe.id_especialidad,
                        p.nacionalidad as paciente_nacionalidad, p.cedula  as paciente_cedula, p.nombre AS paciente_nombre, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion
                    FROM bd.serviciomedico sm
                    INNER JOIN bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
                    INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal
                    INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
                    INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria
                    WHERE c.estado = "Pendiente" AND c.doctor = psm.personal_id_personal AND p.estado = "ACT" AND c.fecha = CURRENT_DATE';

				$data = [];
				if (!empty($buscar)) {
					$sql .= " AND (p.cedula LIKE :buscar OR p.nombre LIKE :buscar OR p.apellido LIKE :buscar OR c.fecha LIKE :buscar)";
					$data['buscar'] = "%$buscar%";
				}

				$ordenColumna = in_array($ordenColumna, $this->columnasPermitidas) ? $ordenColumna : 'id_cita';
				$ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidos) ? $ordenDir : 'DESC';

				$sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
				$this->setSQL($sql);

				$data['inicio'] = (int)$inicio;
				$data['limite'] = (int)$limite;

				$resultado = $this->search($data);
				return is_array($resultado) ? $resultado : [];
			} catch (\Exception $e) {
				return [];
			}
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarCitaR($inicio = 0, $limite = 10, $buscar = '', $ordenColumna = 'id_cita', $ordenDir = 'DESC')
	{
		try {
			$sql = "SELECT c.doctor, p.id_paciente, c.serviciomedico_id_servicioMedico, cs.id_categoria, cs.nombre as categoria,
                        c.id_cita, e.nombre as especialidad, sm.precio, c.fecha, c.hora, c.estado,
                        pe.nacionalidad, pe.cedula, pe.nombre as doctor_nombre, pe.apellido as apellido_d, pe.telefono, pe.id_especialidad,
                        p.nacionalidad as paciente_nacionalidad, p.cedula  as paciente_cedula, p.nombre AS paciente_nombre, p.apellido apellido_p, p.telefono as telefono_p, p.fn, p.direccion
                    FROM bd.serviciomedico sm
                    INNER JOIN bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
                    INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal
                    INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
                    INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria
                    WHERE c.estado = 'Realizadas' AND c.doctor = psm.personal_id_personal";
			$data = [];
			if (!empty($buscar)) {
				$sql .= " AND (p.cedula LIKE :buscar OR p.nombre LIKE :buscar OR p.apellido LIKE :buscar OR c.fecha LIKE :buscar)";
				$data['buscar'] = "%$buscar%";
			}

			$ordenColumna = in_array($ordenColumna, $this->columnasPermitidas) ? $ordenColumna : 'id_cita';
			$ordenDir = in_array(strtoupper($ordenDir), $this->ordenesPermitidos) ? $ordenDir : 'DESC';
			
			$sql .= " ORDER BY {$ordenColumna} {$ordenDir} LIMIT :inicio, :limite";
			$this->setSQL($sql);

			$data['inicio'] = (int)$inicio;
			$data['limite'] = (int)$limite;

			$resultado = $this->search($data);
			return is_array($resultado) ? $resultado : [];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function contarTotalCitas($tipoCita, $estado, $buscar = '')
	{
		try {
			$data = ['estado' => $estado];
			$sql = "SELECT COUNT(*) as total 
                FROM bd.serviciomedico sm
                    INNER JOIN bd.cita c ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.paciente p ON p.id_paciente = c.paciente_id_paciente
                    INNER JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN bd.personal pe ON pe.id_personal = psm.personal_id_personal
                    INNER JOIN bd.especialidad e ON e.id_especialidad = pe.id_especialidad
                    INNER JOIN bd.categoria_servicio cs ON cs.id_categoria = sm.id_categoria
                WHERE c.estado = :estado AND c.doctor = psm.personal_id_personal";
			
			if ($tipoCita == 'hoy') {
				$sql.= " AND c.fecha = CURRENT_DATE ";
			}
			if ($tipoCita == 'pendiente') {
				$sql .= " AND c.fecha >= CURRENT_DATE ";
			}

			if (!empty($buscar)) {
				$sql .= " AND (p.cedula LIKE :buscar OR p.nombre LIKE :buscar OR p.apellido LIKE :buscar OR c.fecha LIKE :buscar)";
				$data['buscar'] = "%$buscar%";
			}

			$this->setSQL($sql);
			$resultado = $this->search($data, false);

			if (is_array($resultado) && isset($resultado['total'])) {
				return (int)$resultado['total'];
			}
			return 0;
		} catch (\Exception $e) {
			return 0;
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
			// Los días se guardan en la BD con tilde (ej: "miércoles", "sábado")
			$nombreDia = $this->nombreDiaEspanol($this->getFecha());

			$data1 = ['fecha'      => $this->getFecha(), 'id_personal' => $this->getIdDoctor()];
			$data2 = ['dia'        => $nombreDia,        'id_personal' => $this->getIdDoctor()];

			$sql = 'SELECT c.hora as hora_entrada, c.hora_salida 
                    FROM cita c 
                    INNER JOIN personal p ON p.id_personal = c.doctor 
                    WHERE c.fecha = :fecha AND p.id_personal = :id_personal 
                    AND (
                         c.estado = "Pendiente" 
                         OR (c.estado = "Reservado" AND c.creado_en >= NOW() - INTERVAL 5 MINUTE)
                        )';
			$this->setSQL($sql);
			$horasOcupadas = $this->search($data1);

			$sql = 'SELECT hd.horaDeEntrada, hd.horaDeSalida 
                    FROM personal p 
                    INNER JOIN horarioydoctor hd ON hd.id_personal = p.id_personal 
                    INNER JOIN horario h ON h.id_horario = hd.id_horario 
                    WHERE p.id_personal = :id_personal AND h.diaslaborables = :dia';
			$this->setSQL($sql);
			$horasCompletas = $this->search($data2);

			// Se devuelven las horas de ENTRADA ocupadas (HH:MM:SS) y no un
			// intervalo "entrada a salida". Antes se armaba el intervalo con
			// seccionarHoras(), que devuelve [] cuando hora_salida es inválida
			// (00:00:00 o igual a la hora), por lo que el horario ocupado NO se
			// ocultaba en la UI pero el servidor sí lo bloqueaba al reservar
			// (falso positivo de "este cupo ya fue apartado por otro usuario")
			$listHoraOcupada = [];
			foreach ($horasOcupadas as $hora) {
				if (!empty($hora['hora_entrada'])) {
					$listHoraOcupada[] = $hora['hora_entrada'];
				}
			}
			$listHoraOcupada = array_values(array_unique($listHoraOcupada));

			// Se unen los intervalos de todos los turnos del doctor para ese día
			// (un doctor puede tener más de un horario el mismo día)
			$intervalo = [];
			foreach ($horasCompletas as $horario) {
				$intervalo = array_merge(
					$intervalo,
					$this->seccionarHoras($horario['horaDeEntrada'], $horario['horaDeSalida'])
				);
			}

			return [array_values(array_unique($intervalo)), $listHoraOcupada];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// ── PRIVADOS─────────────────────────────────────────

	/**
	 * Nombre del día en español con tilde, tal como se guarda en
	 * horario.diaslaborables (ej: "miércoles", "sábado")
	 */
	private function nombreDiaEspanol($fecha)
	{
		$diasEsp = [
			1 => 'lunes',
			2 => 'martes',
			3 => 'miércoles',
			4 => 'jueves',
			5 => 'viernes',
			6 => 'sábado',
			7 => 'domingo'
		];

		$date = new DateTime($fecha);

		return $diasEsp[$date->format('N')] ?? '';
	}

	/**
	 * Devuelve el id del servicio médico si existe y está activo.
	 * Antes se hacía $fila['id_servicioMedico'] directamente sobre un
	 * fetch() que podía ser false y terminaba guardando un NULL silencioso.
	 */
	private function obtenerServicioActivo()
	{
		$this->setSQL("SELECT id_servicioMedico FROM serviciomedico WHERE id_categoria = :id AND estado = 'ACT'");
		$servicio = $this->search(['id' => $this->getIdServicioMedico()], false);

		if (!$servicio || empty($servicio['id_servicioMedico'])) {
			throw new \Exception("El servicio seleccionado no se encuentra activo.");
		}

		return (int)$servicio['id_servicioMedico'];
	}

	/**
	 * Verifica que el paciente exista realmente antes de agendarle una cita
	 */
	private function validarPacienteExiste()
	{
		$this->setSQL("SELECT id_paciente FROM paciente WHERE id_paciente = :id");

		if (empty($this->search(['id' => $this->getIdPaciente()], false))) {
			throw new \Exception("El paciente seleccionado no existe. Regístrelo antes de agendar la cita.");
		}
	}

	/**
	 * Verifica que la hora solicitada sea una hora de inicio real del turno
	 * del doctor para ese día. Sin esto el backend aceptaba apartar o mover
	 * citas a horarios fuera del horario laboral.
	 */
	private function validarTurnoDelDoctor()
	{
		$dia = $this->nombreDiaEspanol($this->getFecha());

		if ($dia === '') {
			throw new \Exception("La fecha de la cita no es válida.");
		}

		$this->setSQL('SELECT hd.id_horarioydoctor, hd.horaDeSalida AS turno_fin 
					   FROM horarioydoctor hd 
					   INNER JOIN horario h ON h.id_horario = hd.id_horario 
					   WHERE hd.id_personal = :id_personal 
					     AND h.diaslaborables = :dia 
					     AND hd.horaDeEntrada <= :hora_inicio 
					     AND ADDTIME(:hora_fin, "01:00:00") <= hd.horaDeSalida');

		$turno = $this->search([
			'id_personal' => $this->getIdDoctor(),
			'dia'         => $dia,
			'hora_inicio' => $this->getHora(),
			'hora_fin'    => $this->getHora()
		], false);

		if (empty($turno)) {
			throw new \Exception("El doctor no atiende en ese día o a esa hora. Actualice los horarios del doctor.");
		}

		return $turno['turno_fin'];
	}

	/**
	 * Hora de salida de la cita. Si el cliente manda una hora de salida
	 * incoherente (vacía, 00:00:00 o anterior a la de entrada) se calcula
	 * como una hora después, porque una fila con intervalo inválido es
	 * justamente lo que hacía que el horario se mostrara libre en la UI
	 * pero estuviera bloqueado en el servidor.
	 */
	private function calcularHoraSalidaSegura()
	{
		$entrada = $this->getHora();
		$salida  = $this->getHoraSalida();

		if (!empty($salida) && strtotime($salida) > strtotime($entrada)) {
			return $salida;
		}

		return date('H:i:s', strtotime($entrada . ' +1 hour'));
	}

	private function reservar()
	{
		try {
			$this->beginTransaction();

			// Limpiar reservas vencidas. Fallback por si el evento de MySQL
			// "limpiar_reservas_vencidas" está deshabilitado en el servidor,
			// así los cupos abandonados quedan libres de inmediato
			$sqlLimpiar = "UPDATE cita SET estado = 'Expirado' WHERE estado = 'Reservado' AND creado_en < NOW() - INTERVAL 5 MINUTE";
			$this->setSQL($sqlLimpiar);
			$this->query();

			// Servicio, paciente y turno se validan ANTES de insertar la reserva
			$id = $this->obtenerServicioActivo();
			$this->validarPacienteExiste();
			$this->validarTurnoDelDoctor();

			// 1. SI HUBO CAMBIO DE OPINIÓN: Liberamos el cupo viejo poniéndolo en 'Expirado'
			if ($this->getIdCita() !== null && $this->getIdCita()  > 0) {
				$sqlLiberar = "UPDATE cita SET estado = 'Expirado' WHERE id_cita = :id AND estado = 'Reservado'";
				$this->setSQL($sqlLiberar);
				$this->update_logic($this->getIdCita());
			}

			// 2. VALIDACIÓN OPTIMISTA CONCURRENTE
			// (se excluye la propia reserva anterior en caso de cambio de opinión)
			$data = [
				'doctor'         => $this->getIdDoctor(),
				'fecha'          => $this->getFecha(),
				'hora'           => $this->getHora(),
				'id_cita_actual' => $this->getIdCita() ?? 0
			];

			$sqlValidar = "SELECT id_cita FROM cita 
                       WHERE doctor = :doctor 
                         AND fecha = :fecha 
                         AND hora = :hora 
                         AND id_cita <> :id_cita_actual
                         AND (
                              estado IN ('Pendiente', 'Realizadas') 
                              OR (estado = 'Reservado' AND creado_en >= NOW() - INTERVAL 5 MINUTE)
                             )";

			$this->setSQL($sqlValidar);
			if (!empty($this->search($data, false))) {
				throw new \Exception("Este horario ya está ocupado o fue seleccionado por otro usuario en tiempo real. Por favor, elija otro horario.");
			}

			// 3. REGISTRO DE LA NUEVA RESERVA
			$dataInsert = [
				'fecha'             => $this->getFecha(),
				'hora'              => $this->getHora(),
				'estado'            => 'Reservado',
				'id_servicio'       => $id,
				'id_paciente'       => $this->getIdPaciente(),
				'hora_salida'       => $this->calcularHoraSalidaSegura(),
				'doctor'            => $this->getIdDoctor()
			];

			$sqlInsert = "INSERT INTO cita (fecha, hora, estado, serviciomedico_id_servicioMedico, paciente_id_paciente, hora_salida, doctor)
                      VALUES (:fecha, :hora, :estado, :id_servicio, :id_paciente, :hora_salida, :doctor)";

			$this->setSQL($sqlInsert);
			$idCitaGenerada = $this->create($dataInsert);

			$this->commit();
			// Se retorna el ID de la reserva para que el controlador lo hashe
			// y el JS pueda enviarlo como "id_cita_anterior" si cambia de opinión
			return ["exito", $idCitaGenerada];
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

			if (!$id_servicioMedico || empty($id_servicioMedico['id_servicioMedico'])) {
				throw new \Exception("El servicio seleccionado no se encuentra activo.");
			}
			$idService = (int)$id_servicioMedico['id_servicioMedico'];

			// El paciente y el turno se validan también al confirmar la cita
			$this->validarPacienteExiste();
			$this->validarTurnoDelDoctor();

			$sqlConfirmar = "UPDATE cita 
						 SET estado = :estado, 
							 serviciomedico_id_servicioMedico = :id_servicio, 
							 paciente_id_paciente = :id_paciente, 
							 hora_salida = :hora_salida
						 WHERE doctor = :id 
						   AND fecha = :fecha 
						   AND hora = :hora 
						   AND estado = 'Reservado'
						   AND creado_en >= NOW() - INTERVAL 5 MINUTE";

			$dataUpdate = [
				'id_paciente' => $this->getIdPaciente(),
				'id_servicio' => $idService,
				'fecha'       => $this->getFecha(),
				'hora'        => $this->getHora(),
				'estado'      => $this->getEstado(), // Pasará a 'Pendiente'
				'hora_salida' => $this->calcularHoraSalidaSegura()
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

	private function eliminarCitaPrivada($estado = 'DES')
	{
		try {
			$data = ['id_cita' => $this->getIdCita()];

			$sql = "SELECT id_cita FROM cita WHERE id_cita = :id_cita";
			$this->setSQL($sql);
			// search(..., false) devuelve false cuando no hay filas (no un
			// arreglo vacío), por eso la comparación con [] nunca se cumplía
			if (empty($this->search($data, false))) {
				throw new \Exception("El id de la cita no existe.");
			}

			$sql = "UPDATE cita SET estado =:estado WHERE id_cita = :id";
			$this->setSQL($sql);
			$this->update(['estado'=>$estado],$data['id_cita']);

			return ["exito"];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	private function update_cita()
	{
		try {
			// La cita a modificar debe existir y estar en estado editable.
			// Sin esta comprobación un id manipurado o una cita ya realizada
			// podían terminar en un UPDATE que no afectaba filas (error
			// silencioso) o que revolvía el estado a "Pendiente".
			$this->setSQL("SELECT estado FROM cita WHERE id_cita = :id_cita");
			$citaActual = $this->search(['id_cita' => $this->getIdCita()], false);

			if (empty($citaActual)) {
				throw new \Exception("La cita que intenta modificar no existe.");
			}

			if ($citaActual['estado'] !== 'Pendiente') {
				throw new \Exception("Solo se pueden modificar citas en estado Pendiente.");
			}

			// Validar que el horario no esté ocupado por otra cita al editar
			$sqlVal = "SELECT id_cita FROM cita 
                       WHERE doctor = :doctor 
                         AND fecha = :fecha 
                         AND hora = :hora 
                         AND id_cita <> :id_cita 
                         AND estado IN ('Pendiente', 'Realizadas')";
			$this->setSQL($sqlVal);
			if (!empty($this->search([
				'doctor'  => $this->getIdDoctor(),
				'fecha'   => $this->getFecha(),
				'hora'    => $this->getHora(),
				'id_cita' => $this->getIdCita()
			], false))) {
				throw new \Exception("El horario seleccionado ya está ocupado por otra cita.");
			}

			// Servicio, paciente y turno también se validan al modificar
			$id = $this->obtenerServicioActivo();
			$this->validarPacienteExiste();
			$this->validarTurnoDelDoctor();

			$data = [
				'id_paciente'       => $this->getIdPaciente(),
				'id_servicioMedico' => $id,
				'fecha'             => $this->getFecha(),
				'hora'              => $this->getHora(),
				'estado'            => $this->getEstado(),
				'doctor'            => $this->getIdDoctor(),
				'hora_salida'       => $this->calcularHoraSalidaSegura()
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
		// Basta con que falte uno de los dos para rechazar la operación
		if (empty($_SESSION['id_usuario']) || empty($idUsuario)) {
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
		return $this->insertarCita();
	}

	public function eliminarCitaPublic($idUsuario = null,$estado = 'DES')
	{
		$this->validarSesion($idUsuario);
		$this->validarCamposObligatorios([$this->id_cita], ' al eliminar una cita');
		return $this->eliminarCitaPrivada($estado);
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
