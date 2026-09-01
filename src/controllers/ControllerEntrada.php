<?php

use App\modelos\ModeloEntrada;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloSanetizarJSON;




function entrada($parametro)
{
	$modeloEntrada = new ModeloEntrada();
	$sanetizar = new ModeloSanetizarJSON();
	$ayuda = "btnayudaEntrada";
	$vistaActiva = "entradas";
	$insumos = $sanetizar->sanitizeRecursive($modeloEntrada->insumos());
	$proveedores = $sanetizar->sanitizeRecursive($modeloEntrada->selectProveedores());
	require_once './src/vistas/vistaEntrada/vistaEntrada.php';
}

function entradasAjax()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['nombre', 'proveedor', 'fechDeIngreso', 'fechaDeVencimiento', 'cantidad_entrada', 'precio_entrada', 'numero_de_lote'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_entrada';

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_entrada';
	}

	$modeloEntrada = new ModeloEntrada();
	$sanetizar = new ModeloSanetizarJSON();

	$entradas = $sanetizar->sanitizeRecursive($modeloEntrada->todasLasEntradas($inicio, $limite, $buscar, $ordenColumna, $ordenDir));

	$totalRegistros = $modeloEntrada->contarTotalEntradas('ACT');
	$totalFiltrados = !empty($buscar) ? $modeloEntrada->contarTotalEntradas('ACT',$buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($entradas) ? $entradas : []
	];

	echo json_encode($response);
	exit;

}

function papelera($parametro)
{
	$modeloEntrada = new ModeloEntrada();
	$sanetizar = new ModeloSanetizarJSON();
	$insumos = $sanetizar->sanitizeRecursive($modeloEntrada->insumos());
	require_once './src/vistas/vistaEntrada/vistaEntradaDesactiva.php';
}

function entradasPapeleraAjax()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['nombre', 'proveedor', 'fechDeIngreso', 'fechaDeVencimiento', 'cantidad_entrada', 'precio_entrada', 'numero_de_lote'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_entrada';

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_entrada';
	}

	$modeloEntrada = new ModeloEntrada();
	$sanetizar = new ModeloSanetizarJSON();

	$entradas = $sanetizar->sanitizeRecursive($modeloEntrada->seleccionarDesactivos($inicio, $limite, $buscar, $ordenColumna, $ordenDir));

	$totalRegistros = $modeloEntrada->contarTotalEntradas('DES');
	$totalFiltrados = !empty($buscar) ? $modeloEntrada->contarTotalEntradas('DES', $buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($entradas) ? $entradas : []
	];

	echo json_encode($response);
	exit;
}

function proveedoresEditar()
{
	$modeloEntrada = new ModeloEntrada();
	$sanetizar = new ModeloSanetizarJSON();
	$respuesta = $sanetizar->sanitizeRecursive($modeloEntrada->selectProveedores());
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
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}

		$idUsuario = $_SESSION['id_usuario'];

		$modeloEntrada = new ModeloEntrada();
		$modeloBitacora = new ModeloBitacora();

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

		$insercion = $modeloEntrada->guardarEntrada($idUsuario);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$modeloBitacora->setActividad("Ha insertado una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
		} else {
			http_response_code(409);
			error_log("Error en guardar: " . $insercion);
			echo json_encode(['ok' => false, 'error' => 'Error al guardar la entrada.']);
			exit;
		}

	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function eliminar()
{
	try {
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}
		$idUsuario = $_SESSION['id_usuario'];

		$modeloEntrada = new ModeloEntrada();
		$modeloBitacora = new ModeloBitacora();

		$input = json_decode(file_get_contents("php://input"), true);
		$id = $input["id"] ?? null;

		$estado = empty($input["estado"]) ? 'DES' : 'ACT';
		$text = empty($input["estado"]) ? 'eliminado' : 'restablecido';
		$text_error = empty($input["estado"]) ? 'eliminar' : 'restablecer';

		$modeloEntrada->setIdEntrada($id);
		$elimincion = $modeloEntrada->eliminarEntrada($idUsuario,$estado);

		if (is_array($elimincion) && $elimincion[0] === "exito") {
			$modeloBitacora->setActividad("Ha {$text} una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			error_log("Error en eliminar: " . $elimincion);
			echo json_encode(['ok' => false, 'error' => "Error en {$text_error} le entrada."]);
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
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}
		$idUsuario = $_SESSION['id_usuario'];

		$modeloEntrada = new ModeloEntrada();
		$modeloBitacora = new ModeloBitacora();

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

		$edicion = $modeloEntrada->updateEntrda($idUsuario);

		if (is_array($edicion) && $edicion[0] === "exito") {
			$modeloBitacora->setActividad("Ha modificado una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $edicion]);
		} else {
			http_response_code(409);
			error_log("Error en edicion: " . $edicion);
			echo json_encode(['ok' => false, 'error' => 'Error al editar la entrada.']);
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
	$sanetizar = new ModeloSanetizarJSON();

	$modeloInsumo->setIdInsumo($_GET['id_insumo']);
	$respuesta = $sanetizar->sanitizeRecursive($modeloEntrada->insumosEntrada());
	echo json_encode($respuesta);
}