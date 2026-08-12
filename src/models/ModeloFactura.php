<?php

namespace App\models;

use App\models\ModelBase;
use App\models\Db;
use App\models\Validator;
use App\models\interfaces\InterfaceConnection;
use App\models\interfaces\InterfaceValidator;
use App\models\TraitCreate;
use App\models\TraitUpdate;

class ModeloFactura extends ModelBase
{
	private $id_factura, $fecha, $total, $formasDePago, $servicios, $insumos,
		$precioInsumo, $cantidad, $montosDePago, $referencia, $precioServicio,
		$doctor, $cedula, $id_cliente, $id_paciente, $id_cita, $idH, $idInsumo, $precio;
	private $validator;

	use TraitCreate, TraitUpdate;

	public function __construct(InterfaceConnection $conn, InterfaceValidator $vali)
	{
		parent::__construct($conn);
		$this->validator = $vali;
	}

	// ── READ────────────────────

	// public function buscarPacientePorCita()
	// {
	// 	try {
	// 		$data = ['cedula' => $this->getCedula()];
	// 		$sql  = "SELECT c.doctor as id_doctor_c, cs.nombre AS categoria,
	//                         d.nombre AS nombre_d, d.apellido AS apellido_d, sm.*,
	//                         p.id_paciente, p.cedula AS cedula_p, p.nombre AS nombre_p,
	//                         p.apellido AS apellido_p, p.telefono AS telefono_p,
	//                         c.id_cita, c.fecha, c.estado, e.nombre AS especialidad,
	//                         p.fn as fecha_de_nacimiento
	//                 FROM paciente p
	//                 INNER JOIN cita c             ON p.id_paciente = c.paciente_id_paciente
	//                 INNER JOIN serviciomedico s   ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico
	//                 INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = s.id_servicioMedico
	//                 INNER JOIN personal d         ON d.id_personal = ps.personal_id_personal
	//                 INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario
	//                 INNER JOIN serviciomedico sm  ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico
	//                 INNER JOIN especialidad e     ON e.id_especialidad = d.id_especialidad
	//                 INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria
	//                 WHERE p.cedula = :cedula
	//                 	AND u.estado = 'ACT'
	//                 	AND c.fecha = CURRENT_DATE
	//                 	AND c.estado = 'Pendiente'
	//                 LIMIT 1";
	// 		$this->setSQL($sql);
	// 		return $this->search($data);
	// 	} catch (\Exception $e) {
	// 		return $e->getMessage();
	// 	}
	// }

	// public function mostrarCitaFactura()
	// {
	// 	try {
	// 		$data = ['id_cita' => $this->getIdCita()];
	// 		$sql  = "SELECT c.doctor, d.nombre AS nombre_d, d.apellido AS apellido_d,
	//                         s.*, p.id_paciente, p.nacionalidad,
	//                         p.cedula AS cedula_p, p.nombre AS nombre_p,
	//                         p.apellido AS apellido_p, p.telefono AS telefono_p,
	//                         c.id_cita, c.fecha, c.estado, e.nombre AS especialidad
	//                 FROM paciente p
	//                 INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente
	//                 INNER JOIN serviciomedico s ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico
	//                 INNER JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = s.id_servicioMedico
	//                 INNER JOIN personal d         ON psm.personal_id_personal = d.id_personal
	//                 INNER JOIN especialidad e     ON d.id_especialidad = e.id_especialidad
	//                 INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario
	//                 WHERE c.id_cita = :id_cita AND u.estado = 'ACT'
	//                 LIMIT 1";
	// 		$this->setSQL($sql);
	// 		return $this->search($data);
	// 	} catch (\Exception $e) {
	// 		return $e->getMessage();
	// 	}
	// }

