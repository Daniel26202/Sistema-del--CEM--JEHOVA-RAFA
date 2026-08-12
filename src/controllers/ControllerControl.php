<?php

use App\models\ModeloControl;
use App\models\ModeloSintomas;
use App\models\ModeloPatologia;
use App\models\ModeloBitacora;
use App\models\ModeloPermisos;
use App\models\ModeloInicio;
use App\models\ModeloPacientes;
use App\models\Db;
use App\models\Validator;

function control($parametro)
{
	$db = new Db();

	$modeloInicio = new ModeloInicio($db);

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

	$db = new Db();

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	// Mapeo estricto del orden visual de las columnas en el JS de Citas
	$columnasMapeadas = ['id_sintomas', 'nombre'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_sintomas';

	$modeloSintomas = new ModeloSintomas($db);

	$data = $modeloSintomas->selectSintomas($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$data['total'],
		"recordsFiltered" => (int)$data['total_filtrado'],
		"data"            => is_array($data['data']) ? $data['data'] :[]
	]);
	exit;
}

function returnPatologiasPaciente()
{
	$db = new Db();
	$modeloPatologia = new ModeloPatologia($db);
	echo json_encode($modeloPatologia->mostrarPatologias());
}

function returnPatologiasPacienteId()
{
	$db = new Db();
	$modeloPatologia = new ModeloControl($db);
	echo json_encode($modeloPatologia->mostrarPatologiaC());
}

function returnDoctores()
{
	$db = new Db();
	$modeloControl = new ModeloControl($db);
	// echo json_encode($modeloControl->mostrarDoctor());
	echo json_encode([]);
}

function listPacientesJS()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}

	$db = new Db();

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	// Mapeo estricto del orden visual de las columnas en el JS de Citas
	$columnasMapeadas = ['cedula','nombre','fn','genero'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_paciente';

	$modeloPaciente = new ModeloPacientes($db);
	$data = $modeloPaciente->index('ACT',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$data['total'],
		"recordsFiltered" => (int)$data['total_filtrado'],
		"data"            => is_array($data['data']) ? $data['data'] :[]
	]);
	exit;
}

function mostrarBusquedaPacientesJS($datos)
{
	$db = new Db();
	$modeloControl = new ModeloControl($db);
	$modeloControl->setCedula($datos[0]);
	$modeloControl->setNacionalidad($datos[1]);

	// $respuesta = $modeloControl->buscarPacientes();
	$respuesta =[];
	echo json_encode($respuesta);
}

function mostrarControlPacientesJS($datos)
{
	$db = new Db();
	$modeloControl = new ModeloControl($db);
	$modeloSintomas = new ModeloSintomas($db);
	$modeloPatologia = new ModeloPatologia($db);
	$modeloInicio = new ModeloInicio($db);

	// verifica si la sesión esta activa.
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	$idUsuario = $_SESSION['id_usuario'];
	$modeloInicio->setIdPersonal($_SESSION['id_personal']);
	$validacionCargo = $modeloInicio->comprobarCargo();

	$cedula = $datos[0];

	$sintomas = $modeloSintomas->selects();
	// patologías
	$modeloControl->setCedula($cedula);
	// $registradosP = $modeloPatologia->buscarPatologiaPaciente();
	$registradosP =[];
	$patologias = $modeloPatologia->mostrarPatologias();

	// cero es administrador mas no doctor 
	if ($validacionCargo == 0) {
		$modeloControl->setCedula($cedula);
		$respuestaP = $modeloControl->mostrarControlPacienteA();

		// este array tiene tres valores de tres funciones en el modelo
		$arrayPSS = [$respuestaP, $sintomas, $registradosP, $patologias];
		echo json_encode($arrayPSS);
		// uno es doctor
	} else if ($validacionCargo == 1) {
		// devuelve solo los datos del paciente atendido por el mismo doctor que inicio sesión(Usuario)
		$modeloControl->setIdUsuario($idUsuario);
		$modeloControl->setCedula($cedula);
		$respuesta = $modeloControl->mostrarControlPacienteU();

		// este array tiene tres valores de tres funciones en el modelo
		$arrayPSS = [$respuesta, $sintomas, $registradosP, $patologias];
		echo json_encode($arrayPSS);
	}
}

function mostrarPacienteJS($datos)
{
	$db = new Db();
	$validator = new Validator();
	$modeloControl = new ModeloControl($db,$validator);
	$modeloControl->setNacionalidad($datos[0]);
	$modeloControl->setCedula($datos[1]);
	// me traigo los datos de los pacientes
	// $respuesta = $modeloControl->mostrarPaciente();
	$respuesta =[];

	echo json_encode($respuesta);
}

