<?php
//requiero el modelo de factura
use App\modelos\ModeloFactura;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloCita;
use App\modelos\ModeloCliente;
use App\modelos\ModeloHospitalizacion;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloPermisos;

function factura($parametro)
{

	$modeloInsumos = new ModeloInsumo();
	$vistaActiva = 'factura';
	$ayuda = "btnayudaFactura";
	$insumos = $modeloInsumos->insumos();
	require_once './src/vistas/vistaFactura/factura.php';
}

function mostrarServicios()
{
	$modeloFactura  = new ModeloFactura();
	echo json_encode($modeloFactura->mostrarServicios());
}

function mostrarInsumos()
{
	$modeloInsumos  = new ModeloInsumo();
	echo json_encode($modeloInsumos->insumos(false));
}

function mostrarMetodosDePago()
{
	$modeloFactura = new ModeloFactura();
	echo json_encode($modeloFactura->mostrarTiposDePagos());
}

function facturaCita($parametro)
{
	$modeloInsumos = new ModeloInsumo();
	$modeloFactura = new ModeloFactura();

	$idCita = preg_replace('/\D/', '', $parametro[0]);
	$insumos = $modeloInsumos->insumos();
	$tiposDePagos = $modeloFactura->mostrarTiposDePagos();
	$todosLosInsumos = $insumos;
	$extras = $modeloFactura->mostrarServicios();
	$citaFacturar = $modeloFactura->mostrarCitaFactura($idCita);
	require_once './src/vistas/vistaFactura/facturaCita.php';
}

function facturarHospitalizacion($parametro)
{
	$modeloFactura = new ModeloFactura();

	// Extrae solo los dígitos del parámetro para obtener el ID de hospitalización
	$idHospitalizacion = preg_replace('/\D/', '', $parametro[0]);
	$insumosHospitalizacion = $modeloFactura->unirInsumosHospitalizacion($idHospitalizacion);
	$tiposDePagos = $modeloFactura->mostrarTiposDePagos();
	$hostalizacionFacturar = $modeloFactura->mostrarHospitalizacion($idHospitalizacion);
	$serviciosDeHospitalizacion = $modeloFactura->serviciosIncluidosHospit($idHospitalizacion);
	require_once './src/vistas/vistaFactura/facturaHospitalizacion.php';
}