	// public function mostrarHospitalizacion()
	// {
	// 	try {
	// 		$data = ['id_hospitalizacion' => $this->getIdH()];
	// 		$sql  = "SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas,
	//                         h.fecha_hora_final, h.total_MoEx, h.total,
	//                         pac.id_paciente, pac.nacionalidad, pac.cedula,
	//                         pac.nombre, pac.apellido,
	//                         pe.nombre AS nombredoc, pe.apellido AS apellidodoc, pac.fn
	//                 FROM hospitalizacion h
	//                 INNER JOIN paciente pac ON pac.id_paciente = h.id_paciente
	//                 INNER JOIN personal pe  ON pe.id_personal  = h.personal_id_personal
	//                 WHERE h.id_hospitalizacion = :id_hospitalizacion
	//                 GROUP BY h.id_hospitalizacion";
	// 		$this->setSQL($sql);
	// 		return $this->search($data);
	// 	} catch (\Exception $e) {
	// 		return $e->getMessage();
	// 	}
	// }

	// public function serviciosIncluidosHospit()
	// {
	// 	try {
	// 		$data = ['id_hospitalizacion' => $this->getIdH()];
	// 		$sql  = 'SELECT h.id_hospitalizacion, s.id_servicioMedico,
	//                         p.id_personal as id_doctor, p.nombre as nombre_d,
	//                         p.apellido as apellido_d, cs.nombre as categoria,
	//                         s.precio as precios_servicio
	//                 FROM hospitalizacion h
	//                 INNER JOIN servicios_hospitalizacion sh ON sh.id_hospitalizacion = h.id_hospitalizacion
	//                 INNER JOIN serviciomedico s  ON s.id_servicioMedico = sh.id_servicioMedico
	//                 INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria
	//                 INNER JOIN personal_has_serviciomedico ps ON s.id_servicioMedico = ps.serviciomedico_id_servicioMedico
	//                 INNER JOIN personal p ON p.id_personal = ps.personal_id_personal
	//                 WHERE h.id_hospitalizacion = :id_hospitalizacion
	//                 GROUP BY h.id_hospitalizacion';
	// 		$this->setSQL($sql);
	// 		return $this->search($data);
	// 	} catch (\Exception $e) {
	// 		return $e->getMessage();
	// 	}
	// }

	// public function unirInsumosHospitalizacion()
	// {
	// 	try {
	// 		$data = ['id_hospitalizacion' => $this->getIdH()];
	// 		$sql  = 'SELECT ei.id_entradaDeInsumo, h.id_hospitalizacion,
	//                         i.nombre, i.medida, i.precio, i.iva, ih.cantidad
	//                 FROM hospitalizacion h
	//                 INNER JOIN insumodehospitalizacion ih ON h.id_hospitalizacion = ih.id_hospitalizacion
	//                 INNER JOIN entrada_insumo ei ON ei.id_entradaDeInsumo = ih.id_entradaDeInsumo
	//                 INNER JOIN insumo i ON i.id_insumo = ei.id_insumo
	//                 WHERE i.estado = "ACT"
	//                     AND h.estado = "Pendiente"
	//                     AND h.id_hospitalizacion = :id_hospitalizacion';
	// 		$this->setSQL($sql);
	// 		return $this->search($data);
	// 	} catch (\Exception $e) {
	// 		return $e->getMessage();
	// 	}
	// }

	// public function buscar()
	// {
	// 	try {
	// 		$data = ['cedula' => $this->getCedula(), 'estado' => 'ACT'];
	// 		$sql  = 'SELECT * FROM paciente WHERE cedula = :cedula AND estado = :estado';
	// 		$this->setSQL($sql);
	// 		return $this->search($data);
	// 	} catch (\Exception $e) {
	// 		return $e->getMessage();
	// 	}
	// }


	// public function mostrarServicios()
	// {
	// 	try {
	// 		$sql = "SELECT cs.id_categoria, cs.nombre as categoria, d.nombre AS nombre_d, d.apellido AS apellido_d, sm.*, d.*
	//                 FROM bd.categoria_servicio cs
	//                 JOIN bd.serviciomedico sm ON sm.id_categoria = cs.id_categoria
	//                 JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico
	//                 JOIN bd.personal d    ON psm.personal_id_personal = d.id_personal
	//                 JOIN segurity.usuario u ON u.id_usuario = d.usuario
	//                 WHERE sm.estado = 'ACT'
	//                     AND cs.nombre != 'Consulta'
	//                     AND tipo != 'Cita'";
	// 		$this->setSQL($sql);
	// 		return $this->read();
	// 	} catch (\Exception $e) {
	// 		return $e->getMessage();
	// 	}
	// }