function insertarControl()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la peticion :("]);
		exit;
	}
	try {
		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);

		$modeloBitacora = new ModeloBitacora($db,$validator);
		$modeloControl  = new ModeloControl($db,$validator);

		$patologia = isset($_POST["patologias"]) ? $_POST["patologias"] : [null];
		$sintoma   = isset($_POST["sintomas"])   ? $_POST["sintomas"]   : [null];

		$modeloControl->setIdUsuario($_POST["doctor"]);
		$modeloControl->setIdPaciente($_POST["id_paciente"]);
		$modeloControl->setHistorial($_POST["historial"]);
		$modeloControl->setDiagnostico($_POST["diagnostico"]);
		$modeloControl->setSintomas($sintoma);
		$modeloControl->setIndicaciones($_POST["indicaciones"]);
		$modeloControl->setFechaRegreso($_POST["fechaDeCita"]);
		$modeloControl->setPatologias($patologia);
		$modeloControl->setNota($_POST["nota"]);
		$modeloControl->setSeveridad($_POST["severidad"]);

		$registro = $modeloControl->insertControl();

		if (is_array($registro)) {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("control");
			$modeloBitacora->setActividad("Ha Insertado un nuevo control medico");
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $registro]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
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
		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);
		$modeloBitacora = new ModeloBitacora($db,$validator);
		$modeloControl  = new ModeloControl($db,$validator);

		$modeloControl->setIdControl($_POST['id_control']);
		$modeloControl->setHistorial($_POST["historial"]);
		$modeloControl->setDiagnostico($_POST["diagnostico"]);
		$modeloControl->setIndicaciones($_POST["indicaciones"]);
		$modeloControl->setFechaRegreso($_POST["fechaDeCita"]);
		$modeloControl->setNota($_POST["nota"]);
		$modeloControl->setSeveridad($_POST["severidad"]);

		$editar = $modeloControl->editarControl();

		if (is_array($editar)) {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("control");
			$modeloBitacora->setActividad("Ha modificado un control medico");
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $editar]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

// mostrar síntomas de pacientes del ultimo  control
function mostrarSP($datos)
{
	$db = new Db();
	$modeloControl = new ModeloControl($db);
	$cedula = $datos[0];

	$modeloControl->setCedula($cedula);
	$modeloControl->setIdControl($modeloControl->mostrarUltimoIdControl());

	$respuestaS = $modeloControl->mostrarSintomasPaId();
	echo json_encode($respuestaS);
}
// mostrar patología de pacientes del ultimo  control
function mostrarPP($datos)
{
	$db = new Db();
	$modeloControl = new ModeloControl($db);
	$cedula = $datos[0];
	$modeloControl->setCedula($cedula);

	$id_control = ($modeloControl->mostrarUltimoIdControl() != null) ? $modeloControl->mostrarUltimoIdControl() : 0;
	$modeloControl->setIdControl($id_control);

	// $registradosP = $modeloControl->mostrarPatologiaP();
	$respuestaP =[];
	echo json_encode($registradosP);
}


// mostrar síntomas de pacientes 
function mostrarSPAll($datos)
{
	$db = new Db();
	$modeloControl = new ModeloControl($db);
	$modeloControl->setIdControl($datos[0]);

	$respuestaS = $modeloControl->mostrarSintomasPaId();
	echo json_encode($respuestaS);
}
// mostrar patología de pacientes
function mostrarPPAll($datos)
{
	$db = new Db();
	$modeloControl = new ModeloControl($db);
	$modeloControl->setIdControl($datos[0]);

	// $registradosP = $modeloControl->mostrarPatologiaP();
	$registradosP =[];
	echo json_encode($registradosP);
}



// mostrar patología de paciente por id del paciente
function mostrarPIdP($datos)
{
	$db = new Db();
	$modeloControl = new ModeloControl($db);

	$idC = $datos[0];
	$modeloControl->setIdControl($idC);
	$registradosP = $modeloControl->mostrarPatologiaC();
	echo json_encode($registradosP);
}

// síntomas 
function eliminarSintoma($datos)
{

	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {

		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);

		$modeloSintomas = new ModeloSintomas($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);


		$id_sintomas = $datos[0];
		$modeloSintomas->setIdSintomas($id_sintomas);
		$eliminar = $modeloSintomas->actualizar(['estado'=>'DES'],['id_sintomas'=>$modeloSintomas->getIdSintoma()],$validator);

		if (is_array($eliminar)) {
			// Guardar la bitacora
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("sintomas");
			$modeloBitacora->setActividad("Ha eliminado un  sintoma");
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $eliminar]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
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

		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);

		$modeloSintomas = new ModeloSintomas($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);

		$modeloSintomas->setNombre($_POST["nombre"]);
		$insertar = $modeloSintomas->guardar($modeloSintomas->get_all(),$validator);
		if ($insertar) {
			// Guardar la bitacora
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("sintomas");
			$modeloBitacora->setActividad("Ha Insertado un  sintoma");
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insertar]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}