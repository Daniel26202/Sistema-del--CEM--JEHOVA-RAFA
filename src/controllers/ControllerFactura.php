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


function returnObjectClass()
{
	return [
		"factura" => new ModeloFactura(),
		'insumo' => new ModeloInsumo(),
		"bitacora" => new ModeloBitacora(),
		'cliente' => new ModeloCliente(),
		'paciente' => new ModeloPacientes(),
		'cita' => new ModeloCita(),
		'hospitalizacion' => new ModeloHospitalizacion()
	];
}

function factura($parametro)
{

	$ayuda = "btnayudaFactura";
	$insumos = returnObjectClass()['insumo']->selectTodosLosInsumos();
	$tiposDePagos = returnObjectClass()['factura']->mostrarTiposDePagos();
	$todosLosInsumos = returnObjectClass()['factura']->selectTodosLosInsumos();
	$extras = returnObjectClass()['factura']->mostrarServicios();
	require_once './src/vistas/vistaFactura/factura.php';
}

function facturaCita($parametro)
{
	$idCita = preg_replace('/\D/', '', $parametro[0]);
	$insumos = returnObjectClass()['insumo']->selectTodosLosInsumos();
	$tiposDePagos = returnObjectClass()['factura']->mostrarTiposDePagos();
	$todosLosInsumos = $insumos;
	$extras = returnObjectClass()['factura']->mostrarServicios();
	$citaFacturar = returnObjectClass()['factura']->mostrarCitaFactura($idCita);
	require_once './src/vistas/vistaFactura/facturaCita.php';
}

function facturarHospitalizacion($parametro)
{
	// Extrae solo los dígitos del parámetro para obtener el ID de hospitalización
	$idHospitalizacion = preg_replace('/\D/', '', $parametro[0]);
	$insumosHospitalizacion = returnObjectClass()['factura']->unirInsumosHospitalizacion($idHospitalizacion);
	$tiposDePagos = returnObjectClass()['factura']->mostrarTiposDePagos();
	$hostalizacionFacturar = returnObjectClass()['factura']->mostrarHospitalizacion($idHospitalizacion);
	$serviciosDeHospitalizacion = returnObjectClass()['factura']->serviciosIncluidosHospit($idHospitalizacion);
	require_once './src/vistas/vistaFactura/facturaHospitalizacion.php';
}

function comprobante($parametro)
{

	if ($parametro == "") header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");

	$datosFactura = returnObjectClass()['factura']->consultarFactura($parametro[0]);
	$datosPago = returnObjectClass()['factura']->consultarPagoFactura($parametro[0]);
	$datosServiciosExtras = returnObjectClass()['factura']->consultarServiciosExtras($parametro[0]);
	$x = returnObjectClass()['factura']->comprobarSiFueHospit($parametro[0]);
	$serviciosDeHospitalizacion = returnObjectClass()['factura']->serviciosIncluidosHospit($x);

	$vistaActiva = $x != 'no encontrado' ? 1 : 0;

	if ($vistaActiva) {
		$datosInsumos = returnObjectClass()['factura']->unirInsumosHospitalizacion($x);
	} else {
		$datosInsumos = returnObjectClass()['factura']->consultarFacturaInsumo($parametro[0]);
	}
	require_once './src/vistas/vistaFactura/comprobante.php';
}

// //aqui mostramos al paciente de la base de datos
function mostrarPaciente()
{
	$respuesta = returnObjectClass()['factura']->buscar($_POST['cedula']);
	$arrayName = array();
	array_push($arrayName, $respuesta);
	echo json_encode($arrayName);
}

function mostrarCliente()
{
	$respuesta = returnObjectClass()['factura']->buscarCliente($_POST['cedula']);
	$arrayName = array();
	array_push($arrayName, $respuesta);
	echo json_encode($arrayName);
}

//aqui mostramos al paciente si tiene cita
function mostrarPacienteConCita()
{
	$respuesta = returnObjectClass()['factura']->buscarPacientePorCita($_POST["cedula"]);
	echo json_encode($respuesta);
}



//metodo para guaradar Factura
function guardarFactura()
{
	$factura = returnObjectClass()['factura'];
	$insumo = returnObjectClass()['insumo'];
	$bitacora = returnObjectClass()['bitacora'];
	$cliente = returnObjectClass()['cliente'];
	$paciente = returnObjectClass()['paciente'];
	$cita = returnObjectClass()['cita'];
	$hospitalizacion = returnObjectClass()['hospitalizacion'];


	// $doctor = isset($_POST["doctores"]) ? $_POST["doctores"] : false;

	$factura->setFecha(date("Y-m-d"));
	$factura->setServicios(isset($_POST["servicios"]) ? $_POST["servicios"] : []);
	$factura->setInsumos(isset($_POST["insumos"]) ? $_POST["insumos"] : []);
	$factura->setCatidad(isset($_POST["cantidad"]) ? $_POST["cantidad"] : false);
	$factura->setPrecioInsumo(isset($_POST["precioInsumo"]) ? $_POST["precioInsumo"] : []);
	$factura->setPrecioServicio(isset($_POST["precioServicio"]) ? $_POST["precioServicio"] : []);
	$cliente->setIdCliente(isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : false);
	$paciente->setIdPaciente(isset($_POST["id_paciente"]) ? $_POST["id_paciente"] : false);
	$cita->setIdCita(isset($_POST["id_cita"]) ? $_POST["id_cita"] : null);
	$factura->setReferencia(isset($_POST["referencia"]) ? $_POST["referencia"] : null);
	$hospitalizacion->setIdH(isset($_POST["id_hospitalizacion"]) ? $_POST["id_hospitalizacion"] : null);
	$factura->setTotal($_POST["total"]);
	$factura->setFormasDePago($_POST["formasDePago"]);
	$factura->setMontosPago($_POST["montosDePago"]);


	if (!$cliente->getIdCliente()) {
		$coincidencia = $factura->coincidenciaPacienteCliente();
		if ($coincidencia) {
			$id_cliente = $coincidencia;
		} else {
			$guardado = $factura->guardarCliente();
			$id_cliente = $guardado[1];
		}
		$cliente->setIdCliente($id_cliente);
	}


	$guardar = $factura->insertaFactura();

	if ($guardar) {
		//Guardar la bitacora
		$bitacora->setId_usuario($_POST['id_usuario_bitacora']);
		$bitacora->setActividad("Ha facturado servicios y/o insumos");
		$bitacora->setTabla("factura");

		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/comprobante/" . $factura[0]);
	} else {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura/errorSistem");
	}
}




	 function mostrarPDF($parametro)
	{
		$datosFactura = returnObjectClass()['factura']->consultarFacturaSinCita($parametro[0]);
		$datosPago = returnObjectClass()['factura']->consultarPagoFactura($parametro[0]);
		$datosServiciosExtras = returnObjectClass()['factura']->consultarServiciosExtras($parametro[0]);
		$datosInsumos = returnObjectClass()['factura']->consultarFacturaInsumo($parametro[0]);

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

	//  function permisos($id_rol, $permiso, $modulo)
	// {
	// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	// }
