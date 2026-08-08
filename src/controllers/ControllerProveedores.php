<?php

use App\models\ModeloProveedores;
use App\models\ModeloBitacora;
use App\models\Db;
use App\models\Validator;

function proveedores($parametro)
{
	$ayuda = "btnayudaProveedor";
	$vistaActiva = "proveedores";
	require_once './src/vistas/vistaProveedores/vistaProveedores.php';
}

function proveedoresAjax()
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

	$columnasMapeadas = ['nombre', 'rif', 'telefono', 'correo', 'direccion'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	// direccion (asc o desc)
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_proveedor';

	$modeloProveedores = new ModeloProveedores($db, $validator);
	$data = $modeloProveedores->consultar('ACT',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);
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
	require_once './src/vistas/vistaProveedores/vistaProveedoresPapelera.php';
}

function proveedoresPapeleraAjax()
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

	$columnasMapeadas = ['nombre', 'rif', 'telefono', 'correo', 'direccion'];


	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	// direccion (asc o desc)
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_proveedor';

	$modeloProveedores = new ModeloProveedores($db,$validator);
	$data = $modeloProveedores->consultar('DES',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);

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

function insertar()
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
		$modeloProveedores = new ModeloProveedores($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);

		$modeloProveedores->setNombre($_POST["nombre"]);
		$modeloProveedores->setRif($_POST["rif"]);
		$modeloProveedores->setTelefono($_POST["telefono"]);
		$modeloProveedores->setEmail($_POST["correo"]);
		$modeloProveedores->setDireccion($_POST["direccion"]);

		$insercion = $modeloProveedores->guardar($modeloProveedores->get_all(),$validator);

		if (is_array($insercion)) {
			$modeloBitacora->setActividad("Ha insertado un proveedor");
			$modeloBitacora->setTabla("proveedor");
			$modeloBitacora->setId_usuario($idUsuario);

			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);
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

// eliminación logica
function update(array $datos)
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

		$modeloProveedores = new ModeloProveedores($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);

		$id_proveedor = $datos[0];

		$modeloProveedores->setIdProveedor($id_proveedor);
		$eliminacion = $modeloProveedores->actualizar(['estado'=>'DES'],['id_proveedor'=>$modeloProveedores->getIdProveedor()],$validator);

		if (is_array($eliminacion)) {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("proveedor");
			$modeloBitacora->setActividad("Ha eliminado un proveedor");
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);

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


function restablecerProveedor($datos)
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
		$id_proveedor = $datos[0];
		$modeloProveedores = new ModeloProveedores($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);

		$modeloProveedores->setIdProveedor($id_proveedor);
		$restablecimiento = $modeloProveedores->actualizar(['estado'=>'ACT'],['id_proveedor'=>$modeloProveedores->getIdProveedor()],$validator);

		if (is_array($restablecimiento)) {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("proveedor");
			$modeloBitacora->setActividad("Ha restablecido un proveedor");
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

		$modeloProveedores = new ModeloProveedores($db,$validator);
		$modeloBitacora = new ModeloBitacora($db,$validator);

		$modeloProveedores->setIdProveedor($_POST["id_proveedor"]);
		$modeloProveedores->setNombre($_POST["nombre"]);
		$modeloProveedores->setRif($_POST["rif"]);
		$modeloProveedores->setTelefono($_POST["telefono"]);
		$modeloProveedores->setEmail($_POST["correo"]);
		$modeloProveedores->setDireccion($_POST["direccion"]);

		$editado = $modeloProveedores->actualizar($modeloProveedores->get_all(),['id_proveedor'=>$modeloProveedores->getIdProveedor()],$validator);


		if (is_array($editado)) {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("proveedor");
			$modeloBitacora->setActividad("Ha modificado un proveedor");
			$modeloBitacora->guardar($modeloBitacora->get_all(),$validator);

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $editado]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}


// function permisos($id_rol, $permiso, $modulo)
// {
// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }
