<?php

use App\models\Db;
use App\models\ModeloPacientes;
use App\models\ModeloBitacora;
use App\models\Validator;

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

	$db = new Db();
	$validator = new Validator();
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

	$modelo = new ModeloPacientes($db, $validator);

	$data = $modelo->index('ACT',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $data['total'],
		"recordsFiltered" => $data['total_filtrado'],
		"data" => is_array($data['data']) ? $data['data'] : []
	];

	echo json_encode($response);
	exit;
}
/* hay q hacerlo con ajax, pero lo hice sencillo, no se si se vaya a pasar a ajax to esto, pa despues del sabado ;) */
// function getHistorialSalud($parametro)
// {
// 	$modelo = new ModeloPacientes();

// 	$vistaActiva = 'historial';
// 	require './src/vistas/vistaPacientes/pacientes.php';
// }

// function getHistorialSaludAjax()
// {
// 	if (empty($_GET)) {
// 		http_response_code(409);
// 		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
// 		exit;
// 	}
	
// 	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
// 	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
// 	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
// 	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';


// 	//mapeada en el mismo orden que la tabla (para ordenar datatable)
// 	$columnasMapeadas = ['id_paciente', 'cedula', 'nombre', 'apellido', 'telefono', 'direccion'];

// 	// capturo el índice de la columna cliqueada
// 	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
// 	// direccion (asc o desc)
// 	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';
// 	//si ordena por el id por defecto
// 	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_paciente';

// 	$modelo = new ModeloPacientes();

// 	// traigo los datos de todos los registros
// 	$pacientes = $modelo->indexHistorial($inicio, $limite, $buscar,$ordenColumna,$ordenDir);

// 	// Aqui solamente el total de registros
// 	$totalRegistros = $modelo->contarTotalHistorial();
// 	$totalFiltrados = !empty($buscar) ? $modelo->contarTotalHistorial($buscar) : $totalRegistros;

// 	// devuelvo esta estructuta (la cual es estandar para datatable)
// 	$respuesta = [
// 		"draw"            => $draw,
// 		"recordsTotal"    => (int)$totalRegistros,
// 		"recordsFiltered" => (int)$totalFiltrados,
// 		"data"            => $pacientes
// 	];

// 	echo json_encode($respuesta);
// 	exit;
// }

function papeleraPaciente($parametro)
{
	$db =new Db();
	$validator = new Validator();
	$modelo  = new ModeloPacientes($db, $validator);
	$vistaActiva = 'papelera';
	$modelo  = new ModeloPacientes($db, $validator);

	require_once './src/vistas/vistaPacientes/pacientes.php';
}

function papeleraPacienteAjax()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
		exit;
	}

	$db = new Db();
	$validator = new Validator();

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

	$modelo = new ModeloPacientes($db, $validator);

	$data = $modelo->index('DES',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $data['total'],
		"recordsFiltered" => $data['total_filtrado'],
		"data" => is_array($data['data']) ? $data['data'] : []
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
		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);
		$modelo  = new ModeloPacientes($db, $validator);
		$bitacora = new ModeloBitacora($db, $validator);

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

		$insercion = $modelo->guardar($modelo->get_all(),$validator);

		// Verifica si es un array con clave "exito"
		if (is_array($insercion)) {
			$bitacora->guardar($bitacora->get_all(), $validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insercion]);
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
		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);
		$modelo  = new ModeloPacientes($db, $validator);
		$bitacora = new ModeloBitacora($db, $validator);


		$modelo->setIdPaciente(intval($_POST['id']));
		$modelo->setNacionalidad($_POST['nacionalidad']);
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

		$edicion = $modelo->actualizar($modelo->get_all(),['id_paciente'=>$modelo->getIdPaciente()], $validator);

		//Verifica si es un array con clave "exito"
		if (is_array($edicion)) {
			$bitacora->guardar($bitacora->get_all(), $validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
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

function eliminar($datos)
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

		$modelo  = new ModeloPacientes($db, $validator);
		$bitacora = new ModeloBitacora($db, $validator);

		$modelo->setIdPaciente($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha eliminado un  paciente");
		$bitacora->setTabla("paciente");

		$eliminacion = $modelo->actualizar(['estado'=>'DES'],['id_paciente'=>$modelo->getIdPaciente()], $validator);
		//Verifica si es un array con clave "exito"
		if (is_array($eliminacion)) {
			$bitacora->guardar($bitacora->get_all(), $validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $eliminacion]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function restablecer($datos)
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
		$modelo  = new ModeloPacientes($db, $validator);
		$bitacora = new ModeloBitacora($db, $validator);

		$modelo->setIdPaciente($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha restablecido un paciente");
		$bitacora->setTabla("paciente");

		$restablecer = $modelo->actualizar(['estado' => 'ACT'], ['id_paciente' => $modelo->getIdPaciente()], $validator);

		//Verifica si es un array con clave "exito"
		if (is_array($restablecer)) {
			$bitacora->guardar($bitacora->get_all(), $validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $restablecer]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
