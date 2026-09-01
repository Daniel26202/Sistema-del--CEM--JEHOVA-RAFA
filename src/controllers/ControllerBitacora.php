<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;
use App\modelos\ModeloSanetizarJSON;


function bitacoraUsuario($parametro)
{
	$ayuda = "btnayudaBitacora";
	$vistaActiva = 'Usuario';
	$modeloInicio = new ModeloInicio(true);
	$modeloBitacora = new ModeloBitacora(false);

	$modeloInicio->setIdPersonal($_SESSION['id_personal']);
	$cargo = $modeloInicio->comprobarCargo();
	require_once __DIR__ . "/../../src/vistas/vistaBitacora/bitacora.php";
}

function bitacora($parametro)
{
	$ayuda = "btnayudaBitacora";
	$vistaActiva = 'Admin';
	$modeloInicio = new ModeloInicio(true);
	$modeloBitacora = new ModeloBitacora(false);

	$modeloInicio->setIdPersonal($_SESSION['id_personal']);
	$cargo = $modeloInicio->comprobarCargo();
	require_once __DIR__ . "/../../src/vistas/vistaBitacora/bitacora.php";
}

function permisos($id_rol, $permiso, $modulo)
{
	$permisos = new ModeloPermisos();

	return $permisos->gestionarPermisos($id_rol, $permiso, $modulo);
}

function bitacoraAjaxUser()
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
	$columnasMapeadas = ['nombre', 'usuario', 'tabla', 'actividad', 'fecha', 'hora'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'fecha_hora';
	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'fecha_hora';
	}

	$modeloBitacora = new ModeloBitacora(false);
	$modeloInicio = new ModeloInicio();
	$sanitizador = new ModeloSanetizarJSON();


	$bitacoras = $modeloBitacora->consultarBitacora($_SESSION['id_usuario'], $inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	$bitacora_sanetizada = $sanitizador->sanitizeRecursive($bitacoras);

	$totalRegistros = $modeloBitacora->contarTotalBitacora($_SESSION['id_usuario']);
	$totalFiltrados = !empty($buscar) ? $modeloBitacora->contarTotalBitacora($_SESSION['id_usuario'], $buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($bitacora_sanetizada) ? $bitacora_sanetizada : [],
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

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';


	//mapeada en el mismo orden que la tabla (para ordenar datatable)
	$columnasMapeadas = ['nombre', 'usuario', 'tabla', 'actividad', 'fecha', 'hora'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'fecha_hora';

	if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
		$ordenColumna = 'fecha_hora';
	}


	$modeloBitacora = new ModeloBitacora(false);
	$sanitizador = new ModeloSanetizarJSON();


	$bitacoras = $modeloBitacora->consultarBitacora(0,$inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	$bitacora_sanetizada = $sanitizador->sanitizeRecursive($bitacoras);

	$totalRegistros = $modeloBitacora->contarTotalBitacora(0);
	$totalFiltrados = !empty($buscar) ? $modeloBitacora->contarTotalBitacora(0,$buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($bitacora_sanetizada) ? $bitacora_sanetizada : [],
	];

	echo json_encode($response);
	exit;
}
