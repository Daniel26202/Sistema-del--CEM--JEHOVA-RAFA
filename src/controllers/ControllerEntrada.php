<?php

use App\modelos\ModeloEntrada;
use App\modelos\ModeloInsumo;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloSanetizarJSON;




function entrada($parametro)
{
	$modeloEntrada = new ModeloEntrada();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_insumo', 'id_proveedor']);
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

	$columnasMapeadas = ['nombre', 'proveedor', 'fechaDeIngreso', 'fechaDeVencimiento', 'cantidad_entrada', 'precio_entrada', 'numero_de_lote'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_entrada';

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_entrada';
	}

	$modeloEntrada = new ModeloEntrada();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_entrada', 'id_entradaDeInsumo', 'id_insumo', 'id_proveedor']);

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
	$sanetizar->setHashKeys(['id_insumo']);
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

	$columnasMapeadas = ['nombre', 'proveedor', 'fechaDeIngreso', 'fechaDeVencimiento', 'cantidad_entrada', 'precio_entrada', 'numero_de_lote'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_entrada';

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_entrada';
	}

	$modeloEntrada = new ModeloEntrada();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_entrada', 'id_entradaDeInsumo', 'id_insumo', 'id_proveedor']);

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
	$sanetizar->setHashKeys(['id_proveedor']);
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

		// Validación explícita: un campo ausente provocaba warnings de PHP y
		// TypeError no capturados (HTTP 500).
		$requeridos = ['id_insumo', 'lote', 'proveedor', 'fechaDeVencimiento', 'cantidad', 'precioD'];
		foreach ($requeridos as $campo) {
			if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => 'Faltan datos obligatorios de la entrada.']);
				exit;
			}
		}
		if (!esHashIdValido((string)$_POST['id_insumo']) || !esHashIdValido((string)$_POST['proveedor'])) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => 'Identificador inválido o manipulado.']);
			exit;
		}

		// Acepta "10.00" (punto decimal del JS) y "1.160,00" (formato local).
		$precio = parsearPrecio($_POST['precioD'] ?? '');

		$modeloEntrada->setIdInsumo(unhashId($_POST["id_insumo"]));
		$modeloEntrada->setLote($_POST["lote"]);
		$modeloEntrada->setIdProveedor(unhashId($_POST["proveedor"]));
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
			if (is_string($insercion)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $insercion]);
			} else {
				http_response_code(409);
				error_log("Error en guardar: " . print_r($insercion, true));
				echo json_encode(['ok' => false, 'error' => 'Error al guardar la entrada.']);
				exit;
			}
			exit;
		}

	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (\Throwable $e) {
		error_log("Error inesperado en guardar entrada: " . $e->getMessage());
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => 'Error al guardar la entrada.']);
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
		$id = is_array($input) ? ($input["id"] ?? null) : null;

		if (empty($id) || !esHashIdValido((string)$id)) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => 'Identificador inválido o manipulado.']);
			exit;
		}

		$estado = empty($input["estado"]) ? 'DES' : 'ACT';
		$text = empty($input["estado"]) ? 'eliminado' : 'restablecido';
		$text_error = empty($input["estado"]) ? 'eliminar' : 'restablecer';

		$modeloEntrada->setIdEntrada(unhashId($id));
		$elimincion = $modeloEntrada->eliminarEntrada($idUsuario,$estado);

		if (is_array($elimincion) && $elimincion[0] === "exito") {
			$modeloBitacora->setActividad("Ha {$text} una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			error_log("Error en eliminar: " . (is_string($elimincion) ? $elimincion : print_r($elimincion, true)));
			echo json_encode(['ok' => false, 'error' => "Error en {$text_error} le entrada."]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (\Throwable $e) {
		error_log("Error inesperado en eliminar entrada: " . $e->getMessage());
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => 'Error al eliminar la entrada.']);
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

		$requeridos = ['id_entrada', 'lote', 'proveedor', 'fechaDeVencimiento', 'cantidad', 'precioD'];
		foreach ($requeridos as $campo) {
			if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => 'Faltan datos obligatorios de la entrada.']);
				exit;
			}
		}
		if (!esHashIdValido((string)$_POST['id_entrada']) || !esHashIdValido((string)$_POST['proveedor'])) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => 'Identificador inválido o manipulado.']);
			exit;
		}

		// Acepta "10.00" (punto decimal del JS) y "1.160,00" (formato local).
		$precio = parsearPrecio($_POST['precioD'] ?? '');

		// $modeloInsumo->setIdInsumo($_POST["id_insumo"]);
		$modeloEntrada->setLote($_POST["lote"]);
		$modeloEntrada->setIdProveedor(unhashId($_POST["proveedor"]));
		$modeloEntrada->setIdEntrada(unhashId($_POST["id_entrada"]));
		// esEdicion = true: corregir una entrada antigua (vencida) es válido.
		$modeloEntrada->setFechaDeVencimiento($_POST["fechaDeVencimiento"], true);
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
			if (is_string($edicion)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $edicion]);
			} else {
				http_response_code(409);
				error_log("Error en editar: " . print_r($edicion, true));
				echo json_encode(['ok' => false, 'error' => 'Error al editar la entrada.']);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (\Throwable $e) {
		error_log("Error inesperado en editar entrada: " . $e->getMessage());
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => 'Error al editar la entrada.']);
		exit;
	}
}

function entradaInsumo()
{
	try {
		if (!isset($_GET['id_insumo']) || !esHashIdValido((string)$_GET['id_insumo'])) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => 'Identificador inválido.']);
			exit;
		}

		$modeloEntrada = new ModeloEntrada();
		$modeloInsumo = new ModeloInsumo();
		$sanetizar = new ModeloSanetizarJSON();

		$modeloInsumo->setIdInsumo(unhashId($_GET['id_insumo']));
		$sanetizar->setHashKeys(['id_entrada', 'id_entradaDeInsumo', 'id_insumo', 'id_proveedor']);
		$respuesta = $sanetizar->sanitizeRecursive($modeloEntrada->insumosEntrada());
		echo json_encode($respuesta);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}