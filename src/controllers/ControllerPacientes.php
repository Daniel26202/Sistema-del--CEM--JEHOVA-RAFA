<?php

use App\modelos\ModeloPacientes;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloSanetizarJSON;
// use App\


function getPacientes($parametro)
{
	$ayuda = "btnayudaPaciente";
	$vistaActiva = 'pacientes';
	require_once './src/vistas/vistaPacientes/pacientes.php';
}

function getPacientesAjax()
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


	//mapeada en el mismo orden que la tabla (para ordenar datatable)
	$columnasMapeadas = ['id_paciente', 'cedula', 'nombre', 'apellido', 'telefono', 'direccion'];

	// capturo el índice de la columna cliqueada
	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	// direccion (asc o desc)
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';
	//si ordena por el id por defecto
	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_paciente';

	$modelo = new ModeloPacientes();
	$sanitizador = new ModeloSanetizarJSON();

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_paciente';
	}
	$pacientes = $modelo->index($inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	$pacientesSanitizados = $sanitizador->sanitizeRecursive($pacientes);

	$totalRegistros = $modelo->contarTotalPacientes('ACT');
	$totalFiltrados = !empty($buscar) ? $modelo->contarTotalPacientes('ACT', $buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($pacientesSanitizados) ? $pacientesSanitizados : []
	];

	echo json_encode($response);
	exit;
}

/* hay q hacerlo con ajax, pero lo hice sencillo, no se si se vaya a pasar a ajax to esto, pa despues del sabado ;) */
function getHistorialSalud($parametro)
{
	$modelo = new ModeloPacientes();

	$vistaActiva = 'historial';
	require './src/vistas/vistaPacientes/pacientes.php';
}

function getHistorialSaludAjax()
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


	//mapeada en el mismo orden que la tabla (para ordenar datatable)
	$columnasMapeadas = ['id_paciente', 'cedula', 'nombre', 'apellido', 'telefono', 'direccion'];

	// capturo el índice de la columna cliqueada
	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	// direccion (asc o desc)
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';
	//si ordena por el id por defecto
	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_paciente';

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_paciente';
	}

	$modelo = new ModeloPacientes();
	$sanitizador = new ModeloSanetizarJSON();

	// traigo los datos de todos los registros
	$pacientes = $modelo->indexHistorial($inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	$pacientesSanitizados = $sanitizador->sanitizeRecursive($pacientes);

	// Aqui solamente el total de registros
	$totalRegistros = $modelo->contarTotalHistorial();
	$totalFiltrados = !empty($buscar) ? $modelo->contarTotalHistorial($buscar) : $totalRegistros;

	// devuelvo esta estructuta (la cual es estandar para datatable)
	$respuesta = [
		"draw"            => $draw,
		"recordsTotal"    => (int)$totalRegistros,
		"recordsFiltered" => (int)$totalFiltrados,
		"data"            => is_array($pacientesSanitizados) ? $pacientesSanitizados : []
	];

	echo json_encode($respuesta);
	exit;
}

function papeleraPaciente($parametro)
{

	$modelo  = new ModeloPacientes();
	$vistaActiva = 'papelera';
	$modelo  = new ModeloPacientes();

	$pacientes = $modelo->indexPapelera();
	require_once './src/vistas/vistaPacientes/pacientes.php';
}

function papeleraPacienteAjax()
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


	//mapeada en el mismo orden que la tabla (para ordenar datatable)
	$columnasMapeadas = ['id_paciente', 'cedula', 'nombre', 'apellido', 'telefono', 'direccion'];

	// capturo el índice de la columna cliqueada
	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	// direccion (asc o desc)
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';
	//si ordena por el id por defecto
	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_paciente';
	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_paciente';
	}

	$modelo = new ModeloPacientes();
	$sanitizador = new ModeloSanetizarJSON();

	$pacientes = $modelo->indexPapelera($inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	$pacientesSanitizados = $sanitizador->sanitizeRecursive($pacientes);



	$totalRegistros = $modelo->contarTotalPacientes('DES');
	$totalFiltrados = !empty($buscar) ? $modelo->contarTotalPacientes('DES', $buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($pacientesSanitizados) ? $pacientesSanitizados : []
	];

	echo json_encode($response);
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
		// Validar CSRF token
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}
		$idUsuario = $_SESSION['id_usuario'];

		$modelo  = new ModeloPacientes();
		$bitacora = new ModeloBitacora();

		$modelo->setNacionalidad(isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : 'V');
		$modelo->setCedula($_POST['cedula']);
		$modelo->setNombre($_POST['nombre']);
		$modelo->setApellido($_POST['apellido']);
		$modelo->setTelefono($_POST['telefono']);
		$modelo->setDireccion($_POST['direccion']);
		$modelo->setFn($_POST['fn']);
		$modelo->setGenero($_POST['genero']);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha Insertado un nuevo paciente");
		$bitacora->setTabla("paciente");

		$insercion = $modelo->guardarPaciente($idUsuario);

		// Verifica si es un array con clave "exito"
		if (is_array($insercion) && $insercion[0] === "exito") {
			$bitacora->insertarBitacora($idUsuario);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		} else {
			// error especifico
			if (is_string($insercion)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $insercion]);
			} else {
				//error generico
				http_response_code(409);
				error_log("Error en guardarPaciente: " . print_r($insercion, true));
				echo json_encode(['ok' => false, 'error' => 'Error al guardar el paciente.']);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}


function setPaciente()
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

		$modelo  = new ModeloPacientes();
		$bitacora = new ModeloBitacora();


		$modelo->setIdPaciente(intval($_POST['id']));
		$modelo->setNacionalidad($_POST['nacionalidad']);
		$modelo->setCedulaRegistrada($_POST['cedulaRegistrada']);
		$modelo->setCedula($_POST['cedula']);
		$modelo->setNombre($_POST['nombre']);
		$modelo->setApellido($_POST['apellido']);
		$modelo->setTelefono($_POST['telefono']);
		$modelo->setDireccion($_POST['direccion']);
		$modelo->setFn($_POST['fn']);
		$modelo->setGenero($_POST['genero']);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha modificado un paciente");
		$bitacora->setTabla("paciente");

		$edicion = $modelo->editarPaciente($idUsuario);


		//Verifica si es un array con clave "exito"
		if (is_array($edicion) && $edicion[0] === "exito") {
			$bitacora->insertarBitacora($idUsuario);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			if (is_string($edicion)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $edicion]);
			} else {
				http_response_code(409);
				error_log("Error en setPaciente: " . print_r($edicion, true));
				echo json_encode(['ok' => false, 'error' => 'Error al editar el paciente.']);
				exit;
			}
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

		$modelo  = new ModeloPacientes();
		$bitacora = new ModeloBitacora();

		$input = json_decode(file_get_contents("php://input"), true);
		$id = $input["id"] ?? null;

		$estado = empty($input["estado"]) ? 'DES' : 'ACT';
		$text = empty($input["estado"]) ? 'eliminado' : 'restablecido';
		$text_error = empty($input["estado"]) ? 'eliminar' : 'restablecer';


		$modelo->setIdPaciente($id);

		$eliminacion = $modelo->eliminarPaciente($idUsuario, $estado);

		//Verifica si es un array con clave "exito"
		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha {$text} un  paciente");
			$bitacora->setTabla("paciente");
			$bitacora->insertarBitacora($idUsuario);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			if (is_string($eliminacion)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $eliminacion]);
			} else {
				http_response_code(409);
				error_log("Error en eliminar: " . print_r($eliminacion, true));
				echo json_encode(['ok' => false, 'error' => "Error al {$text_error} el paciente."]);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
