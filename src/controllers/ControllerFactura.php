<?php

use App\models\ModeloFactura;
use App\models\ModeloBitacora;
use App\models\ModeloCita;
use App\models\ModeloCliente;
use App\models\ModeloHospitalizacion;
use App\models\ModeloInsumo;
use App\models\ModeloPacientes;
use App\models\ModeloPermisos;
use App\models\Db;
use App\models\Validator;

function factura($parametro)
{
	$db = new Db();
	$validator = new Validator();
	$modeloInsumos = new ModeloInsumo($db,$validator);
	$vistaActiva = 'factura';
	$ayuda = "btnayudaFactura";
	$insumos = $modeloInsumos->insumos();
	require_once './src/vistas/vistaFactura/factura.php';
}

function mostrarServicios()
{
	$db = new Db();
	$validator = new Validator();
	$modeloFactura = new ModeloFactura($db,$validator);
	$result = [];

	foreach ($modeloFactura->mostrarServicios() as $servicio) {
		$result[] = [
			'id' => $servicio['id_servicioMedico'] . "" . $servicio['id_personal'],
			'id_personal' => $servicio['id_personal'],
			'id_servicioMedico' => $servicio['id_servicioMedico'],
			'id_categoria' => $servicio['id_categoria'],
			'nombre_d' => $servicio['nombre_d'],
			'apellido_d' => $servicio['apellido_d'],
			'precio' => $servicio['precio'],
			'categoria' => $servicio['categoria'],
		];
	}
	echo json_encode($result);
}

function mostrarInsumos()
{
	$db = new Db();
	$validator = new Validator();
	$modeloInsumos = new ModeloInsumo($db,$validator);
	// echo json_encode($modeloInsumos->insumos(false));
}

function mostrarMetodosDePago()
{
	$db = new Db();
	$validator = new Validator();
	$modeloFactura = new ModeloFactura($db,$validator);
	echo json_encode($modeloFactura->mostrarTiposDePagos());
}

function facturaCita($parametro)
{
	$db = new Db();
	$validator = new Validator();
	$modeloInsumos = new ModeloInsumo($db,$validator);
	$modeloFactura = new ModeloFactura($db,$validator);

	$idCita = preg_replace('/\D/', '', $parametro[0]);

	$modeloFactura->setIdCita($idCita);

	$insumos = $modeloInsumos->insumos();
	$tiposDePagos = $modeloFactura->mostrarTiposDePagos();
	$todosLosInsumos = $insumos;
	$extras = $modeloFactura->mostrarServicios();
	// $citaFacturar = $modeloFactura->mostrarCitaFactura();

	require_once './src/vistas/vistaFactura/facturaCita.php';
}

function facturarHospitalizacion($parametro)
{
	$db = new Db();
	$validator = new Validator();
	$modeloFactura = new ModeloFactura($db,$validator);
	$idHospitalizacion = preg_replace('/\D/', '', $parametro[0]);

	$modeloFactura->setIdH($idHospitalizacion);

	$insumosHospitalizacion = $modeloFactura->unirInsumosHospitalizacion();
	$tiposDePagos = $modeloFactura->mostrarTiposDePagos();
	$hostalizacionFacturar = $modeloFactura->mostrarHospitalizacion();
	$serviciosDeHospitalizacion = $modeloFactura->serviciosIncluidosHospit();

	require_once './src/vistas/vistaFactura/facturaHospitalizacion.php';
}

function datosHospitalizacion($parametro)
{
	$db = new Db();
	$validator = new Validator();
	$modeloFactura = new ModeloFactura($db,$validator);
	$modeloFactura->setIdH($parametro[0]);

	$result = [];
	$hospit = null;
	$datosServicios = [];
	$datosInsumos = [];

	foreach ($modeloFactura->mostrarHospitalizacion() as $hospit) {
		$id_hospit = $hospit['id_hospitalizacion'];

		$servicios = array_filter(
			$modeloFactura->serviciosIncluidosHospit(),
			fn($s) => $s['id_hospitalizacion'] === $id_hospit
		);
		$insumos = array_filter(
			$modeloFactura->unirInsumosHospitalizacion(),
			fn($i) => $i['id_hospitalizacion'] === $id_hospit
		);

		foreach ($servicios as $servicio) {
			$datosServicios[] = [
				'id_servicioMedico' => $servicio['id_servicioMedico'],
				'id_doctor' => $servicio['id_doctor'],
				'nombre_d' => $servicio['nombre_d'],
				'apellido_d' => $servicio['apellido_d'],
				'categoria' => $servicio['categoria'],
				'precios_servicio' => $servicio['precios_servicio']
			];
		}
		foreach ($insumos as $insumo) {
			$datosInsumos[] = [
				'id_entradaDeInsumo' => $insumo['id_entradaDeInsumo'],
				'nombre' => $insumo['nombre'],
				'medida' => $insumo['medida'],
				'precio' => $insumo['precio'],
				'iva' => $insumo['iva'],
				'cantidad' => $insumo['cantidad'],
			];
		}
	}

	if ($hospit) {
		$result[] = [
			'id_hospitalizacion' => $hospit['id_hospitalizacion'],
			'fecha_hora_inicio' => $hospit['fecha_hora_inicio'],
			'precio_horas' => $hospit['precio_horas'],
			'fecha_hora_final' => $hospit['fecha_hora_final'],
			'total_MoEx' => $hospit['total_MoEx'],
			'total' => $hospit['total'],
			'id_paciente' => $hospit['id_paciente'],
			'nacionalidad' => $hospit['nacionalidad'],
			'nombre_p' => $hospit['nombre'],
			'apellido_p' => $hospit['apellido'],
			'nombredoc' => $hospit['nombredoc'],
			'apellidodoc' => $hospit['apellidodoc'],
			'fecha_de_nacimiento' => $hospit['fn'],
			'servicios' => $datosServicios,
			'insumos' => $datosInsumos
		];
	}

	echo json_encode($result);
}

