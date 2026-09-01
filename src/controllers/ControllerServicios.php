<?php

use App\modelos\ModeloCategoria;
use App\modelos\ModeloServicios;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloSanetizarJSON;

function servicios($parametro)
{
	$vistaActiva = 'servicios';
	$ayuda = "btnayudaServicioMedico";
	require_once "./src/vistas/vistaServicios/vistaServiciosMedicos.php";
}

function papeleraServicio($parametro)
{
	$vistaActiva = 'papelera';
	require_once "./src/vistas/vistaServicios/vistaServiciosMedicos.php";
}

function datosServiciosPapelera($parametro)
{
	$modeloServicios = new ModeloServicios();
	$modeloCategoria = new ModeloCategoria();

	$doctores = $modeloServicios->mostrarDoctores();
	$categorias = $modeloCategoria->seleccionarCategoria();
	echo json_encode(["doctores" => $doctores, "categorias" => $categorias]);
}

function datosServicios($parametro)
{
	$modeloServicios = new ModeloServicios();
	$modeloCategoria = new ModeloCategoria();
	$sanitizador = new ModeloSanetizarJSON();

	$doctores = $modeloServicios->mostrarDoctores();
	$todasLasCategorias = $modeloCategoria->seleccionarCategoria();
	$data = [
		"doctores" => $doctores,
		"categorias" => $todasLasCategorias
	];
	echo json_encode($sanitizador->sanitizeRecursive($data));
}

function categoriasAjax()
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

	// mapeo de columnas
	$columnasMapeadas = ['nombre', 'precio_bolivar', 'precio_dolar', 'tipo'];
	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_servicioMedico';

	$modeloCategoria = new ModeloCategoria();

	$categorias = $modeloCategoria->seleccionarTodasLasCategoria($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	$totalRegistros = $modeloCategoria->contarTotalCategorias();
	$totalFiltrados = !empty($buscar) ? $modeloCategoria->contarTotalCategorias($buscar) : $totalRegistros;

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$totalRegistros,
		"recordsFiltered" => (int)$totalFiltrados,
		"data"            => $categorias
	]);
	exit;
}

function serviciosAjax()
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

	// mapeo de columnas
	$columnasMapeadas = ['categoria', 'precio_bolivar', 'precio_dolar', 'tipo'];
	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_servicioMedico';

	$modeloServicios = new ModeloServicios();

	$servicios = $modeloServicios->mostrarServicios($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	$totalRegistros = $modeloServicios->contarTotalServicios('ACT');
	$totalFiltrados = !empty($buscar) ? $modeloServicios->contarTotalServicios('ACT', $buscar) : $totalRegistros;

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$totalRegistros,
		"recordsFiltered" => (int)$totalFiltrados,
		"data"            => $servicios
	]);
	exit;
}

function papeleraAjax()
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

	// mapeo de columnas
	$columnasMapeadas = ['categoria', 'precio_bolivar', 'precio_dolar', 'tipo'];
	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_servicioMedico';

	$modeloServicios = new ModeloServicios();

	$servicios = $modeloServicios->mostrarServiciosDes($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	$totalRegistros = $modeloServicios->contarTotalServicios('DES');
	$totalFiltrados = !empty($buscar) ? $modeloServicios->contarTotalServicios('DES', $buscar) : $totalRegistros;

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$totalRegistros,
		"recordsFiltered" => (int)$totalFiltrados,
		"data"            => $servicios
	]);
	exit;
}

