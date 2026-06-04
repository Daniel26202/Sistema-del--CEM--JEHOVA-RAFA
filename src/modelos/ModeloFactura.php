<?php

namespace App\modelos;

use App\modelos\ModelBase;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloCliente;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloCita;
use App\modelos\ModeloHospitalizacion;
use App\modelos\ModeloServicios;
use App\config\RateLimiter;

class ModeloFactura extends ModelBase
{
	private $id_factura, $fecha, $total, $formasDePago, $servicios, $insumos,
		$precioInsumo, $cantidad, $montosDePago, $referencia, $precioServicio,
		$doctor, $cedula, $id_cliente, $id_paciente, $id_cita, $idH, $idInsumo, $precio;

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
                            i.nombre, i.medida, i.precio, i.iva, ih.cantidad
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
			$sql = "SELECT cs.nombre As categoria_servicio, sf.*, s.*,
                            p.nombre AS nombre_d, p.apellido AS apellido_d
                    FROM detalle_factura sf
                    INNER JOIN serviciomedico s ON s.id_servicioMedico = sf.serviciomedico_id_servicioMedico
                    INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria
                    INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = s.id_servicioMedico
                    INNER JOIN personal p ON p.id_personal = ps.personal_id_personal
                    WHERE id_factura = :id_factura
                    LIMIT 1";
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
			$sql  = "SELECT i.*, fi.*, f.*, ins.nombre, ins.precio, ins.iva
                    FROM entrada_insumo i
                    INNER JOIN detalle_factura fi ON i.id_entradaDeInsumo = fi.entrada_insumo_id_entradaDeInsumo
                    INNER JOIN factura f ON f.id_factura = fi.id_factura
                    INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo
                    WHERE f.id_factura = :id_factura";
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

	private function selectId_entrada($id_insumo)
	{
		try {
			$data = ['id_insumo' => $id_insumo];
			$sql = "SELECT ei.id_entradaDeInsumo
                    FROM entrada_insumo ei
                    INNER JOIN entrada e ON e.id_entrada = ei.id_entrada
                    WHERE ei.id_insumo = :id_insumo AND ei.cantidad_disponible > 0
                    ORDER BY e.fechaDeIngreso LIMIT 1";
			$this->setSQL($sql);
			$datos = $this->search($data, false);
			return $datos["id_entradaDeInsumo"];
		} catch (\Exception $e) {
			return 0;
		}
	}

	private function insertar()
	{
		// Definimos una bandera para saber si la transacción realmente se inició
		$transaccionActiva = false;
		try {


			$this->beginTransaction();
			$transaccionActiva = true; // Marcamos que la transacción está abierta

			
			$this->setSQL("SELECT * FROM cliente WHERE id_cliente = :id_cliente");
			if ($this->search(['id_cliente' => $this->getIdCliente()], false) == []) {
				throw new \Exception("El id del cliente no existe.");
			}

		
			$this->setSQL("INSERT INTO factura VALUES (null, :fecha, :total, :estado, :id_cliente)");
			$id_factura = $this->create([
				'fecha'      => $this->getFecha(),
				'total'      => $this->getTotal(),
				'estado'     => 'ACT',
				'id_cliente' => $this->getIdCliente()
			]);

			
			if ($this->getIdCita() != null) {
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

				$this->setSQL("INSERT INTO detalle_factura VALUES (null,:id_factura,:tipo,:cantidad,:precioServIndividual,:precioServCompleto,:id_hospitalizacion,:id_servicio,:id_entrada)");
				$this->create([
					'id_factura' => $id_factura,
					'tipo' => 'Hospitalizacion',
					'cantidad' => 1,
					'precioServIndividual' => $this->getTotal(),
					'precioServCompleto' => $this->getTotal(),
					'id_hospitalizacion' => $this->getIdH(),
					'id_servicio' => null,
					'id_entrada' => null
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
				$this->setSQL("INSERT INTO pagodefactura VALUES (null, :id_pago, :id_factura, :referencia, :montosDePago)");
				$this->create([
					'id_pago' => $id_pago,
					'id_factura' => $id_factura,
					'referencia' => $this->getReferencia(),
					'montosDePago' => $this->getMontosPagos()[$contador]
				]);
				$contador++;
			}

			// Insertar servicios extras
			if ($this->getServicios()) {
				$contador = 0;
				foreach ($this->getServicios() as $s) {
					$this->setSQL("INSERT INTO detalle_factura VALUES (null,:id_factura,:tipo,:cantidad,:precioUnitario,:precioServicio,:idH,:s,:idInsumo)");
					$this->create([
						'id_factura' => $id_factura,
						'tipo' => 'Servicio',
						'cantidad' => 1,
						'precioUnitario' => $this->getPrecioServicio()[$contador],
						'precioServicio' => $this->getPrecioServicio()[$contador],
						'idH' => null,
						's' => $s,
						'idInsumo' => null
					]);
					$contador++;
				}
			}

			// Insertar insumos (solo si no es hospitalización)
			if ($this->getInsumos() && $this->getIdH() == 0) {
				$contador = 0;
				foreach ($this->getInsumos() as $i) {
					$id_entrada = $this->selectId_entrada($i);

					// Bloqueo de fila exclusivo para los lotes del insumo actual
					$this->setSQL("SELECT id_entradaDeInsumo FROM entrada_insumo WHERE id_insumo = :insumo FOR UPDATE");
					$this->search(['insumo' => $i]);

					$this->setSQL("INSERT INTO detalle_factura VALUES (null,:id_factura,:tipo,:cantidad,:precioInsumo,:subtotal,null,null,:i)");
					$this->create([
						'id_factura' => $id_factura,
						'tipo' => 'Insumo',
						'cantidad' => $this->getCantidad()[$contador],
						'precioInsumo' => $this->getPrecioInsumo()[$contador],
						'subtotal' => $this->getPrecioInsumo()[$contador] * $this->getCantidad()[$contador],
						'i' => $id_entrada
					]);

					$this->setSQL("CALL DescontarLotes(:i, :cantidad)");
					$this->storedProcedure(['i' => $i, 'cantidad' => $this->getCantidad()[$contador]]);

					$contador++;
				}
			}

			//confitmar
			$this->commit();
			return [$id_factura, "exito", $this->getInsumos()];
		} catch (\Exception $e) {
			// rollback si algo fallo
			if ($transaccionActiva) {
				$this->rollBack();
			}
			//error
			return $e->getMessage();
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

		(new RateLimiter())->verificar('guardar_factura_' . $idUsuario, 5, 1);

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
		if (!preg_match("/^[0-9]+$/", $referencia)) {
			throw new \InvalidArgumentException("La referencia debe ser numérica.");
		}
		$this->referencia = $referencia;
	}

	public function setMontosPago($montosDePago = [])
	{
		if (!is_array($montosDePago)) {
			throw new \InvalidArgumentException("Los montos de pago deben ser un arreglo.");
		}
		$this->montosDePago = $montosDePago;
	}

	public function setInsumos($insumos = [])
	{
		if (!is_array($insumos)) {
			throw new \InvalidArgumentException("Los insumos deben ser un arreglo.");
		}
		$this->insumos = $insumos;
	}

	public function setServicios($servicios = [])
	{
		if (!is_array($servicios)) {
			throw new \InvalidArgumentException("Los servicios deben ser un arreglo.");
		}
		$this->servicios = $servicios;
	}

	public function setCatidad($cantidad = [])
	{
		if (!is_array($cantidad)) {
			throw new \InvalidArgumentException("La cantidad debe ser un arreglo.");
		}
		$this->cantidad = $cantidad;
	}

	public function setPrecioInsumo($precioInsumo = [])
	{
		if (!is_array($precioInsumo)) {
			throw new \InvalidArgumentException("Los precios de insumo deben ser un arreglo.");
		}
		$this->precioInsumo = $precioInsumo;
	}

	public function setPrecioServicio($precioServicio = [])
	{
		if (!is_array($precioServicio)) {
			throw new \InvalidArgumentException("Los precios de servicio deben ser un arreglo.");
		}
		$this->precioServicio = $precioServicio;
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
