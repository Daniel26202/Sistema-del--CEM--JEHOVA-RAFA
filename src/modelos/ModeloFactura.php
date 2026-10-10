<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloCliente;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloCita;
use App\modelos\ModeloHospitalizacion;
use App\modelos\ModeloServicios;

class ModeloFactura extends ModelBase
{
	private $id_factura, $fecha, $total, $formasDePago, $servicios, $insumos,
		$precioInsumo, $cantidad, $montosDePago, $referencia, $precioServicio,
		$doctor, $cedula, $id_cliente, $id_paciente, $id_cita, $idH, $idInsumo, $precio,
		$doctores, $aplicaIVA, $tipoCambio;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	// ── PRIVADOS DE SEGURIDAD────────────

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
			if (empty($campo) && $campo !== 0 && $campo !== '0') {
				throw new \Exception("No se permiten campos vacíos{$contexto}.");
			}
		}
	}

	// ── READ────────────────────

	public function buscarPacientePorCita()
	{
		try {
			$data = ['cedula' => $this->getCedula()];
			$sql  = "SELECT c.doctor as id_doctor_c, cs.nombre AS categoria,
                            d.nombre AS nombre_d, d.apellido AS apellido_d, sm.*,
                            p.id_paciente, p.cedula AS cedula_p, p.nombre AS nombre_p,
                            p.apellido AS apellido_p, p.telefono AS telefono_p,
                            c.id_cita, c.fecha, c.estado, e.nombre AS especialidad,
                            p.fn as fecha_de_nacimiento
                    FROM paciente p
                    INNER JOIN cita c             ON p.id_paciente = c.paciente_id_paciente
                    INNER JOIN serviciomedico s   ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico
                    INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = s.id_servicioMedico
                    INNER JOIN personal d         ON d.id_personal = ps.personal_id_personal
                    INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario
                    INNER JOIN serviciomedico sm  ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    INNER JOIN especialidad e     ON e.id_especialidad = d.id_especialidad
                    INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria
                    WHERE p.cedula = :cedula
                    	AND u.estado = 'ACT'
                    	AND c.fecha = CURRENT_DATE
                    	AND c.estado = 'Pendiente'
                    LIMIT 1";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarCitaFactura()
	{
		try {
			$data = ['id_cita' => $this->getIdCita()];
			$sql  = "SELECT c.doctor, d.nombre AS nombre_d, d.apellido AS apellido_d,
                            s.*, p.id_paciente, p.nacionalidad,
                            p.cedula AS cedula_p, p.nombre AS nombre_p,
                            p.apellido AS apellido_p, p.telefono AS telefono_p,
                            c.id_cita, c.fecha, c.estado, e.nombre AS especialidad
                    FROM paciente p
                    INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente
                    INNER JOIN serviciomedico s ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico
                    INNER JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = s.id_servicioMedico
                    INNER JOIN personal d         ON psm.personal_id_personal = d.id_personal
                    INNER JOIN especialidad e     ON d.id_especialidad = e.id_especialidad
                    INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario
                    WHERE c.id_cita = :id_cita AND u.estado = 'ACT'
                    LIMIT 1";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarHospitalizacion()
	{
		try {
			$data = ['id_hospitalizacion' => $this->getIdH()];
			$sql  = "SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas,
                            h.fecha_hora_final, h.total_MoEx, h.total,
                            pac.id_paciente, pac.nacionalidad, pac.cedula,
                            pac.nombre, pac.apellido,
                            pe.nombre AS nombredoc, pe.apellido AS apellidodoc, pac.fn
                    FROM hospitalizacion h
                    INNER JOIN paciente pac ON pac.id_paciente = h.id_paciente
                    INNER JOIN personal pe  ON pe.id_personal  = h.personal_id_personal
                    WHERE h.id_hospitalizacion = :id_hospitalizacion
                    GROUP BY h.id_hospitalizacion";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function serviciosIncluidosHospit()
	{
		try {
			$data = ['id_hospitalizacion' => $this->getIdH()];
			$sql  = 'SELECT h.id_hospitalizacion, s.id_servicioMedico,
                            p.id_personal as id_doctor, p.nombre as nombre_d,
                            p.apellido as apellido_d, cs.nombre as categoria,
                            s.precio as precios_servicio
                    FROM hospitalizacion h
                    INNER JOIN servicios_hospitalizacion sh ON sh.id_hospitalizacion = h.id_hospitalizacion
                    INNER JOIN serviciomedico s  ON s.id_servicioMedico = sh.id_servicioMedico
                    INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria
                    INNER JOIN personal_has_serviciomedico ps ON s.id_servicioMedico = ps.serviciomedico_id_servicioMedico
                    INNER JOIN personal p ON p.id_personal = ps.personal_id_personal
                    WHERE h.id_hospitalizacion = :id_hospitalizacion
                    GROUP BY h.id_hospitalizacion';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function unirInsumosHospitalizacion()
	{
		try {
			$data = ['id_hospitalizacion' => $this->getIdH()];
			$sql  = 'SELECT ei.id_entradaDeInsumo, h.id_hospitalizacion,
                            i.nombre, i.medida, i.precio, i.iva AS aplica_iva, ih.cantidad
                    FROM hospitalizacion h
                    INNER JOIN insumodehospitalizacion ih ON h.id_hospitalizacion = ih.id_hospitalizacion
                    INNER JOIN entrada_insumo ei ON ei.id_entradaDeInsumo = ih.id_entradaDeInsumo
                    INNER JOIN insumo i ON i.id_insumo = ei.id_insumo
                    WHERE i.estado = "ACT"
                        AND h.estado = "Pendiente"
                        AND h.id_hospitalizacion = :id_hospitalizacion';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function buscar()
	{
		try {
			$data = ['cedula' => $this->getCedula(), 'estado' => 'ACT'];
			$sql  = 'SELECT * FROM paciente WHERE cedula = :cedula AND estado = :estado';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function buscarCliente()
	{
		try {
			$data = ['cedula' => $this->getCedula(), 'estado' => 'ACT'];
			$sql  = 'SELECT * FROM cliente WHERE cedula = :cedula AND estado = :estado';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarServicios()
	{
		try {
			$sql = "SELECT cs.id_categoria, cs.nombre as categoria, d.nombre AS nombre_d, d.apellido AS apellido_d, sm.*, d.*
                    FROM bd.categoria_servicio cs
                    JOIN bd.serviciomedico sm ON sm.id_categoria = cs.id_categoria
                    JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
                    JOIN bd.personal d    ON psm.personal_id_personal = d.id_personal
                    JOIN segurity.usuario u ON u.id_usuario = d.usuario
                    WHERE sm.estado = 'ACT'
                        AND cs.nombre != 'Consulta'
                        AND tipo != 'Cita'";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarTiposDePagos()
	{
		try {
			$sql = "SELECT * FROM pago";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function consultarFactura()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			$sql = "SELECT * FROM view_factura WHERE id_factura = :id_factura";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function consultarPagoFactura()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			$sql  = "SELECT pf.*, p.nombre
                    FROM pago p
                    INNER JOIN pagodefactura pf ON p.id_pago = pf.id_pago
                    INNER JOIN factura f ON pf.id_factura = f.id_factura
                    WHERE f.id_factura = :id_factura";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function consultarServiciosExtras()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			// Sin LIMIT 1: el comprobante debe listar TODOS los servicios
			// facturados. Antes solo mostraba el primero. El doctor se toma
			// del que se guardó en el detalle (LEFT JOIN para no perder filas).
			$sql = "SELECT cs.nombre AS categoria_servicio, sf.*,
                            COALESCE(pd.nombre, 'Sin asignar') AS nombre_d,
                            COALESCE(pd.apellido, '') AS apellido_d
                    FROM detalle_factura sf
                    INNER JOIN serviciomedico s ON s.id_servicioMedico = sf.serviciomedico_id_servicioMedico
                    INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria
                    LEFT JOIN personal pd ON pd.id_personal = sf.personal_id_personal
                    WHERE sf.id_factura = :id_factura
                        AND sf.tipo = 'Servicio'
                    ORDER BY sf.id_datelle_factura ASC";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function consultarFacturaSinCita()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			$sql  = "SELECT f.*, p.nombre as nombre_p, p.apellido AS apellido_p,
                            nacionalidad, p.cedula AS cedula_p
                    FROM factura f
                    INNER JOIN cliente p ON p.id_cliente = f.id_cliente
                    WHERE f.id_factura = :id_factura";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function consultarFacturaInsumo()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			// Se lee el precio y el IVA desde detalle_factura (lo que se cobró de
			// verdad) en lugar del catálogo actual: si el precio del insumo cambia
			// después, el comprobante antiguo seguía mostrando el valor nuevo.
			$sql  = "SELECT ins.nombre, ins.medida, ins.iva AS aplica_iva,
                            fi.cantidad, fi.precio_unitario, fi.subtotal,
                            fi.iva_aplicado, fi.tasa_iva
                    FROM detalle_factura fi
                    INNER JOIN entrada_insumo i ON i.id_entradaDeInsumo = fi.entrada_insumo_id_entradaDeInsumo
                    INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo
                    WHERE fi.id_factura = :id_factura
                        AND fi.tipo = 'Insumo'
                    ORDER BY fi.id_datelle_factura ASC";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function selectsFacturaHosp()
	{
		try {
			$data = ['idH' => $this->getIdH()];
			$sql = 'SELECT h.id_hospitalizacion, h.duracion, h.precio_horas, h.total,
                            con.id_control, con.diagnostico, h.historiaclinica,
                            pac.nacionalidad, pac.id_paciente, pac.cedula,
                            pac.nombre, pac.apellido, u.id_usuario,
                            doc.nombre AS nombredoc, doc.apellido AS apellidodoc
                    FROM hospitalizacion h
                    INNER JOIN control con ON h.id_control = con.id_control
                    INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente
                    INNER JOIN usuario u   ON con.id_usuario = u.id_usuario
                    INNER JOIN personal doc ON doc.id_usuario = u.id_usuario
                    INNER JOIN serviciomedico sm ON sm.id_personal = doc.id_personal
                    WHERE con.estado = "ACT"
                        AND sm.estado = "ACT"
                        AND u.estado = "ACT"
                        AND h.estado = "Pendiente"
                        AND h.id_hospitalizacion = :idH
                    GROUP BY h.id_hospitalizacion';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function selectInsumosHosp()
	{
		try {
			$data = ['idH' => $this->getIdH()];
			$sql = 'SELECT i.*, ih.cantidad AS cantidad_insumo_hospit
                    FROM insumodehospitalizacion ih
                    INNER JOIN insumo i ON i.id_insumo = ih.id_insumo
                    WHERE ih.id_hospitalizacion = :idH';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function consultarFacturaHosp()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			$sql = 'SELECT *, f.fecha, f.total, f.id_factura,
                            p.nombre AS nombre_paciente, p.apellido AS apellido_paciente,
                            p.cedula AS cedula_paciente, p.nacionalidad,
                            d.nombre AS nombre_d, d.apellido AS apellido_d
                    FROM hospitalizacion h
                    INNER JOIN factura f  ON f.id_hospitalizacion = h.id_hospitalizacion
                    INNER JOIN control c  ON h.id_control = c.id_control
                    INNER JOIN usuario u  ON u.id_usuario = c.id_usuario
                    INNER JOIN personal d ON d.id_usuario = u.id_usuario
                    INNER JOIN paciente p ON c.id_paciente = p.id_paciente
                    WHERE f.id_factura = :id_factura';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function consultarFacturaHospSer()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			$sql = 'SELECT f.*, h.*, p.*,
                            u.nombre AS nombre_d, u.apellido AS apellido_d
                    FROM factura f
                    INNER JOIN hospitalizacion h ON h.id_hospitalizacion = f.id_hospitalizacion
                    INNER JOIN control c  ON c.id_control = h.id_control
                    INNER JOIN paciente p ON p.id_paciente = c.id_paciente
                    INNER JOIN usuario u  ON u.id_usuario = c.id_usuario
                    WHERE f.id_factura = :id_factura';
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function coincidenciaPacienteCliente()
	{
		try {
			$data = ['id_paciente' => $this->getIdPaciente()];
			$sql = 'SELECT * FROM paciente WHERE id_paciente = :id_paciente';
			$this->setSQL($sql);
			$dataPaciente = $this->search($data, false);

			$sql = 'SELECT * FROM paciente p
                    INNER JOIN cliente c ON c.cedula = p.cedula
                    WHERE p.cedula = :cedula';
			$this->setSQL($sql);
			$data = $this->search(['cedula' => $dataPaciente['cedula']], false);

			if ($data) {
				return $data['id_cliente'];
			}
			return 0;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function comprobarSiFueHospit()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			$sql = 'SELECT * FROM factura f
                    INNER JOIN detalle_factura df ON df.id_factura = f.id_factura
                    WHERE f.id_factura = :id_factura AND df.tipo = "Hospitalizacion"';
			$this->setSQL($sql);
			$data = $this->search($data, false);

			return $data ? $data['hospitalizacion_id_hospitalizacion'] : 0;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	// ── PRIVADOS──────────────────────────────────

	/**
	 * Reserva y devuelve los lotes (entradas) que cubren la cantidad solicitada.
	 *
	 * Hace el bloqueo de filas ANTES de decidir, de modo que dos cajeros
	 * simultaneos no puedan vender el mismo stock. Antes el SELECT del lote
	 * ocurría sin bloqueo y DescontarLotes no fallaba si no alcanzaba.
	 *
	 * @return array lista de ['id_entradaDeInsumo' => int, 'cantidad' => int]
	 * @throws \DomainException si el stock no alcanza
	 */
	private function reservarLotes($id_insumo, $cantidad)
	{
		$this->setSQL("SELECT ei.id_entradaDeInsumo, ei.cantidad_disponible
                    FROM entrada_insumo ei
                    INNER JOIN entrada e ON e.id_entrada = ei.id_entrada
                    INNER JOIN insumo i ON i.id_insumo = ei.id_insumo
                    WHERE ei.id_insumo = :id_insumo
                        AND ei.cantidad_disponible > 0
                        AND i.estado = 'ACT'
                        AND e.estado = 'ACT'
                        AND ei.fechaDeVencimiento > CURDATE()
                    ORDER BY e.fechaDeIngreso ASC
                    FOR UPDATE");

		$lotes = $this->search(['id_insumo' => $id_insumo]);

		$disponible = 0;
		foreach ($lotes as $lote) {
			$disponible += (int)$lote['cantidad_disponible'];
		}

		if ($disponible < $cantidad) {
			throw new \DomainException(
				"El insumo seleccionado no tiene stock suficiente. Disponible: $disponible, solicitado: $cantidad."
			);
		}

		// Reparte la cantidad entre los lotes mas antiguos primero (FIFO).
		$restante = $cantidad;
		$reserva = [];
		foreach ($lotes as $lote) {
			if ($restante <= 0) {
				break;
			}
			$usar = min((int)$lote['cantidad_disponible'], $restante);
			$reserva[] = [
				'id_entradaDeInsumo' => (int)$lote['id_entradaDeInsumo'],
				'cantidad' => $usar,
			];
			$restante -= $usar;
		}

		return $reserva;
	}

	/**
	 * Recalcula el total de la factura a partir del detalle.
	 *
	 * Este total es el ÚNICO que se guarda. El navegador puede mandar el valor
	 * que quiera: se ignora y se usa esta suma.
	 */
	private function calcularTotalDesdeDetalle($id_factura)
	{
		$this->setSQL("SELECT COALESCE(SUM(subtotal), 0) AS total FROM detalle_factura WHERE id_factura = :id_factura");
		$fila = $this->search(['id_factura' => $id_factura], false);

		return round((float)($fila['total'] ?? 0), 2);
	}

	/**
	 * Precio real de un servicio médico, en DIVISA.
	 *
	 * Se lee de la base, no del navegador: si alguien manipula precioServicio[]
	 * en el formulario, su valor se descarta y se cobra el precio del catálogo.
	 *
	 * @throws \DomainException si el servicio no existe o no está activo.
	 */
	private function precioRealServicio($idServicio)
	{
		$id = (int)$idServicio;
		if ($id <= 0) {
			throw new \DomainException("El servicio facturado no es válido.");
		}

		$this->setSQL("SELECT precio FROM serviciomedico
                       WHERE id_servicioMedico = :id AND estado = 'ACT'");
		$fila = $this->search(['id' => $id], false);

		if (!$fila || (float)$fila['precio'] <= 0) {
			throw new \DomainException("El servicio seleccionado no existe o no está disponible.");
		}

		return round((float)$fila['precio'], 2);
	}

	/**
	 * Precio real de un insumo y si lleva IVA, en DIVISA.
	 *
	 * Igual que los servicios: manda la base de datos, no el navegador.
	 *
	 * @return array{precio: float, iva: int}
	 * @throws \DomainException si el insumo no existe o no está activo.
	 */
	private function datosRealesInsumo($idInsumo)
	{
		$id = (int)$idInsumo;
		if ($id <= 0) {
			throw new \DomainException("El insumo facturado no es válido.");
		}

		$this->setSQL("SELECT precio, iva FROM insumo WHERE id_insumo = :id AND estado = 'ACT'");
		$fila = $this->search(['id' => $id], false);

		if (!$fila || (float)$fila['precio'] <= 0) {
			throw new \DomainException("El insumo seleccionado no existe o no está disponible.");
		}

		return [
			'precio' => round((float)$fila['precio'], 2),
			'iva'    => (int)$fila['iva'] === 1 ? 1 : 0,
		];
	}

	private function insertar()
	{
		// Definimos una bandera para saber si la transacción realmente se inició
		$transaccionActiva = false;
		try {


			$this->beginTransaction();
			$transaccionActiva = true; // Marcamos que la transacción está abierta

			
			// ── Tasa de cambio ───────────────────────────────────────────────────
		// La que usó el navegador para mostrar los importes al cliente. Se
		// contrasta con la del servidor: si se aleja más de un 10% se rechaza,
		// para que nadie pueda facturar con una tasa inventada desde el POST.
		$tasaServidor = tasaCambioActual();
		$tasaCliente  = (float)($this->tipoCambio ?? 0);

		if ($tasaCliente <= 0 || !is_numeric($this->tipoCambio)) {
			throw new \DomainException("No se recibió la tasa de cambio de la factura.");
		}

		$desvio = abs($tasaCliente - $tasaServidor) / max($tasaServidor, 0.0001);
		if ($tasaServidor > 0 && $desvio > 0.10) {
			throw new \DomainException(
				"La tasa de cambio enviada ($tasaCliente) no coincide con la del día ($tasaServidor)."
			);
		}

		// Con la que se calculan todos los importes de esta factura.
		$tasa = $tasaCliente;

		
		$this->setSQL("SELECT * FROM cliente WHERE id_cliente = :id_cliente");
		if ($this->search(['id_cliente' => $this->getIdCliente()], false) == []) {
			throw new \Exception("El id del cliente no existe.");
		}

	
		// El total se recalcula más abajo desde detalle_factura; aquí se inserta
		// un provisional que se valida al final de la transacción.
		$this->setSQL("INSERT INTO factura (fecha, total, tipo_cambio, estado, id_cliente)
                            VALUES (:fecha, :total, :tipo_cambio, :estado, :id_cliente)");
		$id_factura = $this->create([
			'fecha'      => $this->getFecha(),
			'total'      => 0,
			'tipo_cambio' => $tasa,
			'estado'     => 'ACT',
			'id_cliente' => $this->getIdCliente()
		]);

			if (!empty($this->getIdCita())) {
				// Bloqueo pesimista de fila seguro
				$this->setSQL("SELECT id_cita FROM cita WHERE id_cita = :id FOR UPDATE");
				$this->search(['id' => $this->getIdCita()], false);

				$this->setSQL("UPDATE cita SET estado = 'Realizadas' WHERE id_cita = :id");
				$this->update_logic($this->getIdCita());
			}

			// Cerrar hospitalización si aplica
			if ($this->getIdH() != 0) {
				$this->setSQL("SELECT id_hospitalizacion FROM hospitalizacion WHERE id_hospitalizacion = :id FOR UPDATE");
				$this->search(['id' => $this->getIdH()], false);

				$this->setSQL("UPDATE hospitalizacion SET estado = 'Realizada' WHERE id_hospitalizacion = :id");
				$this->update_logic($this->getIdH());


				// El total se toma del registro, no del POST.
				// OJO: hospitalizacion.total_MoEx está en DIVISA (lo genera
				// hospitalizacion.js dividiendo los bolívares entre la tasa);
				// `total` ya está en bolívares. Se usa total_MoEx para que el
				// servidor aplique la MISMA conversión que a servicios e insumos.
				$this->setSQL("SELECT total_MoEx FROM hospitalizacion WHERE id_hospitalizacion = :idH");
				$hospit = $this->search(['idH' => $this->getIdH()], false);
				$totalHospitDivisa = round((float)($hospit['total_MoEx'] ?? 0), 2);

				$this->setSQL("INSERT INTO detalle_factura
                            (id_factura, tipo, cantidad, precio_divisa, precio_unitario, subtotal, hospitalizacion_id_hospitalizacion)
                            VALUES (:id_factura, :tipo, :cantidad, :precio_divisa, :precio_unitario, :subtotal, :id_hospitalizacion)");
				$this->create([
					'id_factura' => $id_factura,
					'tipo' => 'Hospitalizacion',
					'cantidad' => 1,
					'precio_divisa' => $totalHospitDivisa,
					'precio_unitario' => round($totalHospitDivisa * $tasa, 2),
					'subtotal' => round($totalHospitDivisa * $tasa, 2),
					'id_hospitalizacion' => $this->getIdH()
				]);
				// Actualizar historial clínico del último control
				$this->setSQL("SELECT con.id_control, con.id_paciente, con.historiaclinica
                                FROM control con
                                INNER JOIN hospitalizacion h ON h.id_paciente = con.id_paciente
                                WHERE h.id_hospitalizacion = :idHosp
                                ORDER BY con.id_control DESC LIMIT 1");
				$datosControl = $this->search(['idHosp' => $this->getIdH()], false);
				$historialEnF = $datosControl["historiaclinica"];

				$this->setSQL("SELECT cs.nombre AS servicio, sh.cantidad, sm.tipo
                                FROM servicios_hospitalizacion sh
                                INNER JOIN serviciomedico sm ON sm.id_servicioMedico = sh.id_servicioMedico
                                INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria
                                WHERE sh.id_hospitalizacion = :idHosp");
				$servicios = $this->search(['idHosp' => $this->getIdH()]);

				if ($servicios) {
					$lista = [];
					foreach ($servicios as $serv) {
						$lista[] = strtolower($serv["tipo"]) === "examenes"
							? "{$serv["servicio"]} ({$serv["cantidad"]} unidades)"
							: $serv["servicio"];
					}
					$historialEnF = "Servicios utilizados: " . implode(", ", $lista) . ". El paciente: " . $historialEnF;
				}

				$this->setSQL('UPDATE control SET historiaclinica = :historial, estado = :estado WHERE id_control = :id');
				$this->update(['historial' => $historialEnF, 'estado' => 'ACT'], $datosControl["id_control"]);
			}

			// Insertar formas de pago
			$contador = 0;
			foreach ($this->getFormasDePago() as $id_pago) {
				$monto = $this->getMontosPagos()[$contador] ?? null;
				if ($monto === null) {
					throw new \DomainException("Falta el monto del metodo de pago seleccionado.");
				}

				$this->setSQL("INSERT INTO pagodefactura (id_pago, id_factura, referencia, monto)
                            VALUES (:id_pago, :id_factura, :referencia, :monto)");
				$this->create([
					'id_pago' => $id_pago,
					'id_factura' => $id_factura,
					'referencia' => $this->getReferencia(),
					'monto' => round((float)$monto, 2)
				]);
				$contador++;
			}

			// Insertar servicios extras
			if ($this->getServicios()) {
				$contador = 0;
				foreach ($this->getServicios() as $s) {
					// SEGURIDAD: el precio se busca en serviciomedico. Lo que venga
					// en precioServicio[] se ignora, así que manipular el formulario
					// no cambia el importe cobrado.
					$precioDivisa = $this->precioRealServicio($s);
					$precio = round($precioDivisa * $tasa, 2);

					$this->setSQL("INSERT INTO detalle_factura
                            (id_factura, tipo, cantidad, precio_divisa, precio_unitario, subtotal, serviciomedico_id_servicioMedico, personal_id_personal)
                            VALUES (:id_factura, :tipo, :cantidad, :precio_divisa, :precio_unitario, :subtotal, :servicio, :personal)");
					$this->create([
						'id_factura' => $id_factura,
						'tipo' => 'Servicio',
						'cantidad' => 1,
						'precio_divisa' => round($precioDivisa, 2),
						'precio_unitario' => $precio,
						'subtotal' => $precio,
						// El doctor ahora sí se persiste: antes se enviaba
						// doctores[] y el modelo lo ignoraba por completo.
						'servicio' => $s,
						'personal' => $this->getDoctores()[$contador] ?? null
					]);
					$contador++;
				}
			}

			// Insertar insumos (solo si no es hospitalización)
			if ($this->getInsumos() && $this->getIdH() == 0) {
				$contador = 0;
				foreach ($this->getInsumos() as $i) {
					$cantidad = (int)($this->getCantidad()[$contador] ?? 0);
					if ($cantidad <= 0) {
						throw new \DomainException("La cantidad de insumos debe ser mayor a cero.");
					}

					// Bloquea los lotes y verifica que alcancen ANTES de facturar.
					// Antes se llamaba al procedimiento DescontarLotes, que consume
					// lo que puede y no falla aunque falte stock: la factura
					// quedaba guardada con una cantidad que nunca se descontó.
					$reserva = $this->reservarLotes($i, $cantidad);

					// SEGURIDAD: precio e IVA salen de la tabla insumo. Lo que el
					// navegador mande en precioInsumo[] y aplicaIVA[] se ignora.
					$datosInsumo = $this->datosRealesInsumo($i);
					$aplicaIVA = $datosInsumo['iva'] === 1;

					// El IVA solo se aplica al precio unitario, nunca a la cantidad.
					$precioUnitarioDivisa = $aplicaIVA
						? round($datosInsumo['precio'] * (1 + (defined('TASA_IMPUESTO') ? TASA_IMPUESTO : 0.16)), 2)
						: $datosInsumo['precio'];
					$precioUnitario = round($precioUnitarioDivisa * $tasa, 2);

					foreach ($reserva as $lote) {
						// precio_divisa guarda la BASE sin IVA: el impuesto va en
						// tasa_iva, para poder mostrarlo desglosado en el comprobante.
						$baseDivisa = $datosInsumo['precio'];

						$this->setSQL("INSERT INTO detalle_factura
                            (id_factura, tipo, cantidad, precio_divisa, precio_unitario, subtotal, iva_aplicado, tasa_iva, entrada_insumo_id_entradaDeInsumo)
                            VALUES (:id_factura, :tipo, :cantidad, :precio_divisa, :precio_unitario, :subtotal, :iva_aplicado, :tasa_iva, :id_entrada)");
						$this->create([
							'id_factura' => $id_factura,
							'tipo' => 'Insumo',
							'cantidad' => $lote['cantidad'],
							'precio_divisa' => $baseDivisa,
							'precio_unitario' => $precioUnitario,
							'subtotal' => round($precioUnitario * $lote['cantidad'], 2),
							'iva_aplicado' => $aplicaIVA ? 1 : 0,
							'tasa_iva' => $aplicaIVA ? (defined('TASA_IMPUESTO') ? TASA_IMPUESTO : 0.16) : 0,
							'id_entrada' => $lote['id_entradaDeInsumo']
						]);

						// Descuento con guardia: si otro proceso consumió el lote entre el
						// SELECT ... FOR UPDATE y este UPDATE, la condición no se
						// cumple y se aborta en lugar de dejar el stock negativo.
						$this->setSQL("UPDATE entrada_insumo
                            SET cantidad_disponible = cantidad_disponible - :c
                            WHERE id_entradaDeInsumo = :id AND cantidad_disponible >= :c");
// :id lo enlaza update(); no debe ir en el array o se enlaza dos veces
						// y PDO lanza "Invalid parameter number".
						// :c y :c2 son marcadores distintos a propósito. Un mismo nombre
						// repetido funciona con EMULATE_PREPARES=true (valor por defecto
						// de PDO en MySQL) pero lanza HY093 si alguien lo desactiva:
						// mejor no depender de una configuración implícita.
						$this->setSQL("UPDATE entrada_insumo
                            SET cantidad_disponible = cantidad_disponible - :c
                            WHERE id_entradaDeInsumo = :id AND cantidad_disponible >= :c2");
						$this->update([
							'c' => $lote['cantidad'],
							'c2' => $lote['cantidad']
						], $lote['id_entradaDeInsumo']);

						$this->setSQL("SELECT cantidad_disponible FROM entrada_insumo WHERE id_entradaDeInsumo = :id");
						$tras = $this->search(['id' => $lote['id_entradaDeInsumo']], false);
						if ((int)($tras['cantidad_disponible'] ?? -1) < 0) {
							throw new \DomainException("El stock del insumo cambió durante la operación. Intente de nuevo.");
						}
					}

					$contador++;
				}
			}
			// ── Total autoritativo ──────────────────────────────────────────────
			// El total sale del detalle que ACABA de guardarse con los precios
			// reales de la base. Ese valor es el único que se persiste.
			//
			// Si alguien manipula `total` (o precioServicio[] / precioInsumo[]) en
			// el navegador, su valor se descarta: la factura se guarda con la suma
			// real. No se rechaza, se corrige.
			$totalReal = $this->calcularTotalDesdeDetalle($id_factura);

			// Los montos de pago deben cubrir exactamente el total real.
			$sumaMontos = array_sum(array_map('floatval', (array)$this->getMontosPagos()));
			if ($totalReal > 0 && abs($sumaMontos - $totalReal) > 0.01) {
				throw new \DomainException(
					"La suma de los montos de pago ($sumaMontos BS) no cubre el total de la factura ($totalReal BS)."
				);
			}

			// Se persiste el total verificado
			// OJO: update() enlaza SIEMPRE el parámetro :id, por eso la cláusula
			// WHERE usa :id y el id no se manda dentro del array.
			$this->setSQL("UPDATE factura SET total = :total, tipo_cambio = :tipo_cambio WHERE id_factura = :id");
			$this->update([
				'total' => $totalReal,
				'tipo_cambio' => $tasa
			], $id_factura);

			// Queda constancia de lo que el navegador intentó enviar.
			error_log(sprintf(
				'Factura %d: total real %.2f BS (el navegador envio %.2f)',
				$id_factura,
				$totalReal,
				(float)$this->getTotal()
			));

			//confitmar
			$this->commit();
			return ['exito' => true, 'id_factura' => $id_factura, 'total' => $totalReal];
		} catch (\Throwable $e) {
			// rollback si algo fallo
			if ($transaccionActiva) {
				$this->rollBack();
			}
			error_log("Error al guardar factura: " . $e->getMessage());
			// Se devuelve SIEMPRE un array para que el controlador distinga
			// exito de error. Antes devolvía un string, que el controlador
			// interpretaba como éxito (truthy) y redirigía a un comprobante
			// inexistente: la factura se perdía en silencio.
			return ['exito' => false, 'error' => $e->getMessage()];
		}
	}

	// ── PÚBLICO──────────────────────────────────────

	public function guardarCliente($idUsuario = null)
	{
		try {
			$data = ['id_paciente' => $this->getIdPaciente()];
			$this->setSQL("SELECT * FROM paciente WHERE id_paciente = :id_paciente");
			$dataPaciente = $this->search($data, false);

			$modeloCliente = new ModeloCliente();
			$modeloCliente->setNacionalidad($dataPaciente['nacionalidad']);
			$modeloCliente->setCedula($dataPaciente['cedula']);
			$modeloCliente->setNombre($dataPaciente['nombre']);
			$modeloCliente->setApellido($dataPaciente['apellido']);
			$modeloCliente->setTelefono($dataPaciente['telefono']);
			$modeloCliente->setDireccion($dataPaciente['direccion']);
			$modeloCliente->setFn($dataPaciente['fn']);
			$modeloCliente->setGenero($dataPaciente['genero']);

			return $modeloCliente->guardarCliente($idUsuario);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function guardarFactura($idUsuario = null)
	{
		$this->validarSesion($idUsuario);
		$this->validarCamposObligatorios([
			$this->fecha,
			$this->total,
			$this->formasDePago,
			$this->montosDePago
		], ' al registrar una factura');

		// Debe existir al menos un concepto facturable.
		if (empty($this->servicios) && empty($this->insumos) && empty($this->idH)) {
			throw new \DomainException("No se puede registrar una factura sin servicios ni insumos.");
		}

		return $this->insertar();
	}

	// ── Getters──────────────────────────────────────────────────────────────

	public function getIdFactura()
	{
		return $this->id_factura;
	}
	public function getFecha()
	{
		return $this->fecha;
	}
	public function getTotal()
	{
		return $this->total;
	}
	public function getFormasDePago()
	{
		return $this->formasDePago;
	}
	public function getReferencia()
	{
		return $this->referencia;
	}
	public function getMontosPagos()
	{
		return $this->montosDePago;
	}
	public function getServicios()
	{
		return $this->servicios;
	}
	public function getInsumos()
	{
		return $this->insumos;
	}
	public function getCantidad()
	{
		return $this->cantidad;
	}
	public function getPrecioInsumo()
	{
		return $this->precioInsumo;
	}
	public function getPrecioServicio()
	{
		return $this->precioServicio;
	}
	public function getDoctores()
	{
		return $this->doctores ?? [];
	}
	public function getAplicaIVA()
	{
		return $this->aplicaIVA ?? [];
	}
	public function getCedula()
	{
		return $this->cedula;
	}
	public function getIdCliente()
	{
		return $this->id_cliente;
	}
	public function getIdPaciente()
	{
		return $this->id_paciente;
	}
	public function getIdCita()
	{
		return $this->id_cita;
	}
	public function getIdH()
	{
		return $this->idH;
	}
	public function getPrecio()
	{
		return $this->precio;
	}

	// ── Setters ──────────────────────────────────────────────────────────────

	public function setIdFactura($id_factura)
	{
		if (!preg_match("/^[0-9]+$/", $id_factura) || (int)$id_factura <= 0) {
			throw new \InvalidArgumentException("El ID de la factura debe ser un número entero positivo.");
		}
		$this->id_factura = (int)$id_factura;
	}

	public function setFecha($fecha)
	{
		$dt       = \DateTime::createFromFormat('Y-m-d', $fecha);
		$fechaHoy = date("Y-m-d");

		if (!$dt || $dt->format('Y-m-d') !== $fecha) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if ($fecha !== $fechaHoy) {
			throw new \InvalidArgumentException("La fecha debe ser de hoy.");
		}
		$this->fecha = $fecha;
	}

	public function setTotal($total)
	{
		if (!preg_match("/^(?!0$)(?!1$)\d+([.,]\d+)?$/", $total)) {
			throw new \InvalidArgumentException("El total es inválido.");
		}
		$this->total = $total;
	}

	public function setFormasDePago($formasDePago = [])
	{
		if (!is_array($formasDePago)) {
			throw new \InvalidArgumentException("Las formas de pago deben ser un arreglo.");
		}
		$this->formasDePago = $formasDePago;
	}

	public function setReferencia($referencia)
	{
		// "0" significa "sin referencia" y es válido para efectivo/divisas.
		if ((string)$referencia === '0') {
			$this->referencia = '0';
			return;
		}

		// El resto debe ser exactamente 4 dígitos (los últimos del comprobante).
		// Antes solo se comprobaba que fuera numérico, de modo que "12" se
		// guardaba como referencia válida.
		if (!preg_match("/^[0-9]{4}$/", (string)$referencia)) {
			throw new \InvalidArgumentException("La referencia debe tener los ultimos 4 digitos.");
		}
		$this->referencia = (string)$referencia;
	}

	public function setMontosPago($montosDePago = [])
	{
		if (!is_array($montosDePago)) {
			throw new \InvalidArgumentException("Los montos de pago deben ser un arreglo.");
		}
		foreach ($montosDePago as $monto) {
			if (!is_numeric($monto) || (float)$monto <= 0) {
				throw new \InvalidArgumentException("El monto del metodo de pago no es valido.");
			}
		}
		$this->montosDePago = array_map('floatval', $montosDePago);
	}

	public function setInsumos($insumos = [])
	{
		if (!is_array($insumos)) {
			throw new \InvalidArgumentException("Los insumos deben ser un arreglo.");
		}
		foreach ($insumos as $insumo) {
			if (!preg_match("/^[0-9]+$/", (string)$insumo)) {
				throw new \InvalidArgumentException("El insumo seleccionado no es valido.");
			}
		}
		$this->insumos = array_map('intval', $insumos);
	}

	public function setServicios($servicios = [])
	{
		if (!is_array($servicios)) {
			throw new \InvalidArgumentException("Los servicios deben ser un arreglo.");
		}
		foreach ($servicios as $servicio) {
			if (!preg_match("/^[0-9]+$/", (string)$servicio)) {
				throw new \InvalidArgumentException("El servicio seleccionado no es valido.");
			}
		}
		$this->servicios = array_map('intval', $servicios);
	}

	public function setCatidad($cantidad = [])
	{
		if (!is_array($cantidad)) {
			throw new \InvalidArgumentException("La cantidad debe ser un arreglo.");
		}
		foreach ($cantidad as $c) {
			if (!is_numeric($c) || (int)$c <= 0 || (int)$c > 100000) {
				throw new \InvalidArgumentException("La cantidad de insumos no es valida.");
			}
		}
		$this->cantidad = array_map('intval', $cantidad);
	}

	public function setPrecioInsumo($precioInsumo = [])
	{
		if (!is_array($precioInsumo)) {
			throw new \InvalidArgumentException("Los precios de insumo deben ser un arreglo.");
		}
		foreach ($precioInsumo as $precio) {
			if (!is_numeric($precio) || (float)$precio <= 0) {
				throw new \InvalidArgumentException("El precio del insumo es invalido.");
			}
		}
		$this->precioInsumo = array_map('floatval', $precioInsumo);
	}

	public function setPrecioServicio($precioServicio = [])
	{
		if (!is_array($precioServicio)) {
			throw new \InvalidArgumentException("Los precios de servicio deben ser un arreglo.");
		}
		// Antes estos valores coming straight del POST sin validar: un total
		// manipulado o un precio negativo se guardaban tal cual.
		foreach ($precioServicio as $precio) {
			if (!is_numeric($precio) || (float)$precio <= 0) {
				throw new \InvalidArgumentException("El precio del servicio es invalido.");
			}
		}
		$this->precioServicio = array_map('floatval', $precioServicio);
	}

	public function setAplicaIVA($aplicaIVA = [])
	{
		if (!is_array($aplicaIVA)) {
			throw new \InvalidArgumentException("El indicador de IVA debe ser un arreglo.");
		}
		$this->aplicaIVA = array_map(fn($v) => $v ? 1 : 0, $aplicaIVA);
	}

	/**
	 * Tasa de cambio usada por el navegador (Bs por unidad de divisa).
	 * Se guarda en la factura para poder auditar el comprobante.
	 */
	public function setTipoCambio($tipoCambio)
	{
		if (!is_numeric($tipoCambio) || (float)$tipoCambio <= 0) {
			throw new \InvalidArgumentException("La tasa de cambio no es valida.");
		}
		$this->tipoCambio = round((float)$tipoCambio, 4);
	}

	public function getTipoCambio()
	{
		return $this->tipoCambio;
	}

	public function setDoctores($doctores = [])
	{
		if (!is_array($doctores)) {
			throw new \InvalidArgumentException("Los doctores deben ser un arreglo.");
		}
		foreach ($doctores as $doctor) {
			if ($doctor !== null && $doctor !== '' && !preg_match("/^[0-9]+$/", (string)$doctor)) {
				throw new \InvalidArgumentException("El doctor seleccionado no es valido.");
			}
		}
		$this->doctores = $doctores;
	}

	public function setPrecio($precio)
	{
		if (!preg_match("/^(?!0$)(?!1$)\d+([.,]\d+)?$/", $precio)) {
			throw new \InvalidArgumentException("El precio es inválido.");
		}
		$this->precio = $precio;
	}

	public function setCedula($cedula)
	{
		if (!preg_match("/^([1-9]{1})([0-9]{6,7})$/", $cedula)) {
			throw new \InvalidArgumentException("La cédula debe contener entre 7 y 8 dígitos.");
		}
		$this->cedula = $cedula;
	}

	public function setIdCliente($id_cliente)
	{
		if (!preg_match("/^[0-9]+$/", $id_cliente)) {
			throw new \InvalidArgumentException("El ID del cliente debe ser un número entero positivo.");
		}
		$this->id_cliente = (int)$id_cliente;
	}

	public function setIdPaciente($id_paciente)
	{
		if (!preg_match("/^[0-9]+$/", $id_paciente)) {
			throw new \InvalidArgumentException("El ID del paciente debe ser un número entero positivo.");
		}
		$this->id_paciente = (int)$id_paciente;
	}

	public function setIdCita($id_cita)
	{
		$this->id_cita = $id_cita;
	}

	public function setIdH($idH)
	{
		$this->idH = (int)$idH;
	}
}
