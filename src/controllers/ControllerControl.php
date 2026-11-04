<?php

use App\modelos\ModeloControl;
use App\modelos\ModeloSintomas;
use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloInicio;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloSanetizarJSON;

function control($parametro)
{
	$modeloInicio = new ModeloInicio();

	$vistaActiva = "control";
	$ayuda = "btnayudaControl";

	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	$idPersonal = $_SESSION['id_personal'];

	$modeloInicio->setIdPersonal($idPersonal);
	$validacionCargo = $modeloInicio->comprobarCargo();

	require_once __DIR__ . "/../../src/vistas/vistaControl/vistaControl.php";
}

function returnSistomasPaciente()
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

	// Mapeo estricto del orden visual de las columnas en el JS de Citas
	$columnasMapeadas = ['id_sintomas', 'nombre'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_sintomas';

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_sintomas';
	}

	$modeloSintomas = new ModeloSintomas();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_sintomas']);

	$sintomas = $modeloSintomas->selectSintomas($inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	$sintomasSanetizados = $sanetizar->sanitizeRecursive($sintomas);

	$totalRegistros = $modeloSintomas->contarTotalSintomas('ACT');
	$totalFiltrados = !empty($buscar) ? $modeloSintomas->contarTotalSintomas('ACT', $buscar) : $totalRegistros;

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$totalRegistros,
		"recordsFiltered" => (int)$totalFiltrados,
		"data"            => is_array($sintomasSanetizados) ? $sintomasSanetizados : []
	]);
	exit;
}

function returnPatologiasPaciente()
{
	$modeloPatologia = new ModeloPatologia();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_patologia', 'id_control', 'id_paciente']);
	$data = $sanetizar->sanitizeRecursive($modeloPatologia->mostrarPatologias());
	echo json_encode($data);
}

function returnPatologiasPacienteId()
{
	$modeloPatologia = new ModeloControl();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_patologia', 'id_control', 'id_paciente']);
	$data = $sanetizar->sanitizeRecursive($modeloPatologia->mostrarPatologiaC());
	echo json_encode($data);
}

function returnDoctores()
{
	$modeloControl = new ModeloControl();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_categoria', 'id_servicioMedico', 'id_personal', 'id_usuario']);
	$data = $sanetizar->sanitizeRecursive($modeloControl->mostrarDoctor());
	echo json_encode($data);
}

function listPacientesJS()
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

	// Mapeo estricto del orden visual de las columnas en el JS de Citas
	$columnasMapeadas = ['cedula', 'nombre', 'fn', 'genero'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_paciente';
	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'id_paciente';
	}

	$modeloPaciente = new ModeloPacientes();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_paciente']);
	$pacientes = $modeloPaciente->index($inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	$data = $sanetizar->sanitizeRecursive($pacientes);


	$totalRegistros = $modeloPaciente->contarTotalPacientes('ACT');
	$totalFiltrados = !empty($buscar) ? $modeloPaciente->contarTotalPacientes('ACT', $buscar) : $totalRegistros;

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$totalRegistros,
		"recordsFiltered" => (int)$totalFiltrados,
		"data"            => is_array($data) ? $data : []
	]);
	exit;
}