function datosHospitalizacion($parametro)
{
	$modeloFactura = new ModeloFactura();
	$modeloFactura->setIdH($parametro[0]);

	//variable final
	$result = [];

	foreach ($modeloFactura->mostrarHospitalizacion() as $hospit) {
		$id_hospit = $hospit['id_hospitalizacion'];

		//filtrar los servicios para la hospitalizacion actual
		$servicios = array_filter($modeloFactura->serviciosIncluidosHospit(), function ($servicio) use ($id_hospit) {
			return $servicio['id_hospitalizacion'] === $id_hospit;
		});

		//filtrar los servicios para la hospitalizacion actual
		$insumos = array_filter($modeloFactura->unirInsumosHospitalizacion(), function ($insumo) use ($id_hospit) {
			return $insumo['id_hospitalizacion'] === $id_hospit;
		});

		$datosServicios = [];
		$datosInsumos = [];


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



	//agregamos el resultado
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

	echo json_encode($result);
}

function comprobante($parametro)
{
	$modeloFactura = new ModeloFactura();

	if ($parametro == "") header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");

	$modeloFactura->setIdFactura($parametro[0]);
	$datosFactura = $modeloFactura->consultarFactura();
	$datosPago = $modeloFactura->consultarPagoFactura();
	$datosServiciosExtras = $modeloFactura->consultarServiciosExtras();
	$x = $modeloFactura->comprobarSiFueHospit();
	$serviciosDeHospitalizacion = $modeloFactura->serviciosIncluidosHospit($x);

	$vistaActiva = $x ? 1 : 0;

	if ($vistaActiva) {
		$datosInsumos = $modeloFactura->unirInsumosHospitalizacion($x);
	} else {
		$datosInsumos = $modeloFactura->consultarFacturaInsumo($parametro[0]);
	}
	require_once './src/vistas/vistaFactura/comprobante.php';
}

// //aqui mostramos al paciente de la base de datos
function mostrarPaciente()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	try {
		$modeloFactura = new ModeloFactura();
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
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	try {
		$modeloFactura = new ModeloFactura();
		$modeloFactura->setCedula($_POST['cedula']);

		$respuesta = $modeloFactura->buscarCliente();
		echo json_encode($respuesta);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

//aqui mostramos al paciente si tiene cita
function mostrarPacienteConCita()
{
	$modeloFactura = new ModeloFactura();
	$modeloFactura->setCedula($_POST["cedula"]);
	$respuesta = $modeloFactura->buscarPacientePorCita();
	echo json_encode($respuesta);
}



//metodo para guaradar Factura
function guardarFactura()
{
	if (empty($_POST)) {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");
	}

	$modeloBitacora = new ModeloBitacora();
	$modeloFactura = new ModeloFactura();


	// $doctor = isset($_POST["doctores"]) ? $_POST["doctores"] : false;

	// echo $_POST['cantidad'];
	$modeloFactura->setFecha(date("Y-m-d"));
	$modeloFactura->setServicios(isset($_POST["servicios"]) ? $_POST["servicios"] : []);
	$modeloFactura->setInsumos(isset($_POST["insumos"]) ? $_POST["insumos"] : []);
	$modeloFactura->setCatidad(isset($_POST["cantidad"]) ? $_POST["cantidad"] : []);
	$modeloFactura->setPrecioInsumo(isset($_POST["precioInsumo"]) ? $_POST["precioInsumo"] : []);
	$modeloFactura->setPrecioServicio(isset($_POST["precioServicio"]) ? $_POST["precioServicio"] : []);
	$modeloFactura->setIdCliente(!empty($_POST["id_cliente"]) ? $_POST["id_cliente"] : 0);
	$modeloFactura->setIdPaciente(isset($_POST["id_paciente"]) ? $_POST["id_paciente"] : 0);
	$modeloFactura->setIdCita(isset($_POST["id_cita"]) ? $_POST["id_cita"] : 0);
	$modeloFactura->setReferencia(!isset($_POST["referencia"]) ? $_POST["referencia"] : 0);
	$modeloFactura->setIdH(isset($_POST["id_hospitalizacion"]) ? $_POST["id_hospitalizacion"] : 0);
	$modeloFactura->setTotal($_POST["total"]);
	$modeloFactura->setFormasDePago(isset($_POST["formasDePago"]) ? $_POST["formasDePago"] : []);
	$modeloFactura->setMontosPago($_POST["montosDePago"]);

	if (!$modeloFactura->getIdCliente()) {

		$coincidencia = $modeloFactura->coincidenciaPacienteCliente();
		if ($coincidencia) {
			$id_cliente = $coincidencia;
		} else {
			$guardado = $modeloFactura->guardarCliente();
			$id_cliente = $guardado[1];
		}
		$modeloFactura->setIdCliente($id_cliente);
	}


	$guardar = $modeloFactura->insertaFactura();

	if ($guardar) {
		// 	//Guardar la bitacora
		$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
		$modeloBitacora->setActividad("Ha facturado servicios y/o insumos");
		$modeloBitacora->setTabla("factura");
		$modeloBitacora->insertarBitacora();

		// 	print_r($guardar);

		// 	$modeloFactura->setIdFactura($guardar[0]);
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/comprobante/" . $guardar[0]);
	} else {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura/errorSistem");
		// print_r($guardar);
	}
}




function mostrarPDF($parametro)
{
	$modeloFactura = new ModeloFactura();
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

function permisos($id_rol, $permiso, $modulo)
{
	$modeloPermisos = new ModeloPermisos();
	$modeloPermisos->setIdRol($id_rol);
	$modeloPermisos->setPermiso($permiso);
	$modeloPermisos->setModulo($modulo);
	return $modeloPermisos->gestionarPermisos();
}
