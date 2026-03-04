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

	private $id_factura, $fecha, $total, $formasDePago, $servicios, $insumos, $precioInsumo,  $cantidad, $montosDePago, $referencia, $precioServicio, $doctor, $cedula, $id_cliente, $id_paciente, $id_cita, $idH, $idInsumo;

	public function __construct($dbSystem = true)
	{
		parent::__construct($dbSystem);
	}

	private function returnObjectModel()
	{
		return [
			'modeloPacientes' => new ModeloPacientes(),
			'modeloCliente' => new ModeloCliente(),
			'modeloInsumo' => new ModeloInsumo(),
			'modeloCita' => new ModeloCita(),
			'modeloHospitalizacion' => new  ModeloHospitalizacion(),
			'modeloServicios' => new ModeloServicios()
		];
	}
	//buscar Paciente tambien por la cita
	public function buscarPacientePorCita()
	{
		try {
			$data = [
				'cedula' => $this->getCedula()
			];
			$sql = "SELECT c.doctor as id_doctor_c, cs.nombre AS categoria,d.nombre AS nombre_d,d.apellido AS apellido_d,sm.*,p.id_paciente, p.cedula AS cedula_p,p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p ,c.id_cita,c.fecha, c.estado,e.nombre AS especialidad , p.fn as fecha_de_nacimiento FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = s.id_servicioMedico INNER JOIN  personal d ON d.id_personal= ps.personal_id_personal INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario INNER JOIN serviciomedico sm ON c.serviciomedico_id_servicioMedico = sm.id_servicioMedico INNER JOIN especialidad e ON e.id_especialidad = d.id_especialidad INNER JOIN categoria_servicio cs ON cs.id_categoria =sm.id_categoria  WHERE p.cedula =:cedula AND u.estado = 'ACT' AND c.fecha =CURRENT_DATE AND c.estado= 'Pendiente' limit 1 ";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}




	public function mostrarCitaFactura()
	{
		try {
			$data = [
				'id_cita' => $this->returnObjectModel()['modeloCita']->getIdCita()
			];
			$sql = "SELECT c.doctor,d.nombre AS nombre_d,d.apellido AS apellido_d,s.*,p.id_paciente,p.nacionalidad, p.cedula AS cedula_p,p.nombre AS nombre_p, p.apellido AS apellido_p, p.telefono AS telefono_p ,c.id_cita,c.fecha, c.estado,e.nombre AS especialidad FROM paciente p INNER JOIN cita c ON p.id_paciente = c.paciente_id_paciente INNER JOIN serviciomedico s ON s.id_servicioMedico  = c.serviciomedico_id_servicioMedico INNER JOIN personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = s.id_servicioMedico INNER JOIN personal d ON psm.personal_id_personal = d.id_personal INNER JOIN especialidad e ON d.id_especialidad = e.id_especialidad INNER JOIN segurity.usuario u ON u.id_usuario = d.usuario WHERE c.id_cita =:id_cita AND u.estado = 'ACT' limit 1  ";
			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarHospitalizacion()
	{

		try {
			$data = [
				'id_hospitalizacion' => $this->getIdH()
			];

			$sql = "SELECT h.id_hospitalizacion, h.fecha_hora_inicio, h.precio_horas, h.fecha_hora_final, h.total_MoEx, h.total, pac.id_paciente, pac.nacionalidad, pac.cedula, pac.nombre, pac.apellido,  pe.nombre AS nombredoc, pe.apellido AS apellidodoc, pac.fn 
						FROM  hospitalizacion h INNER JOIN paciente pac ON pac.id_paciente = h.id_paciente INNER JOIN personal pe ON pe.id_personal = h.personal_id_personal  WHERE  h.id_hospitalizacion =:id_hospitalizacion GROUP BY h.id_hospitalizacion ";

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function serviciosIncluidosHospit()
	{

		try {
			$data = [
				'id_hospitalizacion' => $this->getIdH()
			];

			$sql = 'SELECT  h.id_hospitalizacion,s.id_servicioMedico,p.id_personal as id_doctor,p.nombre as nombre_d, p.apellido as apellido_d,cs.nombre as categoria, s.precio as precios_servicio FROM hospitalizacion h INNER JOIN servicios_hospitalizacion sh ON sh.id_hospitalizacion = h.id_hospitalizacion INNER JOIN serviciomedico s ON s.id_servicioMedico = sh.id_servicioMedico INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria INNER JOIN personal_has_serviciomedico  ps ON s.id_servicioMedico =ps.serviciomedico_id_servicioMedico INNER JOIN personal p ON p.id_personal=ps.personal_id_personal WHERE  h.id_hospitalizacion =:id_hospitalizacion GROUP BY h.id_hospitalizacion';

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function unirInsumosHospitalizacion()
	{
		try {
			$data = [
				'id_hospitalizacion' => $this->getIdH()
			];

			$sql = 'SELECT  ei.id_entradaDeInsumo,h.id_hospitalizacion, i.nombre, i.medida, i.precio, i.iva, ih.cantidad FROM hospitalizacion h INNER JOIN insumodehospitalizacion ih ON h.id_hospitalizacion = ih.id_hospitalizacion INNER JOIN entrada_insumo ei ON ei.id_entradaDeInsumo = ih.id_entradaDeInsumo INNER JOIN insumo i ON i.id_insumo = ei.id_insumo   WHERE   i.estado = "ACT" AND h.estado = "Pendiente" AND h.id_hospitalizacion =:id_hospitalizacion';

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function buscar()
	{
		try {
			$data = [
				'cedula' => $this->getCedula(),
				'estado' => 'ACT'
			];

			$sql = 'SELECT * FROM paciente WHERE cedula =:cedula AND estado = :estado';

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function buscarCliente()
	{
		try {
			$data = [
				'cedula' => $this->getCedula(),
				'estado' => 'ACT'
			];

			$sql = 'SELECT * FROM cliente WHERE cedula =:cedula AND estado = :estado';

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostrarServicios()
	{
		try {
			$sql = "SELECT cs.id_categoria,cs.nombre as categoria, d.nombre AS nombre_d, d.apellido AS apellido_d,sm.*,d.*  FROM bd.categoria_servicio cs JOIN bd.serviciomedico sm ON sm.id_categoria = cs.id_categoria JOIN bd.personal_has_serviciomedico psm ON psm.serviciomedico_id_servicioMedico = sm.id_servicioMedico JOIN bd.personal d ON psm.personal_id_personal = d.id_personal JOIN segurity.usuario u ON  u.id_usuario = d.usuario WHERE sm.estado = 'ACT' AND cs.nombre != 'Consulta' AND tipo != 'Cita'";
			$this->setSQL($sql);
			return $this->read();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



	public function selectTodosLosInsumos()
	{
		return $this->returnObjectModel()['modeloInsumo']->insumos(false);
	}

	//metodo para mostra los tipos de pagos registrados en la base de Datos
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



	private  function selectId_entrada($id_insumo)
	{
		try {
			$data = ['id_insumo' => $id_insumo];
			$sql = "SELECT ei.id_entradaDeInsumo FROM entrada_insumo ei INNER JOIN entrada e ON e.id_entrada= ei.id_entrada WHERE ei.id_insumo =:id_insumo AND ei.cantidad_disponible > 0 ORDER BY e.fechaDeIngreso  LIMIT 1";
			$this->setSQL($sql);
			$datos = $this->search($data, false);
			$id_entrada = $datos["id_entradaDeInsumo"];
			return $id_entrada;
		} catch (\Exception $e) {
			return 0;
		}
	}


	public function insertaFactura()
	{

		try {
			$sql = "SELECT * from cliente where id_cliente=:id_cliente";
			$this->setSQL($sql);
			$data1 = [
				'id_cliente' => $this->getIdCliente()
			];
			$validar  = $this->search($data1, false);

			if ($validar == []) {
				throw new \Exception("El id del cliente no existe");
			}

			//insertar factura
			$sql = "INSERT INTO factura VALUES (null, :fecha, :total, :estado, :id_cliente)";
			$this->setSQL($sql);
			$data2 = [
				'fecha' => $this->getFecha(),
				'total' => $this->getTotal(),
				'estado' => 'ACT',
				'id_cliente' => $this->getIdCliente()
			];

			$id_factura = $this->create($data2);

			//Si el id_cita no es null se cambia el estado e la cita
			if ($this->getIdCita() != null) {
				$sql = "UPDATE cita SET estado = 'Realizadas' WHERE id_cita =:id";
				$this->setSQL($sql);

				$this->update_logic($this->getIdCita());
			}

			//Si el id_hospitalizacion no es null se cambia el estado e la cita
			if ($this->getIdH() != 0) {

				$sql = "UPDATE hospitalizacion SET estado = 'Realizada' WHERE id_hospitalizacion =:id";
				$this->setSQL($sql);

				$this->update_logic($this->getIdH());

				//insertar en el dealle de factura  la hospitalizacion
				// $sql = "INSERT INTO detalle_factura  VALUES (null,:id_factura, :tipo, :cantidad,:precioServIndividual, :precioServCompleto,:id_hospitalizacion,:id_servicio,:id_entrada)";
				// $this->setSQL($sql);
				// $data3 = [
				// 	'id_factura' => $id_factura,
				// 	'tipo' => 'Hospitalizacion',
				// 	'cantidad' => 1,
				// 	'precioServIndividual' => $this->returnObjectModel()['modeloServicios']->getPrecio(),
				// 	'precioServCompleto' => $this->returnObjectModel()['modeloServicios']->getPrecio(),
				// 	'id_hospitalizacion' => $this->returnObjectModel()['modeloHospitalizacion']->getIdH(),
				// 	'id_servicio' => null,
				// 	'id_entrada' => null
				// ];
				// $this->create($data3);

			// 	// consulta datos del ultimo contro del paciente hospitalizado
			// 	$sql = "SELECT con.id_control, con.id_paciente, con.historiaclinica FROM control con INNER JOIN hospitalizacion h ON h.id_paciente = con.id_paciente WHERE h.id_hospitalizacion = :idHosp ORDER by con.id_control DESC LIMIT 1";
			// 	$this->setSQL($sql);

			// 	$datosControl = $this->search(['idHosp' => $this->returnObjectModel()['modeloHospitalizacion']->getIdH()], false);

			// 	$historialEnF = $datosControl["historiaclinica"];


			// 	$sql = "SELECT cs.nombre AS servicio, sh.cantidad, sm.tipo FROM servicios_hospitalizacion sh INNER JOIN serviciomedico sm ON sm.id_servicioMedico = sh.id_servicioMedico INNER JOIN categoria_servicio cs ON cs.id_categoria = sm.id_categoria WHERE sh.id_hospitalizacion = :idHosp;";
			// 	$this->setSQL($sql);

			// 	$servicios = $this->search(['idHosp' => $this->returnObjectModel()['modeloHospitalizacion']->getIdH()]);


			// 	if ($servicios) {
			// 		$textoServicios = "Servicios utilizados: ";
			// 		$lista = [];
			// 		foreach ($servicios as $serv) {
			// 			// para convertir el text en minuscula
			// 			if (strtolower($serv["tipo"]) === "examenes") {
			// 				$lista[] = "{$serv["servicio"]} ({$serv["cantidad"]} unidades)";
			// 			} else {
			// 				$lista[] = $serv["servicio"];
			// 			}
			// 		}

			// 		$textoServicios .= implode(", ", $lista) . ".";

			// 		$historialEnF = $textoServicios . "   El paciente: " . $historialEnF;
			// 	}

			// 	$sql = 'UPDATE control SET historiaclinica = :historial, estado =:estado WHERE id_control = :id';

			// 	$data4 = [
			// 		'historial' => $historialEnF,
			// 		'estado' => 'ACT'
			// 	];
			// 	$this->setSQL($sql);
			// 	$this->update($data4, $datosControl["id_control"]);
			}

			// //insertar tipos de pago
			$contador = 0;

			foreach ($this->getFormasDePago() as $id_pago) {
				$sql = "INSERT INTO pagodefactura VALUES (null, :id_pago, :id_factura, :referencia, :montosDePago)";
				$data = [
					'id_pago' => $id_pago,
					'id_factura' => $id_factura,
					'referencia' => $this->getReferencia(),
					'montosDePago' => $this->getMontosPagos()[$contador],
				];
				$this->setSQL($sql);
				$this->create($data);
			}
			//insertar servicios extras
			if ($this->getServicios()) {
				$contador = 0;

				$data3 = [
					'id_factura' => $id_factura,
					'tipo' => 'Hospitalizacion',
					'cantidad' => 1,
					'precioServIndividual' => $this->returnObjectModel()['modeloServicios']->getPrecio(),
					'precioServCompleto' => $this->returnObjectModel()['modeloServicios']->getPrecio(),
					'id_hospitalizacion' => $this->returnObjectModel()['modeloHospitalizacion']->getIdH(),
					'id_servicio' => null,
					'id_entrada' => null
				];

				foreach ($this->getServicios() as $s) {
					$sql = "INSERT INTO detalle_factura  VALUES (null,:id_factura,:tipo, :cantidad,:precioUnitario, :precioServicio,:idH,:s,:idInsumo)";
					$this->setSQL($sql);
					$data = [
						'id_factura' => $id_factura,
						'tipo' => 'Servicio',
						'cantidad' => 1,
						'precioUnitario' => $this->getPrecioServicio()[$contador],
						'precioServicio' => $this->getPrecioServicio()[$contador],
						'idH' => null,
						's' => $s,
						'idInsumo' => null,
					];
					$this->create($data);
					$contador++;
				}
			}

			if ($this->getInsumos()) {
				$contador = 0;
				foreach ($this->getInsumos() as $i) {
					//actualizar la cantidad de insumos
					$id_entrada = $this->selectId_entrada($i);
					$data = [
						'id_factura' => $id_factura,
						'tipo' => 'Insumo',
						'cantidad' => $this->getCantidad()[$contador],
						'precioInsumo' => $this->getPrecioInsumo()[$contador],
						'subtotal' => $this->getPrecioInsumo()[$contador] * $this->getCantidad()[$contador],
						'i' => $id_entrada,
					];

					$sql = "INSERT INTO detalle_factura  VALUES (null, :id_factura, :tipo, :cantidad,:precioInsumo, :subtotal,null,null,:i)
";
					$this->setSQL($sql);
					$this->create($data);

					$sql =  "CALL DescontarLotes(:i, :cantidad);";
					$this->setSQL($sql);
					$data = [
						'i' => $i,
						'cantidad' => $this->getCantidad()[$contador]
					];
					$this->storedProcedure($data);

					$contador++;
				}
			}

			return [$id_factura, "exito", $data];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}




	public function consultarFactura()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			$sql  = "SELECT f.*, c.nombre as nombre_p , c.apellido AS apellido_p, nacionalidad, c.cedula AS cedula_p FROM factura f INNER JOIN cliente c ON c.id_cliente = f.id_cliente  WHERE id_factura =:id_factura ";

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
			$sql  = "SELECT pf.* , p.nombre
						FROM pago p INNER JOIN pagodefactura pf ON p.id_pago = pf.id_pago INNER JOIN factura f ON pf.id_factura = f.id_factura WHERE f.id_factura =:id_factura ";

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
			$sql = "SELECT cs.nombre As categoria_servicio, sf.*,s.*,p.nombre AS nombre_d, p.apellido AS apellido_d FROM detalle_factura sf  INNER JOIN serviciomedico s ON s.id_servicioMedico = sf.serviciomedico_id_servicioMedico INNER JOIN categoria_servicio cs ON cs.id_categoria = s.id_categoria INNER JOIN personal_has_serviciomedico ps ON ps.serviciomedico_id_servicioMedico = s.id_servicioMedico INNER JOIN personal p ON p.id_personal = ps.personal_id_personal  WHERE id_factura =:id_factura ";

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
			$sql = "SELECT f.*, p.nombre as nombre_p , p.apellido AS apellido_p, nacionalidad, p.cedula AS cedula_p FROM factura f INNER JOIN cliente p ON p.id_cliente = f.id_cliente WHERE f.id_factura =:id_factura";

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
			$sql = "SELECT i.*,fi.*,f.*,ins.nombre, ins.precio, ins.iva  FROM entrada_insumo i INNER JOIN detalle_factura fi ON i.id_entradaDeInsumo = fi.entrada_insumo_id_entradaDeInsumo INNER JOIN factura f  ON f.id_factura = fi.id_factura INNER JOIN insumo ins ON ins.id_insumo = i.id_insumo  WHERE f.id_factura =:id_factura";

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	//hospitalizcion
	// selecciono 6 tablas de la base de datos con el INNER JOIN, uso solo los datos que necesito, para mostrarlo en la tabla de la vista 
	public function selectsFacturaHosp()
	{
		try {
			$data = ['idH' => $this->returnObjectModel()['modeloHospitalizacion']->getIdH()];
			$sql = 'SELECT h.id_hospitalizacion, h.duracion, h.precio_horas, h.total, con.id_control, con.diagnostico, h.historiaclinica,pac.nacionalidad, pac.id_paciente, pac.cedula, pac.nombre, pac.apellido, u.id_usuario, doc.nombre AS nombredoc, doc.apellido AS apellidodoc FROM hospitalizacion h INNER JOIN control con ON h.id_control = con.id_control INNER JOIN paciente pac ON con.id_paciente = pac.id_paciente INNER JOIN usuario u ON con.id_usuario = u.id_usuario INNER JOIN personal doc ON doc.id_usuario = u.id_usuario INNER JOIN serviciomedico sm ON sm.id_personal = doc.id_personal WHERE con.estado = "ACT" AND sm.estado = "ACT" AND u.estado = "ACT" AND h.estado = "Pendiente"  AND h.id_hospitalizacion =:idH GROUP BY h.id_hospitalizacion';

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function selectInsumosHosp()
	{
		try {
			$data = ['idH' => $this->returnObjectModel()['modeloHospitalizacion']->getIdH()];
			$sql = 'SELECT i.*,ih.cantidad AS cantidad_insumo_hospit FROM insumodehospitalizacion ih INNER JOIN insumo i ON i.id_insumo = ih.id_insumo WHERE ih.id_hospitalizacion  = :idH';

			$this->setSQL($sql);
			return $this->search($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}


	public function consultarFacturaHosp($id_factura)
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			$sql = 'SELECT *,f.fecha, f.total, f.id_factura,p.nombre AS nombre_paciente, p.apellido AS apellido_paciente, p.cedula AS cedula_paciente ,p.nacionalidad,d.nombre AS nombre_d, d.apellido AS apellido_d FROM hospitalizacion h INNER JOIN factura f ON f.id_hospitalizacion = h.id_hospitalizacion INNER JOIN control c on h.id_control = c.id_control INNER JOIN usuario u on u.id_usuario = c.id_usuario INNER JOIN personal d ON d.id_usuario = u.id_usuario INNER JOIN paciente p ON c.id_paciente = p.id_paciente WHERE  f.id_factura =:id_factura';

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
			$sql = 'SELECT f.*,h.*,p.*,u.nombre AS nombre_d, u.apellido AS apellido_d FROM factura f inner join hospitalizacion h on h.id_hospitalizacion = f.id_hospitalizacion INNER JOIN control c ON c.id_control = h.id_control INNER JOIN paciente p ON p.id_paciente = c.id_paciente INNER JOIN usuario u ON u.id_usuario = c.id_usuario  WHERE f.id_factura =:id_factura';

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
			$sql = 'SELECT * FROM paciente where id_paciente = :id_paciente';

			$this->setSQL($sql);
			$dataPaciente = $this->search($data, false);


			$sql = 'SELECT * FROM paciente p INNER JOIN cliente c ON c.cedula = p.cedula WHERE  p.cedula = :cedula';

			$this->setSQL($sql);
			$data = $this->search(['cedula' => $dataPaciente['cedula']], false);
			while ($data) {
				return $data['id_cliente'];
			}
			return 0;

			if ($data == []) {
				return 0;
			}

			return $data['id_cliente'];
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function guardarCliente()
	{
		try {
			$data = ['id_paciente' => $this->getIdPaciente()];

			$sql = "SELECT * FROM paciente where id_paciente = :id_paciente";
			$this->setSQL($sql);

			$dataPaciente = $this->search($data, false);
			$this->returnObjectModel()['modeloCliente']->setNacionalidad($dataPaciente['nacionalidad']);
			$this->returnObjectModel()['modeloCliente']->setCedula($dataPaciente['cedula']);
			$this->returnObjectModel()['modeloCliente']->setNombre($dataPaciente['nombre']);
			$this->returnObjectModel()['modeloCliente']->setApellido($dataPaciente['apellido']);
			$this->returnObjectModel()['modeloCliente']->setTelefono($dataPaciente['telefono']);
			$this->returnObjectModel()['modeloCliente']->setDireccion($dataPaciente['direccion']);
			$this->returnObjectModel()['modeloCliente']->setFn($dataPaciente['fn']);
			$this->returnObjectModel()['modeloCliente']->setGenero($dataPaciente['genero']);

			return $this->returnObjectModel()['modeloCliente']->insertar();
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function comprobarSiFueHospit()
	{
		try {
			$data = ['id_factura' => $this->getIdFactura()];
			$sql = 'SELECT  * FROM factura f INNER JOIN detalle_factura df ON df.id_factura = f.id_factura WHERE f.id_factura =:id_factura AND df.tipo= "Hospitalizacion"';
			$this->setSQL($sql);
			$data = $this->search($data, false);

			while ($data) {
				return $data['hospitalizacion_id_hospitalizacion'];
			}
			return 0;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

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





	public function setIdFactura($id_factura)
	{
		if (!preg_match("/^[0-9]+$/", $id_factura)) {
			throw new \InvalidArgumentException("El ID de la factura debe ser un número entero positivo.");
		}

		if ((int)$id_factura <= 0) {
			throw new \InvalidArgumentException("El ID de la factura debe ser mayor que cero.");
		}

		$this->id_factura = (int)$id_factura;
	}

	public function setFecha($fecha)
	{
		$dt = \DateTime::createFromFormat('Y-m-d', $fecha);
		$fechaHoy = date("Y-m-d");

		if (!$dt || $dt->format('Y-m-d') !== $fecha) {
			throw new \InvalidArgumentException("La fecha debe tener el formato YYYY-MM-DD.");
		}
		if (!$fecha == $fechaHoy) {
			throw new \InvalidArgumentException("La fecha debe ser de hoy.");
		}
		$this->fecha = $fecha;
	}

	public function setTotal($total)
	{
		if (!preg_match("/^(?!0$)(?!1$)\d+([.,]\d+)?$/", $total)) {
			throw new \InvalidArgumentException("El total esta mal.");
		}

		$this->total  = $total;
	}

	public function setFormasDePago($formasDePago = [])
	{
		if (!is_array($formasDePago)) {
			throw new \InvalidArgumentException("El formas De Pago esta mal.");
		}

		$this->formasDePago  = $formasDePago;
	}

	public function setReferencia($referencia)
	{
		if (!preg_match("/^[0-9]+$/", $referencia)) {
			throw new \InvalidArgumentException("El referencia esta mal.");
		}

		$this->referencia  = $referencia;
	}

	public function setMontosPago($montosDePago = [])
	{
		if (!is_array($montosDePago)) {
			throw new \InvalidArgumentException("El mostos De Pago esta mal.");
		}

		$this->montosDePago  = $montosDePago;
	}

	public function setInsumos($insumos = [])
	{
		if (!is_array($insumos)) {
			throw new \InvalidArgumentException("los insumos  esta mal.");
		}

		$this->insumos  = $insumos;
	}



	public function setServicios($servicios = [])
	{
		if (!is_array($servicios)) {
			throw new \InvalidArgumentException("El servicio  esta mal.");
		}

		$this->servicios  = $servicios;
	}

	public function setCatidad($cantidad = [])
	{
		if (!is_array($cantidad)) {
			throw new \InvalidArgumentException("la cantidadno esta correcta.");
		}

		$this->cantidad  = $cantidad;
	}

	public function setPrecioInsumo($precioInsumo = [])
	{
		if (!is_array($precioInsumo)) {
			throw new \InvalidArgumentException("El precioInsumo esta mal.");
		}

		$this->precioInsumo  = $precioInsumo;
	}

	public function setPrecioServicio($precioServicio = [])
	{
		if (!is_array($precioServicio)) {
			throw new \InvalidArgumentException("El precio precioServicio esta mal.");
		}

		$this->precioServicio  = $precioServicio;
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
