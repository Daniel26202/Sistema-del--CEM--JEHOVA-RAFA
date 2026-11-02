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
	$vistaActiva = "reportes";
	$ayuda = "btnayudaReporte";
	$insumos = $modeloInsumo->insumos();
	require_once './src/vistas/vistaReportes/vistaReportes.php';
}

function returnDataFactura()
{
	$modeloReporte = new ModeloReporte();

	$facturas = $modeloReporte->consultarFactura();
	$todosServicios = $modeloReporte->consultarServiciosExtras();
	$todosInsumos = $modeloReporte->consultarFacturaInsumo();
	$todosPagos = $modeloReporte->consultarPagoFactura();

	if (!is_array($facturas) || !is_array($todosServicios) || !is_array($todosInsumos) || !is_array($todosPagos)) {
		http_response_code(500);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['ok' => false, 'error' => 'No se pudieron cargar las facturas.']);
		return;
	}

	//variable final
	$result = [];
	foreach ($facturas as $factura) {
		$id_factura = (int)$factura['id_factura'];

		//filtrar los servicios para la factura
		$servicios = array_filter($todosServicios, function ($servicio) use ($id_factura) {
			return (int)$servicio['id_factura'] === $id_factura;
		});

		//filtrar los insumos para la factura
		$insumos = array_filter($todosInsumos, function ($insumo) use ($id_factura) {
			return (int)$insumo['id_factura'] === $id_factura;
		});


		//filtrar los pagos para la factura
		$pagos = array_filter($todosPagos, function ($pago) use ($id_factura) {
			return (int)$pago['id_factura'] === $id_factura;
		});


		$datosServicios = [];
		$datosInsumos = [];
		$datosPago = [];

		foreach ($servicios as $servicio) {
			$datosServicios[] = [
				"nombre_d" => $servicio['nombre_d'],
				"apellido_d" => $servicio['apellido_d'],
				"categoria" => $servicio['categoria'],
				'precio' => $servicio['precio'],
			];
		}

		foreach ($insumos as $insumo) {
			$datosInsumos[] = [
				"nombre_insumo" => $insumo['nombre_insumo'],
				"cantidad_insumo" => $insumo['cantidad_insumo'],
				"precio_insumo" => $insumo['precio_insumo'],
				'iva' => $insumo['iva'],
			];
		}

		foreach ($pagos as $pago) {
			$datosPago[] = [
				"nombre" => $pago['nombre'],
				"monto" => $pago['monto'],
			];
		}

		$result[] = [
			// El hash se conserva como clave de navegación (data-index, URL de
			// PDF y anulación); numero_factura es solo el texto que ve el usuario.
			'id_factura' => hashId((int)$factura['id_factura']),
			'numero_factura' => numeroFacturaLegible((int)$factura['id_factura']),
			'nacionalidad' => $factura['nacionalidad'],
			'cedula_p' => $factura['cedula_p'],
			'nombre_p' => $factura['nombre_p'],
			'apellido_p' => $factura['apellido_p'],
			'fecha' => $factura['fecha'],
			'total' => $factura['total'],
			'estado' => $factura['estado'],
			'servicios' => $datosServicios,
			'insumos' => $datosInsumos,
			'pagos' => $datosPago
		];
	}


	echo json_encode($result);
}






function returnDataFacturaAnulada()
{
	$modeloReporte = new ModeloReporte();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_factura']);
	echo json_encode($sanetizar->sanitizeRecursive($modeloReporte->consultarFacturaAnuladas()));
}

function buscarPDF()
{
	$modeloReporte = new ModeloReporte();
	$modeloReporte->setFechaInicio($_POST['desdeFecha'] ?? '');
	$modeloReporte->setFinal($_POST['fechaHasta'] ?? '');

	// No imprimir datos de depuración: el navegador recibe un PDF y cualquier
	// texto adicional corrompe el archivo.
	$citas = $modeloReporte->Citaspdf();
	require_once './src/vistas/vistaReportes/vistaReporteCitasPdf.php';
}

function buscarEntradasInsumosPDF()
{
	$modeloReporte = new ModeloReporte();

	$desdeFecha = isset($_POST["desdeFechaEntradas"]) ? $_POST["desdeFechaEntradas"] : "";
	$fechaHastaEntradas = isset($_POST["fechaHastaEntradas"]) ? $_POST["fechaHastaEntradas"] : "";

	$modeloReporte->setFechaInicio($desdeFecha);
	$modeloReporte->setFinal($fechaHastaEntradas);
	$modeloReporte->setIdInsumo($_POST['id_insumo']);

	$entradas = $modeloReporte->entradasInsumosPdf();


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
	$modeloReporte = new ModeloReporte();

	$insumos = $modeloReporte->pdfInsumos();

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

function anularFactura($datos)
{
	// La anulación es una operación destructiva: solo por POST y con CSRF.
	if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
		http_response_code(405);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['ok' => false, 'error' => 'Método no permitido.']);
		exit;
	}

	$headers = function_exists('getallheaders') ? getallheaders() : [];
	$csrf = $headers['X-CSRF-Token'] ?? $headers['x-csrf-token'] ?? $_POST['csrf_token'] ?? null;

	if (empty($_SESSION['csrf_token']) || !is_string($csrf) || !hash_equals($_SESSION['csrf_token'], $csrf)) {
		http_response_code(403);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
		exit;
	}

	try {
		$modeloReporte = new ModeloReporte();
		$modeloBitacora = new ModeloBitacora();

		$modeloReporte->setIdFactura(unhashId($datos[0]));

		// El usuario sale de la sesión, nunca de la URL: antes cualquiera podía
		// enviar el id de otro usuario y falsear la bitácora.
		$idUsuario = $_SESSION['id_usuario'] ?? null;

		// Guardo la bitacora
		$modeloBitacora->setId_usuario($idUsuario);
		$modeloBitacora->setTabla("factura");
		$modeloBitacora->setActividad("Ha anulado una factura");

		$anular = $modeloReporte->anularFac();

		//Verifica si es un array con clave "exito"
		if (is_array($anular) && $anular[0] === "exito") {
			$modeloBitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode(['ok' => false, 'error' => is_string($anular) ? $anular : 'No se pudo anular la factura.']);
			exit;
		}
	} catch (\Throwable $e) {
		http_response_code(409);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode(['ok' => false, 'error' => $e instanceof InvalidArgumentException ? $e->getMessage() : 'No se pudo procesar la solicitud.']);
		exit;
	}
}

// function permisos($id_rol, $permiso, $modulo)
// {
// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }
