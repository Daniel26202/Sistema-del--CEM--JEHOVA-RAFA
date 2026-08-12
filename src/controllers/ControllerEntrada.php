<?php

use App\models\ModeloEntrada;
use App\models\ModeloInsumo;
use App\models\ModeloBitacora;
use App\models\ModeloPermisos;
use App\models\Db;
use App\models\Validator;


function entrada($parametro)
{
	$db = new Db();
	$modeloEntrada = new ModeloEntrada($db);
	$ayuda = "btnayudaEntrada";
	$vistaActiva = "entradas";
	// $insumos = $modeloEntrada->insumos();
	// $proveedores = $modeloEntrada->selectProveedores();
	require_once './src/vistas/vistaEntrada/vistaEntrada.php';
}

function entradasAjax()
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

	$columnasMapeadas = ['i.nombre', 'proveedor', 'fechDeIngreso', 'fechaDeVencimiento', 'cantidad_entrada', 'precio_entrada', 'numero_de_lote'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_entrada';

	$modeloEntrada = new ModeloEntrada($db);

	$data = $modeloEntrada->todasLasEntradas('ACT',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);

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

function papelera($parametro)
{
	$db = new Db();
	$validator = new Validator();
	$modeloEntrada = new ModeloEntrada($db, $validator);
	// $insumos = $modeloEntrada->insumos();
	require_once './src/vistas/vistaEntrada/vistaEntradaDesactiva.php';
}

function entradasPapeleraAjax()
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

	$columnasMapeadas = ['nombre', 'proveedor', 'fechDeIngreso', 'fechaDeVencimiento', 'cantidad_entrada', 'precio_entrada', 'numero_de_lote'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_entrada';

	$modeloEntrada = new ModeloEntrada($db, $validator);

	$data = $modeloEntrada->todasLasEntradas('DES',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);

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

function restablecerEntrada($datos)
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
		$modeloEntrada = new ModeloEntrada($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);

		$id_entrada = $datos[0];

		$modeloEntrada->setIdEntrada($id_entrada);
		$restablecimiento = $modeloEntrada->actualizar(['estado'=>'ACT'],['id_entrada'=>$modeloEntrada->getIdEntrada()],$validator);


		if (is_array($restablecimiento)) {

			$modeloBitacora->setActividad("Ha restablecido una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $restablecimiento]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
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
		$modeloEntrada = new ModeloEntrada($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);

		// Quitar separadores de miles
		$valor = str_replace('.', '', $_POST['precioD']);
		//Cambiar coma decimal por punto
		$valor = str_replace(',', '.', $valor);
		$precio = (float)$valor;

		$modeloEntrada->setLote($_POST["lote"]);
		$modeloEntrada->setFechaDeIngreso(date("Y-m-d"));
		$modeloEntrada->setFechaDeVencimiento($_POST["fechaDeVencimiento"]);
		$modeloEntrada->setCantidadDisponible($_POST["cantidad"]);
		$modeloEntrada->setPrecio($precio);

		$insercion = $modeloEntrada->guardar($modeloEntrada->get_all(),$validator);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$modeloBitacora->setActividad("Ha insertado una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insercion]);
			exit;
		}

		// echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);

	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function eliminar(array $datos)
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
		$modeloEntrada = new ModeloEntrada($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);

		$id_entrada = $datos[0];

		$modeloEntrada->setIdEntrada($id_entrada);
		$elimincion = $modeloEntrada->actualizar(['estado'=>'DES'],['id_entrada'=>$modeloEntrada->getIdEntrada()],$validator);

		if (is_array($elimincion) && $elimincion[0] === "exito") {
			$modeloBitacora->setActividad("Ha eliminado una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $elimincion]);
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

		$idUsuario = $_SESSION['id_usuario'];
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);
		$modeloEntrada = new ModeloEntrada($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);

		//Quitar separadores de miles
		$valor = str_replace('.', '', $_POST['precioD']);
		//Cambiar coma decimal por punto
		$valor = str_replace(',', '.', $valor);
		$precio = (float)$valor;

		// $modeloInsumo->setIdInsumo($_POST["id_insumo"]);
		$modeloEntrada->setLote($_POST["lote"]);
		// $modeloEntrada->setIdProveedor($_POST["proveedor"]);
		$modeloEntrada->setIdEntrada($_POST["id_entrada"]);
		$modeloEntrada->setFechaDeVencimiento($_POST["fechaDeVencimiento"]);
		$modeloEntrada->setCantidadEntrante($_POST["cantidad"]);
		$modeloEntrada->setPrecio($precio);

		$edicion = $modeloEntrada->actualizar($modeloEntrada->get_all(),['id_entrada'=>$modeloEntrada->get_all()],$validator);

		if (is_array($edicion) && $edicion[0] === "exito") {
			$modeloBitacora->setActividad("Ha modificado una entrada");
			$modeloBitacora->setTabla("entrada");
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $edicion]);
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

function entradaInsumo()
{
	$db = new Db();
	$validator = new Validator();
	$modeloEntrada = new ModeloEntrada($db,$validator);
	$modeloInsumo = new ModeloInsumo($db,$validator);

	$modeloInsumo->setIdInsumo($_GET['id_insumo']);
	// $respuesta = $modeloEntrada->insumosEntrada();
	echo json_encode([]);
}