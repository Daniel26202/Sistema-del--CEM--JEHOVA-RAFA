<?php

use App\modelos\ModeloEntrada;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloProveedores;
use App\config\RateLimiter;




function entrada($parametro)
{
	$modeloEntrada = new ModeloEntrada();
	$ayuda = "btnayudaEntrada";
	$vistaActiva = "entradas";
	$insumos = $modeloEntrada->insumos();
	$proveedores = $modeloEntrada->selectProveedores();
	require_once './src/vistas/vistaEntrada/vistaEntrada.php';
}

function entradasAjax()
{
	$modeloEntrada = new ModeloEntrada();
	echo json_encode($modeloEntrada->todasLasEntradas());
}

function papelera($parametro)
{
	$modeloEntrada = new ModeloEntrada();
	$insumos = $modeloEntrada->insumos();
	require_once './src/vistas/vistaEntrada/vistaEntradaDesactiva.php';
}

function entradasPapeleraAjax()
{
	$modeloEntrada = new ModeloEntrada();
	echo json_encode($modeloEntrada->seleccionarDesactivos());
}

function restablecerEntrada($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {

		$idUsuario = $_SESSION['id_usuario'];
		// RATE LIMIT: 5 peticiones cada 1 segundos
		$limiter = new RateLimiter();
		$limiter->verificar('restablecer_entrada_' . $idUsuario, 5, 1);

		$modeloEntrada = new ModeloEntrada();
		$modeloBitacora = new ModeloBitacora();

		$id_entrada = $datos[0];
		$id_usuario_bitacora = $datos[1];

		$modeloEntrada->setIdEntrada($id_entrada);
		$restablecimiento = $modeloEntrada->restablecerEntrada();


		if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {

			$modeloBitacora->setActividad("Ha restablecido una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($id_usuario_bitacora);
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $restablecimiento]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function proveedoresEditar()
{
	$modeloEntrada = new ModeloEntrada();
	$respuesta = $modeloEntrada->selectProveedores();
	echo json_encode($respuesta);
}



function guardar()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	try {


		$idUsuario = $_SESSION['id_usuario'];
		// RATE LIMIT: 5 peticiones cada 1 segundos
		$limiter = new RateLimiter();
		$limiter->verificar('guardar_entrada_' . $idUsuario, 5, 1);

		$modeloEntrada = new ModeloEntrada();
		$modeloBitacora = new ModeloBitacora();
		$modeloInsumo = new ModeloInsumo();
		$modeloProveedores = new ModeloProveedores();

		// Quitar separadores de miles
		$valor = str_replace('.', '', $_POST['precioD']);
		//Cambiar coma decimal por punto
		$valor = str_replace(',', '.', $valor);
		$precio = (float)$valor;

		$modeloEntrada->setIdInsumo($_POST["id_insumo"]);
		$modeloEntrada->setLote($_POST["lote"]);
		$modeloEntrada->setIdProveedor($_POST["proveedor"]);
		$modeloEntrada->setFechaDeIngreso(date("Y-m-d"));
		$modeloEntrada->setFechaDeVencimiento($_POST["fechaDeVencimiento"]);
		$modeloEntrada->setCantidadDisponible($_POST["cantidad"]);
		$modeloEntrada->setPrecio($precio);

		$insercion = $modeloEntrada->insertarEntrada();

		if (is_array($insercion) && $insercion[0] === "exito") {
			$modeloBitacora->setActividad("Ha insertado una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
			$modeloBitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insercion]);
			exit;
		}

		// echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);

	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function eliminar($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	try {

		$idUsuario = $_SESSION['id_usuario'];
		// RATE LIMIT: 5 peticiones cada 1 segundos
		$limiter = new RateLimiter();
		$limiter->verificar('eliminar_entrada_' . $idUsuario, 5, 1);

		$modeloEntrada = new ModeloEntrada();
		$modeloBitacora = new ModeloBitacora();

		$id_entrada = $datos[0];
		$id_usuario_bitacora = $datos[1];

		$modeloEntrada->setIdEntrada($id_entrada);
		$elimincion = $modeloEntrada->eliminar();

		if (is_array($elimincion) && $elimincion[0] === "exito") {
			$modeloBitacora->setActividad("Ha eliminado una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($id_usuario_bitacora);
			$modeloBitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $elimincion]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function editar()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	try {

		$idUsuario = $_SESSION['id_usuario'];
		// RATE LIMIT: 5 peticiones cada 1 segundos
		$limiter = new RateLimiter();
		$limiter->verificar('editar_entrada_' . $idUsuario, 5, 1);

		$modeloEntrada = new ModeloEntrada();
		$modeloBitacora = new ModeloBitacora();
		$modeloProveedores = new ModeloProveedores();
		$modeloInsumo = new ModeloInsumo();

		//Quitar separadores de miles
		$valor = str_replace('.', '', $_POST['precioD']);
		//Cambiar coma decimal por punto
		$valor = str_replace(',', '.', $valor);
		$precio = (float)$valor;

		// $modeloInsumo->setIdInsumo($_POST["id_insumo"]);
		$modeloEntrada->setLote($_POST["lote"]);
		$modeloEntrada->setIdProveedor($_POST["proveedor"]);
		$modeloEntrada->setIdEntrada($_POST["id_entrada"]);
		$modeloEntrada->setFechaDeVencimiento($_POST["fechaDeVencimiento"]);
		$modeloEntrada->setCantidadEntrante($_POST["cantidad"]);
		$modeloEntrada->setPrecio($precio);

		$edicion = $modeloEntrada->actualizarEntrada();

		if (is_array($edicion) && $edicion[0] === "exito") {
			$modeloBitacora->setActividad("Ha modificado una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
			$modeloBitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $edicion]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $edicion]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function entradaInsumo()
{
	$modeloEntrada = new ModeloEntrada();
	$modeloInsumo = new ModeloInsumo();

	$modeloInsumo->setIdInsumo($_GET['id_insumo']);
	$respuesta = $modeloEntrada->insumosEntrada();
	echo json_encode($respuesta);
}

function permisos($id_rol, $permiso, $modulo)
{
	$modeloPermisos = new ModeloPermisos();
	$modeloPermisos->setIdRol($id_rol);
	$modeloPermisos->setPermiso($permiso);
	$modeloPermisos->setModulo($modulo);
	return $modeloPermisos->gestionarPermisos();
}
