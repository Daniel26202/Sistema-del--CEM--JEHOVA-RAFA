<?php

use App\modelos\ModeloProveedores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

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

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['nombre', 'rif', 'telefono', 'correo', 'direccion'];


	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	// direccion (asc o desc)
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_proveedor';

	$modeloProveedores = new ModeloProveedores();
	$proveedores = $modeloProveedores->consultar($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	$totalRegistros = $modeloProveedores->contarTotalProveedores('ACT');
	$totalFiltrados = !empty($buscar) ? $modeloProveedores->contarTotalProveedores('ACT', $buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($proveedores) ? $proveedores : []
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

	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['nombre', 'rif', 'telefono', 'correo', 'direccion'];


	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	// direccion (asc o desc)
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_proveedor';

	$modeloProveedores = new ModeloProveedores();
	$proveedores = $modeloProveedores->papeleraConsultar($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	$totalRegistros = $modeloProveedores->contarTotalProveedores('DES');
	$totalFiltrados = !empty($buscar) ? $modeloProveedores->contarTotalProveedores('DES', $buscar) : $totalRegistros;

	//datos que se le envia al js (esto es estandar de datatable)
	$response = [
		"draw" => $draw,
		"recordsTotal" => $totalRegistros,
		"recordsFiltered" => $totalFiltrados,
		"data" => is_array($proveedores) ? $proveedores : []
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

		$modeloProveedores = new ModeloProveedores();
		$modeloBitacora = new ModeloBitacora();

		$modeloProveedores->setNombre($_POST["nombre"]);
		$modeloProveedores->setRif($_POST["rif"]);
		$modeloProveedores->setTelefono($_POST["telefono"]);
		$modeloProveedores->setEmail($_POST["correo"]);
		$modeloProveedores->setDireccion($_POST["direccion"]);

		$insercion = $modeloProveedores->guardarEntrada($idUsuario);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$modeloBitacora->setActividad("Ha insertado un proveedor");
			$modeloBitacora->setTabla("proveedor");
			$modeloBitacora->setId_usuario($idUsuario);

			$modeloBitacora->insertarBitacora();

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

// eliminación logica
function update($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	try {
		$idUsuario = $_SESSION['id_usuario'];

		$modeloProveedores = new ModeloProveedores();
		$modeloBitacora = new ModeloBitacora();

		$id_proveedor = $datos[0];

		$modeloProveedores->setIdProveedor($id_proveedor);
		$eliminacion = $modeloProveedores->deleteEntrada($idUsuario);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("proveedor");
			$modeloBitacora->setActividad("Ha eliminado un proveedor");
			$modeloBitacora->insertarBitacora();

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

		$id_proveedor = $datos[0];
		$modeloProveedores = new ModeloProveedores();
		$modeloBitacora = new ModeloBitacora();

		$modeloProveedores->setIdProveedor($id_proveedor);
		$restablecimiento = $modeloProveedores->restablecerProveedor();

		if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("proveedor");
			$modeloBitacora->setActividad("Ha restablecido un proveedor");
			$modeloBitacora->insertarBitacora();

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

		$modeloProveedores = new ModeloProveedores();
		$modeloBitacora = new ModeloBitacora();

		$modeloProveedores->setIdProveedor($_POST["id_proveedor"]);
		$modeloProveedores->setNombre($_POST["nombre"]);
		$modeloProveedores->setRif($_POST["rif"]);
		$modeloProveedores->setTelefono($_POST["telefono"]);
		$modeloProveedores->setEmail($_POST["correo"]);
		$modeloProveedores->setDireccion($_POST["direccion"]);
		$modeloProveedores->setRifRegistrado($_POST["id_rif_oculto"]);

		$editado = $modeloProveedores->editarEntrada($idUsuario);


		if (is_array($editado) && $editado[0] === "exito") {
			$modeloBitacora->setId_usuario($idUsuario);
			$modeloBitacora->setTabla("proveedor");
			$modeloBitacora->setActividad("Ha modificado un proveedor");
			$modeloBitacora->insertarBitacora();

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