function mostrarBusquedaPacientesJS($datos)
{
	try {
		if (!isset($datos[0]) || !isset($datos[1])) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => "Faltan datos (nacionalidad y cédula)."]);
			exit;
		}

		$modeloControl = new ModeloControl();
		$sanetizar = new ModeloSanetizarJSON();
		$sanetizar->setHashKeys(['id_paciente']);
		$modeloControl->setCedula($datos[0]);
		$modeloControl->setNacionalidad($datos[1]);

		$respuesta = $modeloControl->buscarPacientes();
		$data = $sanetizar->sanitizeRecursive($respuesta);
		echo json_encode($data);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function mostrarControlPacientesJS($datos)
{
	try {
		if (!isset($datos[0]) || $datos[0] === '') {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => "Falta la cedula del paciente."]);
			exit;
		}

		$modeloControl = new ModeloControl();
		$modeloSintomas = new ModeloSintomas();
		$modeloPatologia = new ModeloPatologia();
		$modeloInicio = new ModeloInicio();
		$sanetizar = new ModeloSanetizarJSON();
		$sanetizar->setHashKeys(['id_sintomas', 'id_patologia', 'id_control', 'id_paciente', 'id_usuario']);

		// verifica si la sesión esta activa.
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		$idUsuario = $_SESSION['id_usuario'];
		$modeloInicio->setIdPersonal($_SESSION['id_personal']);
		$validacionCargo = $modeloInicio->comprobarCargo();

		$cedula = $datos[0];

		$sintomas = $sanetizar->sanitizeRecursive($modeloSintomas->selects());
		// patologías
		$modeloControl->setCedula($cedula);
		$modeloPatologia->setCedulaPac($cedula);
		$registradosP = $sanetizar->sanitizeRecursive($modeloPatologia->buscarPatologiaPaciente());
		$patologias = $sanetizar->sanitizeRecursive($modeloPatologia->mostrarPatologias());

		// cero es administrador mas no doctor
		if ($validacionCargo == 0) {
			$modeloControl->setCedula($cedula);
			$respuestaP = $sanetizar->sanitizeRecursive($modeloControl->mostrarControlPacienteA());

			// este array tiene tres valores de tres funciones en el modelo
			$arrayPSS = [$respuestaP, $sintomas, $registradosP, $patologias];
			echo json_encode($arrayPSS);
			// uno es doctor
		} else if ($validacionCargo == 1) {
			// devuelve solo los datos del paciente atendido por el mismo doctor que inicio sesión(Usuario)
			$modeloControl->setIdUsuario($idUsuario);
			$modeloControl->setCedula($cedula);
			$respuesta = $sanetizar->sanitizeRecursive($modeloControl->mostrarControlPacienteU());

			// este array tiene tres valores de tres funciones en el modelo
			$arrayPSS = [$respuesta, $sintomas, $registradosP, $patologias];
			echo json_encode($arrayPSS);
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function mostrarPacienteJS($datos)
{
	try {
		if (!isset($datos[0]) || !isset($datos[1])) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => "Faltan datos (nacionalidad y cédula)."]);
			exit;
		}

		$modeloControl = new ModeloControl();
		$sanetizar = new ModeloSanetizarJSON();
		$sanetizar->setHashKeys(['id_paciente', 'id_control', 'id_usuario']);

		$modeloControl->setNacionalidad($datos[0]);
		$modeloControl->setCedula($datos[1]);
		// me traigo los datos de los pacientes
		$respuesta = $sanetizar->sanitizeRecursive($modeloControl->mostrarPaciente());

		echo json_encode($respuesta);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function insertarControl()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
		exit;
	}
	try {
		// $headers = getallheaders();
		$csrf_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? null;


		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}

		$idUsuario = $_SESSION['id_usuario'];

		$modeloBitacora = new ModeloBitacora();
		$modeloControl  = new ModeloControl();

		// Validación explícita: antes un campo ausente provocaba un TypeError
		// no capturado (HTTP 500) al llegar a unhashId().
		$requeridos = ['doctor', 'id_paciente', 'historial', 'diagnostico', 'indicaciones', 'fechaDeCita', 'severidad'];
		foreach ($requeridos as $campo) {
			if (!isset($_POST[$campo]) || ($_POST[$campo] === '' && $campo !== 'nota')) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => 'Faltan datos obligatorios del control.']);
				exit;
			}
		}
		if (!esHashIdValido((string)$_POST['doctor']) || !esHashIdValido((string)$_POST['id_paciente'])) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => 'Identificador inválido o manipulado.']);
			exit;
		}

		$patologia = isset($_POST["patologias"]) ? array_map('unhashId', (array)$_POST["patologias"]) : [null];
		$sintoma   = isset($_POST["sintomas"])   ? array_map('unhashId', (array)$_POST["sintomas"])   : [null];

		$modeloControl->setIdUsuario(unhashId($_POST["doctor"]));
		$modeloControl->setIdPaciente(unhashId($_POST["id_paciente"]));
		$modeloControl->setHistorial($_POST["historial"]);
		$modeloControl->setDiagnostico($_POST["diagnostico"]);
		$modeloControl->setSintomas($sintoma);
		$modeloControl->setIndicaciones($_POST["indicaciones"]);
		$modeloControl->setFechaRegreso($_POST["fechaDeCita"]);
		$modeloControl->setPatologias($patologia);
		$modeloControl->setNota($_POST["nota"] ?? '');
		$modeloControl->setSeveridad($_POST["severidad"]);

		$registro = $modeloControl->insertControl($idUsuario);

		if (is_array($registro) && $registro[0] === "exito") {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("control");
			$modeloBitacora->setActividad("Ha Insertado un nuevo control medico");
			$modeloBitacora->insertarBitacora($idUsuario);
			// Se devuelve solo lo que el JS necesita: devolver $_POST completo
			// filtraba a la respuesta campos internos (p. ej. el token CSRF).
			echo json_encode([
				'ok' => true,
				'message' => 'La operación se realizó con éxito',
				'data' => [
					'cedula' => $_POST['cedula'] ?? '',
					'cedulaOculta' => $_POST['cedulaOculta'] ?? '',
				]
			]);
		} else {
			if (is_string($registro)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $registro]);
			} else {
				http_response_code(409);
				error_log("Error en insertarControl: " . print_r($registro, true));
				echo json_encode(['ok' => false, 'error' => 'Error al guardar el control.']);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (\Throwable $e) {
		error_log("Error inesperado en insertarControl: " . $e->getMessage());
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => 'Error al guardar el control.']);
		exit;
	}
}