function guardar()
{

	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}


	try {
		// ✅ CSRF
        $headers = getallheaders();
        $csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;
        if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }

		$idUsuario = $_SESSION['id_usuario'];

		$servicio = new ModeloServicios();
		$bitacora = new ModeloBitacora();
		// 1. Quitar separadores de miles
		$valor =  $_POST['precioD'];

		// 2. Cambiar coma decimal por punto
		// $valor = str_replace(',', '.', $valor);

		// 3. Convertir a float
		$numero = (float)$valor;

		$servicio->setIdCategoria($_POST['id_categoria']);
		$servicio->setPrecio($numero);
		$servicio->setTipo($_POST['tipo']);

		$insercion = $servicio->guardarServicio($idUsuario);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha Insertado un nuevo servicio medico");
			$bitacora->setTabla("servicio Medico");
			$bitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		} else {
			http_response_code(409);
			error_log("Error en guardarServicio: " . $insercion);
			echo json_encode(['ok' => false, 'error' => 'Error al guardar el servicio.']);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		error_log("Error en guardar: " . $e->getMessage());
		echo json_encode(['ok' => false, 'error' => 'Error interno del servidor']);
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
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;
		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}

		$input = json_decode(file_get_contents("php://input"), true);
		$id = $input['id'] ?? null;

		$estado = empty($input["estado"]) ? 'DES' : 'ACT';
		$text = empty($input["estado"]) ? 'eliminado' : 'restablecido';
		$text_error = empty($input["estado"]) ? 'eliminar' : 'restablecer';

		$idUsuario = $_SESSION['id_usuario'];
		$servicio = new ModeloServicios();
		$bitacora = new ModeloBitacora();

		$servicio->setIdServicioMedico($id);

		$eliminacion = $servicio->eliminarServicio($idUsuario,$estado);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha {$text} un servicio medico");
			$bitacora->setTabla("servicio Medico");
			$bitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			error_log("Error en eliminarServicio: " . $eliminacion);
			echo json_encode(['ok' => false, 'error' => "Error al {$text_error} el servicio."]);
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

		$servicio = new ModeloServicios();
		$bitacora = new ModeloBitacora();

		//Quitar separadores de miles
		$valor = str_replace('.', '', $_POST['precioD']);
		//Cambiar coma decimal por punto
		$valor = str_replace(',', '.', $valor);
		$numero = (float)$valor;

		$servicio->setIdCategoria($_POST['id_categoria']);
		$servicio->setIdServicioMedico($_POST['id_servicioMedico']);
		$servicio->setPrecio($numero);
		$servicio->setTipo($_POST['tipo']);

		$edicion = $servicio->editarServicio($idUsuario);

		if (is_array($edicion) && $edicion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha modificado un servicio medico");
			$bitacora->setTabla("servicio Medico");
			$bitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			error_log("Error en editarServicio: " . $edicion);
			echo json_encode(['ok' => false, 'error' => 'Error al modificar el servicio.']);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		error_log("Error en editar: " . $e->getMessage());
		echo json_encode(['ok' => false, 'error' => 'Error interno del servidor']);
		exit;
	}
}

function mostrarEspecialidad($datos)
{
	$modeloServicio = new ModeloServicios();
	$modeloDoctor = new ModeloDoctores();
	$sanitizador = new ModeloSanetizarJSON();

	// Validar entrada
	if (!isset($datos[0]) || !is_numeric($datos[0])) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => 'ID de doctor inválido']);
		exit;
	}

	$modeloDoctor->setIdDoctor((int)$datos[0]);
	$resultado = $modeloServicio->especialidadDoctor();
	echo json_encode($sanitizador->sanitizeRecursive($resultado));
}

function registrarCategoria()
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

		$categoria = new ModeloCategoria();
		$bitacora = new ModeloBitacora();

		$categoria->setNombre($_POST["categoria"]);

		$insercion = $categoria->guardarCategoria($idUsuario);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha Insertado una nueva  categoria");
			$bitacora->setTabla("Categoria de servicio medico");
			$bitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		} else {
			http_response_code(409);
			error_log("Error en registrarCategiria: " . $insercion);
			echo json_encode(['ok' => false, 'error' => 'Error al guardar la categoria.']);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
function eliminarCategoria($datos)
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
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido eliminar']);
			exit;
		}

		$idUsuario = $_SESSION['id_usuario'];

		$input = json_decode(file_get_contents("php://input"), true);
		$id = $input['id'] ?? null;

		$estado = empty($input["estado"]) ? 'DES' : 'ACT';
		$text = empty($input["estado"]) ? 'eliminado' : 'restablecido';
		$text_error = empty($input["estado"]) ? 'eliminar' : 'restablecer';

		$categoria = new ModeloCategoria();
		$bitacora = new ModeloBitacora();

		$categoria->setIdCategoria($id);

		$eliminacion  = $categoria->eliminarCategoria($idUsuario);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha {$text} una categoria");
			$bitacora->setTabla("Categoria de servicio medico");
			$bitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			error_log("Error en eliminarCategoria: " . $eliminacion);
			echo json_encode(['ok' => false, 'error' => "Error al {$text_error} una categoria."]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}