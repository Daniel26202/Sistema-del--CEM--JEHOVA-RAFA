<?php

use App\models\Db;
use App\models\ModeloBitacora;
use App\models\ModeloPermisos;
use App\models\ModeloInicio;
use App\models\Validator;

function bitacoraUsuario($parametro)
{
	$ayuda = "btnayudaBitacora";
	$vistaActiva = 'Usuario';
	$db = new Db();
	$validator = new Validator();
	$modeloInicio = new ModeloInicio($db);
	$modeloBitacora = new ModeloBitacora($db, $validator);

	$modeloInicio->setIdPersonal($_SESSION['id_personal']);
	$cargo = $modeloInicio->comprobarCargo();
	require_once __DIR__ . "/../../src/vistas/vistaBitacora/bitacora.php";
}

function bitacora($parametro)
{
	$ayuda = "btnayudaBitacora";
	$vistaActiva = 'Admin';
	$db = new Db();
	$validator = new Validator();
	$modeloInicio = new ModeloInicio($db);
	$modeloBitacora = new ModeloBitacora($db, $validator);

	$modeloInicio->setIdPersonal($_SESSION['id_personal']);
	$cargo = $modeloInicio->comprobarCargo();
	require_once __DIR__ . "/../../src/vistas/vistaBitacora/bitacora.php";
}

function permisos($id_rol, $permiso, $modulo)
{
	$db = new Db();
	$permisos = new ModeloPermisos($db);

	return $permisos->gestionarPermisos($id_rol, $permiso, $modulo);
}

function bitacoraAjaxUser()
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
	$columnasMapeadas = ['nombre', 'usuario', 'tabla', 'actividad', 'fecha', 'hora'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'fecha_hora';


	$modeloBitacora = new ModeloBitacora($db, $validator);
	$modeloInicio = new ModeloInicio($db);

	$data = $modeloBitacora->consultarBitacora($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $data['total'],
		"recordsFiltered" => $data['total_filtrado'],
		"data" => is_array($data['data']) ? $data['data'] : [],
	];

	echo json_encode($response);
	exit;
}

function bitacoraAjaxAdmin()
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
	$columnasMapeadas = ['nombre', 'usuario', 'tabla', 'actividad', 'fecha', 'hora'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'fecha_hora';


	$modeloBitacora = new ModeloBitacora($db, $validator);

	$data = $modeloBitacora->consultarBitacora($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $data['total'],
		"recordsFiltered" => $data['total_filtrado'],
		"data" => is_array($data['data']) ? $data['data'] : [],
	];

	echo json_encode($response);
	exit;
}