function editarControl()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
		exit;
	}
	try {
		// $headers = getallheaders();
		$csrf_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? null;


		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}

		$idUsuario = $_SESSION['id_usuario'];

		$modeloBitacora = new ModeloBitacora();
		$modeloControl  = new ModeloControl();

		$requeridos = ['id_control', 'historial', 'diagnostico', 'indicaciones', 'fechaDeCita', 'severidad'];
		foreach ($requeridos as $campo) {
			if (!isset($_POST[$campo]) || $_POST[$campo] === '') {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => 'Faltan datos obligatorios del control.']);
				exit;
			}
		}
		if (!esHashIdValido((string)$_POST['id_control'])) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => 'Identificador inválido o manipulado.']);
			exit;
		}

		$modeloControl->setIdControl(unhashId($_POST['id_control']));
		$modeloControl->setHistorial($_POST["historial"]);
		$modeloControl->setDiagnostico($_POST["diagnostico"]);
		$modeloControl->setIndicaciones($_POST["indicaciones"]);
		$modeloControl->setFechaRegreso($_POST["fechaDeCita"], true);
		$modeloControl->setNota($_POST["nota"] ?? '');
		$modeloControl->setSeveridad($_POST["severidad"]);

		$editar = $modeloControl->editarControl($idUsuario);

		if (is_array($editar) && $editar[0] === "exito") {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("control");
			$modeloBitacora->setActividad("Ha modificado un control medico");
			$modeloBitacora->insertarBitacora($idUsuario);
			echo json_encode([
				'ok' => true,
				'message' => 'La operación se realizó con éxito',
				'data' => [
					'cedula' => $_POST['cedula'] ?? '',
					'cedulaOculta' => $_POST['cedulaOculta'] ?? '',
				]
			]);
		} else {
			if (is_string($editar)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $editar]);
			} else {
				http_response_code(409);
				error_log("Error en editarControl: " . print_r($editar, true));
				echo json_encode(['ok' => false, 'error' => 'Error al editar el control.']);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (\Throwable $e) {
		error_log("Error inesperado en editarControl: " . $e->getMessage());
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => 'Error al editar el control.']);
		exit;
	}
}

// mostrar síntomas de pacientes del ultimo  control
function mostrarSP($datos)
{
	try {
		if (!isset($datos[0]) || $datos[0] === '') {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => "Falta la cedula del paciente."]);
			exit;
		}

		$modeloControl = new ModeloControl();
		$sanetizar = new ModeloSanetizarJSON();
		$sanetizar->setHashKeys(['id_sintomas', 'id_control']);
		$cedula = $datos[0];

		$modeloControl->setCedula($cedula);
		$idControl = $modeloControl->mostrarUltimoIdControl();
		if ($idControl === null) {
			echo json_encode([]);
			exit;
		}
		$modeloControl->setIdControl($idControl);

		$respuestaS = $sanetizar->sanitizeRecursive($modeloControl->mostrarSintomasPaId());
		echo json_encode($respuestaS);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