function comprobante($parametro)
{
	$db = new Db();
	$validator = new Validator();
	$modeloFactura = new ModeloFactura($db,$validator);

	if ($parametro == "") {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");
		exit;
	}

	$modeloFactura->setIdFactura($parametro[0]);
	$datosFactura = $modeloFactura->consultarFactura();
	$datosPago = $modeloFactura->consultarPagoFactura();
	$datosServiciosExtras = $modeloFactura->consultarServiciosExtras();
	$x = $modeloFactura->comprobarSiFueHospit();
	$serviciosDeHospitalizacion = $modeloFactura->serviciosIncluidosHospit($x);

	$vistaActiva = $x ? 1 : 0;

	$datosInsumos = $vistaActiva ? $modeloFactura->unirInsumosHospitalizacion($x) : $modeloFactura->consultarFacturaInsumo($parametro[0]);

	require_once './src/vistas/vistaFactura/comprobante.php';
}

function mostrarPaciente()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}
	try {
		$db = new Db();
		$validator = new Validator();
		$modeloFactura = new ModeloFactura($db,$validator);
		$modeloFactura->setCedula($_POST['cedula']);
		echo json_encode($modeloFactura->buscar());
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function mostrarCliente()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}
	try {
		$db = new Db();
		$validator = new Validator();
		$modeloFactura = new ModeloFactura($db,$validator);
		$modeloFactura->setCedula($_POST['cedula']);
		echo json_encode($modeloFactura->buscarCliente());
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function mostrarPacienteConCita()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}
	$db = new Db();
	$validator = new Validator();
	$modeloFactura = new ModeloFactura($db,$validator);
	$modeloFactura->setCedula($_POST["cedula"]);
	echo json_encode($modeloFactura->buscarPacientePorCita());
}

function guardarFactura()
{
	if (empty($_POST)) {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");
		exit;
	}

	$idUsuario = $_SESSION['id_usuario'];
	$db = new Db();
	$validator = new Validator();
	$validator->set_session($_SESSION);
	$validator->set_id_usuario($idUsuario);
	$modeloBitacora = new ModeloBitacora($db,$validator);
	$modeloFactura  = new ModeloFactura($db,$validator);

	$modeloFactura->setFecha(date("Y-m-d"));
	$modeloFactura->setServicios(isset($_POST["servicios"]) ? $_POST["servicios"] : []);
	$modeloFactura->setInsumos(isset($_POST["insumos"]) ? $_POST["insumos"] : []);
	$modeloFactura->setCatidad(isset($_POST["cantidad"]) ? $_POST["cantidad"] : []);
	$modeloFactura->setPrecioInsumo(isset($_POST["precioInsumo"]) ? $_POST["precioInsumo"] : []);
	$modeloFactura->setPrecioServicio(isset($_POST["precioServicio"]) ? $_POST["precioServicio"] : []);
	$modeloFactura->setIdCliente(!empty($_POST["id_cliente"]) ? $_POST["id_cliente"] : 0);
	$modeloFactura->setIdPaciente(isset($_POST["id_paciente"]) ? $_POST["id_paciente"] : 0);
	$modeloFactura->setIdCita(isset($_POST["id_cita"]) ? $_POST["id_cita"] : 0);
	$modeloFactura->setReferencia(!empty($_POST["referencia"]) ? $_POST["referencia"] : 0);
	$modeloFactura->setIdH(isset($_POST["id_hospitalizacion"]) ? $_POST["id_hospitalizacion"] : 0);
	$modeloFactura->setTotal($_POST["total"]);
	$modeloFactura->setFormasDePago(isset($_POST["formasDePago"]) ? $_POST["formasDePago"] : []);
	$modeloFactura->setMontosPago($_POST["montosDePago"]);

	// Resolver cliente
	if (!$modeloFactura->getIdCliente()) {
		$coincidencia = $modeloFactura->coincidenciaPacienteCliente();
		if ($coincidencia) {
			$id_cliente = $coincidencia;
		} else {
			$guardado = $modeloFactura->guardarCliente($idUsuario);
			$id_cliente = $guardado[1];
		}
		$modeloFactura->setIdCliente($id_cliente);
	}

	$guardar = $modeloFactura->guardarFactura($idUsuario);

	if ($guardar) {
		$modeloBitacora->setId_usuario($idUsuario);
		$modeloBitacora->setActividad("Ha facturado servicios y/o insumos");
		$modeloBitacora->setTabla("factura");
		$modeloBitacora->guardar($modeloBitacora->get_all(),$idUsuario);

		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/comprobante/" . $guardar[0]);
	} else {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura/errorSistem");
	}
	exit;
}

function mostrarPDF($parametro)
{
	$db = new Db();
	$validator = new Validator();
	$modeloFactura = new ModeloFactura($db,$validator);
	$modeloFactura->setIdFactura($parametro[0]);
	$datosFactura = $modeloFactura->consultarFacturaSinCita();
	$datosPago = $modeloFactura->consultarPagoFactura();
	$datosServiciosExtras = $modeloFactura->consultarServiciosExtras();
	$datosInsumos = $modeloFactura->consultarFacturaInsumo();
	require_once './src/vistas/vistaFactura/vistaFacturaPdf.php';
}

function mostrarPDF2()
{
	require_once './src/vistas/vistaFactura/vistaFacturaPdf2.php';
}

function mostrarPDF3()
{
	require_once './src/vistas/vistaFactura/vistaFacturaPdf3.php';
}