	public function mostrarTiposDePagos()
	{
		$this->set_tables(["pago"]);
		$this->set_colums(['id_pago', 'nombre']);
		return $this->read();
	}

	public function consultarFactura()
	{
		$coditions = [
			'condiciones' => ['id_factura' => $this->getIdFactura()],
			'conectores' => [],
			'operadores' => ['=']
		];

		$this->set_tables(["view_factura"]);
		$this->set_colums(['id_factura', 'fecha', 'total', 'id_cliente', 'nombre_p', 'apellido_p', 'nacionalidad', 'cedula_p']);
		$this->set_condicion_aditional($coditions);
		return $this->read();
	}

	public function consultarPagoFactura()
	{
		$coditions = [
			'condiciones' => ['f.id_factura' => $this->getIdFactura()],
			'conectores' => [],
			'operadores' => ['=']
		];
		$alias = ['p', 'pf', 'f'];
		$unions = ['p.id_pago = pf.id_pago', 'pf.id_factura = f.id_factura'];

		$this->set_tables(["pago", "pagodefactura", "factura"]);
		$this->set_colums(['pf.monto', 'pf.referencia', 'p.nombre']);
		$this->set_condicion_aditional($coditions);
		$this->set_alias($alias);
		$this->set_union($unions);

		return $this->read();
	}


	public function consultarFacturaSinCita()
	{
		$coditions = [
			'condiciones' => ['f.id_factura' => $this->getIdFactura()],
			'conectores' => [],
			'operadores' => ['=']
		];
		$alias = ['f', 'p'];
		$unions = ['p.id_cliente = f.id_cliente'];

		$this->set_tables(["factura", "cliente"]);
		$this->set_colums([
			'f.id_factura',
			'f.fecha',
			'f.total',
			'f.id_cliente',
			'p.nombre AS nombre_p',
			'p.apellido AS apellido_p',
			'nacionalidad',
			'p.cedula AS cedula_p'
		]);
		$this->set_condicion_aditional($coditions);
		$this->set_alias($alias);
		$this->set_union($unions);

		return $this->read();
	}

	public function consultarFacturaInsumo()
	{

		$coditions = [
			'condiciones' => ['f.id_factura' => $this->getIdFactura()],
			'conectores' => [],
			'operadores' => ['=']
		];
		$alias = ['i', 'fi', 'f', 'ins'];
		$unions = [' i.id_entradaDeInsumo = fi.entrada_insumo_id_entradaDeInsumo', 'f.id_factura = fi.id_factura', 'ins.id_insumo = i.id_insumo'];

		$this->set_tables(["entrada_insumo", "detalle_factura", "factura", "insumo"]);
		$this->set_colums([
			'i.*',
			'fi.*',
			'f.*',
			'ins.nombre',
			'ins.precio',
			'ins.iva'
		]);
		$this->set_condicion_aditional($coditions);
		$this->set_alias($alias);
		$this->set_union($unions);

		return $this->read();
	}

	// public function selectsFacturaHosp()
	// {
	// 	$data = ['idH' => $this->getIdH()];
	// 	$sql = 'SELECT h.id_hospitalizacion, h.duracion, h.precio_horas, h.total,
	//                         con.id_control, con.diagnostico, h.historiaclinica,
	//                         pac.nacionalidad, pac.id_paciente, pac.cedula,
	//                         pac.nombre, pac.apellido, u.id_usuario,
	//                         doc.nombre AS nombredoc, doc.apellido AS apellidodoc
	//                 FROM hospitalizacion h
	//                 INNER JOIN control con ON h.id_control = con.id_control
	//                 INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente
	//                 INNER JOIN usuario u   ON con.id_usuario = u.id_usuario
	//                 INNER JOIN personal doc ON doc.id_usuario = u.id_usuario
	//                 INNER JOIN serviciomedico sm ON sm.id_personal = doc.id_personal
	//                 WHERE con.estado = "ACT"
	//                     AND sm.estado = "ACT"
	//                     AND u.estado = "ACT"
	//                     AND h.estado = "Pendiente"
	//                     AND h.id_hospitalizacion = :idH
	//                 GROUP BY h.id_hospitalizacion';
	// 	$this->setSQL($sql);
	// 	return $this->search($data);
	// }