// mostrar patología de pacientes del ultimo  control
function mostrarPP($datos)
{
	try {
		if (!isset($datos[0]) || $datos[0] === '') {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => "Falta la cedula del paciente."]);
			exit;
		}

		$modeloControl = new ModeloControl();
		$sanetizar  = new ModeloSanetizarJSON();
		$sanetizar->setHashKeys(['id_patologia', 'id_control']);
		$cedula = $datos[0];

		$modeloControl->setCedula($cedula);

		$id_control = ($modeloControl->mostrarUltimoIdControl() != null) ? $modeloControl->mostrarUltimoIdControl() : 0;
		$modeloControl->setIdControl($id_control);

		$registradosP = $sanetizar->sanitizeRecursive($modeloControl->mostrarPatologiaP());
		echo json_encode($registradosP);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}


// mostrar síntomas de pacientes 
function mostrarSPAll($datos)
{
	$modeloControl = new ModeloControl();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_sintomas', 'id_control']);
	$modeloControl->setIdControl(unhashId($datos[0]));

	$respuestaS = $sanetizar->sanitizeRecursive($modeloControl->mostrarSintomasPaId());
	echo json_encode($respuestaS);
}
// mostrar patología de pacientes
function mostrarPPAll($datos)
{
	$modeloControl = new ModeloControl();
	$sanetizar = new ModeloSanetizarJSON();
	$sanetizar->setHashKeys(['id_patologia', 'id_control']);
	$modeloControl->setIdControl(unhashId($datos[0]));

	$registradosP = $sanetizar->sanitizeRecursive($modeloControl->mostrarPatologiaP());
	echo json_encode($registradosP);
}



// mostrar patología de paciente por id del paciente
function mostrarPIdP($datos)
{
	try {
		if (!isset($datos[0]) || !esHashIdValido((string)$datos[0])) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => "Identificador inválido."]);
			exit;
		}

		$modeloControl = new ModeloControl();
		$sanetizar = new ModeloSanetizarJSON();

		$idC = $datos[0];
		$modeloControl->setIdControl(unhashId($idC));
		$registradosP = $sanetizar->sanitizeRecursive($modeloControl->mostrarPatologiaC());
		echo json_encode($registradosP);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

// síntomas
function eliminarSintoma($datos)
{

	try {
		$input = json_decode(file_get_contents("php://input"), true);
		$id = is_array($input) ? ($input["id"] ?? null) : null;

		if (empty($id) || !esHashIdValido((string)$id)) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => 'Identificador inválido o manipulado.']);
			exit;
		}

		// $headers = getallheaders();
		$csrf_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? null;


		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}

		$idUsuario = $_SESSION['id_usuario'];
		$modeloSintomas = new ModeloSintomas();
		$modeloBitacora = new ModeloBitacora();

		$modeloSintomas->setIdSintomas(unhashId($id));
		$eliminar = $modeloSintomas->eliminarL();

		if (is_array($eliminar) && $eliminar[0] === "exito") {
			// Guardar la bitacora
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("sintomas");
			$modeloBitacora->setActividad("Ha eliminado un  sintoma");
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			if (is_string($eliminar)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $eliminar]);
			} else {
				http_response_code(409);
				error_log("Error en eliminarSintoma: " . print_r($eliminar, true));
				echo json_encode(['ok' => false, 'error' => 'Error al eliminar el sintoma.']);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (\Throwable $e) {
		error_log("Error inesperado en eliminarSintoma: " . $e->getMessage());
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => 'Error al eliminar el sintoma.']);
		exit;
	}
}

function agregarSintoma()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		if (!isset($_POST["nombre"]) || trim($_POST["nombre"]) === '') {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => 'El nombre del síntoma es obligatorio.']);
			exit;
		}

		// $headers = getallheaders();
		$csrf_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? null;


		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}

		$idUsuario = $_SESSION['id_usuario'];

		$modeloSintomas = new ModeloSintomas();
		$modeloBitacora = new ModeloBitacora();

		$modeloSintomas->setNombre($_POST["nombre"]);
		$insertar = $modeloSintomas->insertar();
		if ($insertar) {
			// Guardar la bitacora
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("sintomas");
			$modeloBitacora->setActividad("Ha Insertado un  sintoma");
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => ['nombre' => $_POST['nombre']]]);
		} else {
			if (is_string($insertar)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $insertar]);
			} else {
				http_response_code(409);
				error_log("Error en agregarSintoma: " . print_r($insertar, true));
				echo json_encode(['ok' => false, 'error' => 'Error al guardar el sintoma.']);
				exit;
			}
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	} catch (\Throwable $e) {
		error_log("Error inesperado en agregarSintoma: " . $e->getMessage());
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => 'Error al guardar el sintoma.']);
		exit;
	}
}
