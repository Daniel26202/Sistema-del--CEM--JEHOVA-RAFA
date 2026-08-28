<?php

use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloSanetizarJSON;
// use App\config\RateLimiter;





function patologias($parametro)
{
	$ayuda = "btnayudaPatologia";
	$vistaActiva = "patologias";
	require_once './src/vistas/vistaPatologia/patologia.php';
}

function patologiasAjax()
{
  
    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

    $columnasMapeadas = ['id_patologia', 'nombre_patologia'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';
    

    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_patologia';

    $modelo = new ModeloPatologia();
	$sanitizador = new ModeloSanetizarJSON();

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_patologia';
	}
    

    $patologias = $modelo->mostrarPatologias($inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	$patologiasSanetizada = $sanitizador->sanitizeRecursive($patologias);
    $totalRegistros = $modelo->contarTotalPatologias('ACT');
    $totalFiltrados = !empty($buscar) ? $modelo->contarTotalPatologias('ACT', $buscar) : $totalRegistros;

    echo json_encode([
        "draw"            => $draw,
        "recordsTotal"    => (int)$totalRegistros,
        "recordsFiltered" => (int)$totalFiltrados,
        "data"            => is_array($patologiasSanetizada) ? $patologiasSanetizada : []
    ]);
    exit;
}

function papeleraPatologias($parametro)
{
	$vistaActiva = "papelera";
	$ayuda = "btnayudaPatologia";
	require_once './src/vistas/vistaPatologia/patologia.php';
}

function papeleraAjax()
{
	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['id_patologia', 'nombre_patologia'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';


	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_patologia';
	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_patologia';
	}


	$modelo = new ModeloPatologia();
	$sanitizador = new ModeloSanetizarJSON();


	$patologias = $modelo->mostrarPatologiasEliminadas($inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	$patologiasSanetizada = $sanitizador->sanitizeRecursive($patologias);
	$totalRegistros = $modelo->contarTotalPatologias('DES');
	$totalFiltrados = !empty($buscar) ? $modelo->contarTotalPatologias('DES', $buscar) : $totalRegistros;

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$totalRegistros,
		"recordsFiltered" => (int)$totalFiltrados,
		"data"            => is_array($patologiasSanetizada) ? $patologiasSanetizada : []
	]);
	exit;
}

//insertar patologia 
function registrarPatologia()
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
		$modelo = new ModeloPatologia();
		$bitacora = new ModeloBitacora();

		$modelo->setNombrePatologia($_POST["patologia"]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha Insertado un nuevo patologia");
		$bitacora->setTabla("patologia");

		$insercion = $modelo->guardarPatologia($idUsuario);


		if (is_array($insercion) && $insercion[0] === "exito") {
			$bitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		} else {
			http_response_code(409);
			error_log("Error en registrarPatologia: " . $insercion); // Registro interno
			echo json_encode(['ok' => false, 'error' => 'Error al guardar la patologia.']);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

//eliminar patologia
function eliminarPatologia()
{

	if (empty($_GET)) {
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


		$modelo = new ModeloPatologia();
		$bitacora = new ModeloBitacora();

		$input = json_decode(file_get_contents("php://input"), true);
		$id = $input["id"] ?? null;

		$estado = empty($input["estado"]) ? 'DES' : 'ACT';
		$text = empty($input["estado"]) ? 'eliminado' : 'restablecido';
		$text_error = empty($input["estado"]) ? 'eliminar' : 'restablecer';

		$modelo->setIdPatologia($id);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha {$text} una  patologia");
		$bitacora->setTabla("patologia");

		$eliminar = $modelo->deletePatologia($idUsuario,$estado);

		if (is_array($eliminar) && $eliminar[0] === "exito") {
			$bitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			error_log("Error en {$text_error}: " . $eliminar);
			echo json_encode(['ok' => false, 'error' => "Error al {$text_error} la patologia."]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}