	// public function selectInsumosHosp()
	// {
	// 	$data = ['idH' => $this->getIdH()];
	// 	$sql = 'SELECT i.*, ih.cantidad AS cantidad_insumo_hospit
	//                 FROM insumodehospitalizacion ih
	//                 INNER JOIN insumo i ON i.id_insumo = ih.id_insumo
	//                 WHERE ih.id_hospitalizacion = :idH';
	// 	$this->setSQL($sql);
	// 	return $this->search($data);
	// }

	public function consultarFacturaHosp()
	{
		$coditions = [
			'condiciones' => ['f.id_factura' => $this->getIdFactura()],
			'conectores' => [],
			'operadores' => ['=']
		];
		$alias = ['h', 'f', 'c', 'u', 'd', 'p'];
		$unions = [' f.id_hospitalizacion = h.id_hospitalizacion', 'h.id_control = c.id_control', 'u.id_usuario = c.id_usuario', 'd.id_usuario = u.id_usuario', 'c.id_paciente = p.id_paciente'];

		$this->set_tables(["hospitalizacion", "factura", "control", "usuario", "personal", 'paciente']);
		$this->set_colums([
			'*',
			'f.fecha',
			'f.total',
			'f.id_factura',
			'p.nombre AS nombre_paciente',
			'p.apellido AS apellido_paciente',
			'p.cedula AS cedula_paciente',
			'p.nacionalidad',
			'd.nombre AS nombre_d',
			'd.apellido AS apellido_d'
		]);
		$this->set_condicion_aditional($coditions);
		$this->set_alias($alias);
		$this->set_union($unions);
		return $this->read();
	}

	public function consultarFacturaHospSer()
	{
		$coditions = [
			'condiciones' => ['id_factura' => $this->getIdFactura()],
			'conectores' => [],
			'operadores' => ['=']
		];
		$alias = ['f', 'h', 'c', 'p', 'u'];
		$unions = ['h.id_hospitalizacion = f.id_hospitalizacion', 'c.id_control = h.id_control', 'p.id_paciente = c.id_paciente', 'u.id_usuario = c.id_usuario'];

		$this->set_tables(["factura", "hospitalizacion", "control", "paciente", "usuario"]);
		$this->set_colums([
			'f.*',
			' h.*',
			'p.*',
			'u.nombre AS nombre_d',
			'u.apellido AS apellido_d'
		]);
		$this->set_condicion_aditional($coditions);
		$this->set_alias($alias);
		$this->set_union($unions);
		return $this->read();
	}


	public function comprobarSiFueHospit()
	{
		$coditions = [
			'condiciones' => ['f.id_factura' => $this->getIdFactura(), 'df.tipo' => "Hospitalizacion"],
			'conectores' => ['AND'],
			'operadores' => ['=', '=']
		];
		$alias = ['f', 'df'];
		$unions = ['df.id_factura = f.id_factura'];

		$this->set_tables(["factura", "detalle_factura"]);
		$this->set_colums([
			'df.hospitalizacion_id_hospitalizacion'
		]);
		$this->set_condicion_aditional($coditions);
		$this->set_alias($alias);
		$this->set_union($unions);

		$data = $this->read(false);
		return $data ? $data['hospitalizacion_id_hospitalizacion'] : 0;
	}

	// ── PRIVADOS──────────────────────────────────

