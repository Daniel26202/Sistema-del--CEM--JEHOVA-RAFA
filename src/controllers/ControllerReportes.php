<?php

use App\modelos\ModeloReporte;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloFactura;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloPermisos;
// use FPDF\FPDF; 	




function reportes($parametro)
{
	$modeloReporte = new ModeloReporte();
	$modeloInsumo = new ModeloInsumo();

	$ayuda = "btnayudaReporte";
	$facturas = $modeloReporte->consultarFactura();
	$anuladas = $modeloReporte->consultarFacturaAnuladas();
	$insumos = $modeloInsumo->insumos();
	require_once './src/vistas/vistaReportes/vistaReportes.php';

	echo 'reportes';
}

function buscarPDF()
{
	require_once './src/vistas/vistaReportes/vistaReporteCitasPdf.php';
}

function buscarEntradasInsumosPDF()
{
	require_once './src/vistas/vistaReportes/vistaReporteEntradasPdf.php';
}

function factura($parametro)
{
	$modeloReporte = new ModeloReporte();
	$modeloFactura = new ModeloFactura();

	$modeloFactura->setIdFactura($parametro[0]);

	$datosFactura = $modeloReporte->consultarFacturaSinCita();
	$datosPago = $modeloReporte->consultarPagoFactura();
	$datosServiciosExtras = $modeloReporte->consultarServiciosExtras();
	$datosInsumos = $modeloReporte->consultarFacturaInsumo();
	// Verificar si se ha enviado el ID de cita
	if (isset($_GET["id_cita"]) && !empty($_GET["id_cita"])) {
		// Si se cumple la condición, requerir el primer archivo
		require_once './src/vistas/vistaReportes/vistaFacturaPdf2.php';
	} else {
		// Si no se cumple la condición, requerir el segundo archivo
		require_once './src/vistas/vistaReportes/vistaFacturaPdf.php';
	}
}
function pacientePDF($datos)
{
	$modeloReporte = new ModeloReporte();

	$pacientes = $modeloReporte->pdfPaciente();
	require_once './src/vistas/vistaReportes/vistaPacientePDF.php';
}
function insumosPDF()
{
	require_once './src/vistas/vistaReportes/vistaInsumosPDF.php';
}
function reportesFactura()
{
	require_once './src/vistas/vistaReportes/vistaReporteFacturaPDF.php';
}

function reportesFacturasAnuladas()
{
	require_once './src/vistas/vistaReportes/vistaReporteFacturaAnuladas.php';
}

function buscarPago($datos)
{
	$id_factura = $datos[0];
	$modeloReporte = new ModeloReporte();
	$modeloFactura = new ModeloFactura();
	$modeloFactura->setIdFactura($id_factura);

	$respuesta = $modeloReporte->consultarPagoFactura();

	echo json_encode($respuesta);
}

function buscarMasServicios($datos)
{
	$modeloReporte = new ModeloReporte();
	$modeloFactura = new ModeloFactura();

	$id_factura = $datos[0];

	$modeloFactura->setIdFactura($id_factura);
	$respuesta = $modeloReporte->consultarServiciosExtras();

	echo json_encode($respuesta);
}

function buscarInsumos($datos)
{
	$modeloReporte = new ModeloReporte();
	$modeloFactura = new ModeloFactura();

	$id_factura = $datos[0];

	$modeloFactura->setIdFactura($id_factura);
	$respuesta = $modeloReporte->consultarFacturaInsumo();

	echo json_encode($respuesta);
}

function buscarCita()
{
	$modeloReporte = new ModeloReporte();
	$modeloFactura = new ModeloFactura();

	$modeloFactura->setIdFactura($_GET["id_factura"]);
	$respuesta = $modeloReporte->consultarcitafactura();

	echo json_encode($respuesta);
}

function anularFactura()
{
	$modeloReporte = new ModeloReporte();
	$modeloBitacora = new ModeloBitacora();
	$modeloFactura = new ModeloFactura();

	$modeloFactura->setIdFactura($_POST["id_factura"]);
	$anular = $modeloReporte->anularFac();

	if ($anular) {
		// Guardo la bitacora
		$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
		$modeloBitacora->setTabla("factura");
		$modeloBitacora->setActividad("Ha anulado una factura");
		$modeloBitacora->insertarBitacora();
		// // $respuesta =$this->modelo->cantidadAnulada($array);
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Reportes/reportes/anulada");
	} else {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Reportes/reportes/errorSistem");
	}
}

// function permisos($id_rol, $permiso, $modulo)
// {
// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }
