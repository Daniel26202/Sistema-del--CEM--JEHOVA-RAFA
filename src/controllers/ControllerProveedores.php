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
	$modeloProveedores = new ModeloProveedores();
	echo json_encode($modeloProveedores->consultar());
}

function papelera($parametro)
{
	require_once './src/vistas/vistaProveedores/vistaProveedoresPapelera.php';
}

function proveedoresPapeleraAjax()
{
	$modeloProveedores = new ModeloProveedores();
	echo json_encode($modeloProveedores->papeleraConsultar());
}

function insertar()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	try {

		$modeloProveedores = new ModeloProveedores();
		$modeloBitacora = new ModeloBitacora();

		$modeloProveedores->setNombre($_POST["nombre"]);
		$modeloProveedores->setRif($_POST["rif"]);
		$modeloProveedores->setTelefono($_POST["telefono"]);
		$modeloProveedores->setEmail($_POST["correo"]);
		$modeloProveedores->setDireccion($_POST["direccion"]);

		$insercion = $modeloProveedores->agregar();

		if (is_array($insercion) && $insercion[0] === "exito") {
			$modeloBitacora->setActividad("Ha insertado un proveedor");
			$modeloBitacora->setTabla("proveedor");
			$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);

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
		$modeloProveedores = new ModeloProveedores();
		$modeloBitacora = new ModeloBitacora();

		$id_proveedor = $datos[0];
		$id_usuario_bitacora = $datos[1];

		$modeloProveedores->setIdProveedor($id_proveedor);
		$eliminacion = $modeloProveedores->delte();

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$modeloBitacora->setId_usuario($id_usuario_bitacora);
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
		$id_proveedor = $datos[0];
		$id_usuario_bitacora = $datos[1];

		$modeloProveedores = new ModeloProveedores();
		$modeloBitacora = new ModeloBitacora();

		$modeloProveedores->setIdProveedor($id_proveedor);
		$restablecimiento = $modeloProveedores->restablecerProveedor();

		if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {
			$modeloBitacora->setId_usuario($id_usuario_bitacora);
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
		$modeloProveedores = new ModeloProveedores();
		$modeloBitacora = new ModeloBitacora();

		$modeloProveedores->setIdProveedor($_POST["id_proveedor"]);
		$modeloProveedores->setNombre($_POST["nombre"]);
		$modeloProveedores->setRif($_POST["rif"]);
		$modeloProveedores->setTelefono($_POST["telefono"]);
		$modeloProveedores->setEmail($_POST["correo"]);
		$modeloProveedores->setDireccion($_POST["direccion"]);
		$modeloProveedores->setRifRegistrado($_POST["id_rif_oculto"]);

		$editado = $modeloProveedores->editar();


		if (is_array($editado) && $editado[0] === "exito") {
			$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
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
