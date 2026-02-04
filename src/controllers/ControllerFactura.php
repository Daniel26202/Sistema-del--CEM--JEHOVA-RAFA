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
	$modeloFactura = new ModeloFactura();

	$ayuda = "btnayudaFactura";
	$insumos = $modeloInsumos->insumos();
	$tiposDePagos = $modeloFactura->mostrarTiposDePagos();
	$todosLosInsumos = $modeloFactura->selectTodosLosInsumos();
	$extras = $modeloFactura->mostrarServicios();
	require_once './src/vistas/vistaFactura/factura.php';
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

function comprobante($parametro)
{
	$modeloFactura = new ModeloFactura();

	if ($parametro == "") header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura");

	$datosFactura = $modeloFactura->consultarFactura($parametro[0]);
	$datosPago = $modeloFactura->consultarPagoFactura($parametro[0]);
	$datosServiciosExtras = $modeloFactura->consultarServiciosExtras($parametro[0]);
	$x = $modeloFactura->comprobarSiFueHospit($parametro[0]);
	$serviciosDeHospitalizacion = $modeloFactura->serviciosIncluidosHospit($x);

	$vistaActiva = $x != 'no encontrado' ? 1 : 0;

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
	$modeloFactura = new ModeloFactura();

	$respuesta = $modeloFactura->buscar($_POST['cedula']);
	$arrayName = array();
	array_push($arrayName, $respuesta);
	echo json_encode($arrayName);
}

function mostrarCliente()
{
	$modeloFactura = new ModeloFactura();

	$respuesta = $modeloFactura->buscarCliente($_POST['cedula']);
	$arrayName = array();
	array_push($arrayName, $respuesta);
	echo json_encode($arrayName);
}

//aqui mostramos al paciente si tiene cita
function mostrarPacienteConCita()
{
	$modeloFactura = new ModeloFactura();

	$respuesta = $modeloFactura->buscarPacientePorCita($_POST["cedula"]);
	echo json_encode($respuesta);
}



//metodo para guaradar Factura
function guardarFactura()
{
	$modeloFactura = new ModeloFactura();
	$modeloBitacora = new ModeloBitacora();
	$modeloCliente = new ModeloCliente();
	$modeloPaciente = new ModeloPacientes();
	$modeloCita = new ModeloCita();
	$modeloHospitalizacion = new ModeloHospitalizacion();


	// $doctor = isset($_POST["doctores"]) ? $_POST["doctores"] : false;

	$modeloFactura->setFecha(date("Y-m-d"));
	$modeloFactura->setServicios(isset($_POST["servicios"]) ? $_POST["servicios"] : []);
	$modeloFactura->setInsumos(isset($_POST["insumos"]) ? $_POST["insumos"] : []);
	$modeloFactura->setCatidad(isset($_POST["cantidad"]) ? $_POST["cantidad"] : false);
	$modeloFactura->setPrecioInsumo(isset($_POST["precioInsumo"]) ? $_POST["precioInsumo"] : []);
	$modeloFactura->setPrecioServicio(isset($_POST["precioServicio"]) ? $_POST["precioServicio"] : []);
	$modeloCliente->setIdCliente(isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : false);
	$modeloPaciente->setIdPaciente(isset($_POST["id_paciente"]) ? $_POST["id_paciente"] : false);
	$modeloCita->setIdCita(isset($_POST["id_cita"]) ? $_POST["id_cita"] : null);
	$modeloFactura->setReferencia(isset($_POST["referencia"]) ? $_POST["referencia"] : null);
	$modeloHospitalizacion->setIdH(isset($_POST["id_hospitalizacion"]) ? $_POST["id_hospitalizacion"] : null);
	$modeloFactura->setTotal($_POST["total"]);
	$modeloFactura->setFormasDePago($_POST["formasDePago"]);
	$modeloFactura->setMontosPago($_POST["montosDePago"]);

	if (!$modeloCliente->getIdCliente()) {
		$coincidencia = $modeloFactura->coincidenciaPacienteCliente();
		if ($coincidencia) {
			$id_cliente = $coincidencia;
		} else {
			$guardado = $modeloFactura->guardarCliente();
			$id_cliente = $guardado[1];
		}
		$modeloCliente->setIdCliente($id_cliente);
	}


	$guardar = $modeloFactura->insertaFactura();

	if ($guardar) {
		//Guardar la bitacora
		$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
		$modeloBitacora->setActividad("Ha facturado servicios y/o insumos");
		$modeloBitacora->setTabla("factura");
		$modeloBitacora->insertarBitacora();
		
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/comprobante/" . $modeloFactura->getIdFactura());
	} else {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Factura/factura/errorSistem");
	}
}




function mostrarPDF($parametro)
{
	$modeloFactura = new ModeloFactura();

	$datosFactura = $modeloFactura->consultarFacturaSinCita($parametro[0]);
	$datosPago = $modeloFactura->consultarPagoFactura($parametro[0]);
	$datosServiciosExtras = $modeloFactura->consultarServiciosExtras($parametro[0]);
	$datosInsumos = $modeloFactura->consultarFacturaInsumo($parametro[0]);
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
