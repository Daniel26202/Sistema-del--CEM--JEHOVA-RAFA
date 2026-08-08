<?php

use App\models\Db;
use App\models\ModeloPatologia;
use App\models\ModeloBitacora;
use App\models\ModeloPermisos;
use App\models\Validator;
// use Dotenv\Validator;

// use App\config\RateLimiter;





function patologias($parametro)
{
	$ayuda = "btnayudaPatologia";
	$vistaActiva = "patologias";
	require_once './src/vistas/vistaPatologia/patologia.php';
}

function patologiasAjax()
{
	$db = new Db();
	$validator = new Validator();
    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

    $columnasMapeadas = ['id_patologia', 'nombre_patologia'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';
    

    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_patologia';

	$modelo = new ModeloPatologia($db,$validator);    

    $data = $modelo->mostrarPatologias('ACT',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);
    echo json_encode([
        "draw"            => $draw,
        "recordsTotal"    => (int)$data['total'],
        "recordsFiltered" => (int)$data['total_filtrado'],
        "data"            => is_array($data['data']) ? $data['data'] : []
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
	$db = new Db();
	$validator = new Validator();
	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['id_patologia', 'nombre_patologia'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';


	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_patologia';

	$modelo = new ModeloPatologia($db,$validator);

	$data = $modelo->mostrarPatologias('DES',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$data['total'],
		"recordsFiltered" => (int)$data['total_filtrado'],
		"data"            => is_array($data['data'])? $data['data'] : []
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
		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);
		$modelo = new ModeloPatologia($db,$validator);
		$bitacora = new ModeloBitacora($db,$validator);

		$modelo->setNombrePatologia($_POST["patologia"]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha Insertado un nuevo patologia");
		$bitacora->setTabla("patologia");

		$insercion = $modelo->guardar($modelo->get_all(),$validator);


		if (is_array($insercion)) {
			$bitacora->guardar($bitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
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

//eliminar patologia
function eliminarPatologia($datos)
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
		$modelo = new ModeloPatologia($db, $validator);
		$bitacora = new ModeloBitacora($db, $validator);

		$modelo->setIdPatologia($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha eliminado una  patologia");
		$bitacora->setTabla("patologia");

		$eliminar = $modelo->actualizar(['estado'=>'DES'],['id_patologia'=>$modelo->getIdPatologia()],$validator);

		if (is_array($eliminar)) {
			$bitacora->guardar($bitacora->get_all(),$validator);
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


function restablecerPatologia($datos)
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
		$modelo = new ModeloPatologia($db, $validator);
		$bitacora = new ModeloBitacora($db,$validator);

		$modelo->setIdPatologia($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha restablecido una  patologia");
		$bitacora->setTabla("patologia");

		$eliminar = $modelo->actualizar(['estado'=>'ACT'],['id_patologia'=>$modelo->getIdPatologia()],$validator);

		if (is_array($eliminar)) {
			$bitacora->guardar($bitacora->get_all(),$validator);
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