	private function selectId_entrada($id_insumo)
	{

		$coditions = [
			'condiciones' => ['ei.id_insumo' => $id_insumo, 'ei.cantidad_disponible' => 0],
			'conectores' => ['AND'],
			'operadores' => ['=', '>']
		];
		$alias = ['f', 'df'];
		$unions = ['e.id_entrada = ei.id_entrada'];

		$this->set_tables(["factura", "detalle_factura"]);
		$this->set_colums([
			'df.hospitalizacion_id_hospitalizacion'
		]);
		$this->set_condicion_aditional($coditions);
		$this->set_alias($alias);
		$this->set_union($unions);
		$this->set_orden_column('e.fechaDeIngreso');
		$this->set_orden_dir('ASC');
		$this->set_limit(1);
		$this->set_start(0);
		$datos = $this->read(false);
		return $datos["id_entradaDeInsumo"];
	}

	public function guardarFactura()
	{
		// Definimos una bandera para saber si la transacción realmente se inició
		$transaccionActiva = false;
		try {


			$this->beginTransaction();
			$transaccionActiva = true; // Marcamos que la transacción está abierta


			//validar que el cliente exista; con interface
			// $this->setSQL("SELECT * FROM cliente WHERE id_cliente = :id_cliente");
			// if ($this->search(['id_cliente' => $this->getIdCliente()], false) == []) {
			// 	throw new \Exception("El id del cliente no existe.");
			// }
			$data = [
				'fecha'      => $this->getFecha(),
				'total'      => $this->getTotal(),
				'estado'     => 'ACT',
				'id_cliente' => $this->getIdCliente()
			];
			$this->set_tables(['factura']);
			$id_factura = $this->guardar($data, $this->validator);
			$id_factura = $id_factura[0];


			if (!empty($this->getIdCita())) {
				$coditions = [
					'condiciones' => ['id_cita' => $this->getIdCita()],
					'conectores' => [],
					'operadores' => ['=']
				];
				// Bloqueo pesimista de fila seguro
				$this->set_tables(['cita']);
				$this->set_colums(['id_cita']);
				$this->set_condicion_aditional($coditions);
				$this->read(false, false, '', true);

				$this->actualizar(['estado' => 'Realizadas'], ['id_cita' => $this->getIdCita()], $this->validator);
			}

			// Cerrar hospitalización si aplica
			if (!empty($this->getIdH())) {
				$coditions = [
					'condiciones' => ['id_hospitalizacion' => $this->getIdH()],
					'conectores' => [],
					'operadores' => ['=']
				];
				// Bloqueo pesimista de fila seguro
				$this->set_tables(['hospitalizacion']);
				$this->set_colums(['id_hospitalizacion']);
				$this->set_condicion_aditional($coditions);
				$this->read(false, false, '', true);

				$this->actualizar(['estado' => 'Realizada'], ['id_hospitalizacion' => $this->getIdH()], $this->validator);

				$data = [
					'id_factura' => $id_factura,
					'tipo' => 'Hospitalizacion',
					'cantidad' => 1,
					'precioServIndividual' => $this->getTotal(),
					'precioServCompleto' => $this->getTotal(),
					'id_hospitalizacion' => $this->getIdH(),
					'id_servicio' => null,
					'id_entrada' => null
				];
				$this->set_tables(['detalle_factura']);
				$this->guardar($data, $this->validator);

				// Actualizar historial clínico del último control
				$coditions = [
					'condiciones' => ['h.id_hospitalizacion ' => $this->getIdH()],
					'conectores' => [],
					'operadores' => ['=']
				];
				$alias = [
					'con',
					'h'
				];
				$unions = [
					'h.id_paciente = con.id_paciente'
				];
				$this->set_tables(["control", "hospitalizacion"]);
				$this->set_colums(['con.id_control', 'con.id_paciente', 'con.historiaclinica']);
				$this->set_condicion_aditional($coditions);
				$this->set_alias($alias);
				$this->set_union($unions);
				$this->set_limit(1);
				$this->set_orden_column('con.id_control');
				$this->set_orden_dir('DESC');
				$this->set_start(0);

				$datosControl = $this->read(false);
				$historialEnF = $datosControl["historiaclinica"];

				$alias = [
					'sh',
					'sm',
					'cs'
				];
				$unions = [
					'sm.id_servicioMedico = sh.id_servicioMedico',
					'cs.id_categoria = sm.id_categoria'
				];
				$coditions = [
					'condiciones' => ['sh.id_hospitalizacion ' => $this->getIdH()],
					'conectores' => [],
					'operadores' => ['=']
				];
				$this->set_tables(["servicios_hospitalizacion", "serviciomedico", "categoria_servicio"]);
				$this->set_colums(['cs.nombre AS servicio', 'sh.cantidad', 'sm.tipo']);

				$servicios = $this->read();

				if ($servicios) {
					$lista = [];
					foreach ($servicios as $serv) {
						$lista[] = strtolower($serv["tipo"]) === "examenes"
							? "{$serv["servicio"]} ({$serv["cantidad"]} unidades)"
							: $serv["servicio"];
					}
					$historialEnF = "Servicios utilizados: " . implode(", ", $lista) . ". El paciente: " . $historialEnF;
				}
				$data = ['historial' => $historialEnF, 'estado' => 'ACT'];
				$this->set_tables(['control']);
				$this->actualizar($data,['id_control'=> $datosControl["id_control"]],$this->validator);
			}

			// Insertar formas de pago
			$contador = 0;
			foreach ($this->getFormasDePago() as $id_pago) {
				$data= [
					'id_pago' => $id_pago,
					'id_factura' => $id_factura,
					'referencia' => $this->getReferencia(),
					'montosDePago' => $this->getMontosPagos()[$contador]
				];
				$this->set_tables(['pagodefactura']);
				$this->guardar($data,$this->validator);
				$contador++;
			}

			// Insertar servicios extras
			if ($this->getServicios()) {
				$contador = 0;
				foreach ($this->getServicios() as $s) {
					$data= [
						'id_factura' => $id_factura,
						'tipo' => 'Servicio',
						'cantidad' => 1,
						'precioUnitario' => $this->getPrecioServicio()[$contador],
						'precioServicio' => $this->getPrecioServicio()[$contador],
						'idH' => null,
						's' => $s,
						'idInsumo' => null
					];
					$this->set_tables(['detalle_factura']);
					$this->guardar($data,$this->validator);
					$contador++;
				}
			}

			// Insertar insumos (solo si no es hospitalización)
			if ($this->getInsumos() && $this->getIdH() == 0) {
				$contador = 0;
				foreach ($this->getInsumos() as $i) {
					$id_entrada = $this->selectId_entrada($i);

					// Bloqueo de fila exclusivo para los lotes del insumo actual
					$coditions = [
						'condiciones' => ['id_insumo' => $i],
						'conectores' => [],
						'operadores' => ['=']
					];
					$this->set_tables(['entrada_insumo']);
					$this->set_colums(['id_entradaDeInsumo']);
					$this->set_condicion_aditional($coditions);

					$this->read(false,false,'',true);

					$this->set_tables(['detalle_factura']);
					$data = [
						'id_factura' => $id_factura,
						'tipo' => 'Insumo',
						'cantidad' => $this->getCantidad()[$contador],
						'precioInsumo' => $this->getPrecioInsumo()[$contador],
						'subtotal' => $this->getPrecioInsumo()[$contador] * $this->getCantidad()[$contador],
						'hospitalizacion_id_hospitalizacion' => null,
						'serviciomedico_id_servicioMedico' => null,
						'entrada_insumo_id_entradaDeInsumo' => $id_entrada
					];
					$this->callStoredProdcedure('DescontarLotes',$data);
					$contador++;
				}
			}

			//confitmar
			$this->commit();
			return [$id_factura];
		} catch (\Exception $e) {
			// rollback si algo fallo
			if ($transaccionActiva) {
				$this->rollBack();
			}
			//error
			return $e->getMessage();
		}
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