<?php

use App\modelos\ModeloInsumo;
use App\modelos\ModeloProveedores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;



function insumos($parametro)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$modeloInsumo = new ModeloInsumo();
	$ayuda = "btnayudaInsumo";
	$vistaActiva = "insumos";

	$proveedores = $modeloInsumo->selectProveedores();
	$insumos = $modeloInsumo->insumos();
	if ($insumos) {
		$modeloInsumo->vencerInsumos();
		//$modeloInsumo->insumoProximos();
	}
	require_once './src/vistas/vistaInsumos/vistaInsumos.php';
}

function insumosAjax()
{
	$modeloInsumo = new ModeloInsumo();
	echo json_encode($modeloInsumo->insumos());
}


function InsumosVencidos($parametro)
{
	$modeloInsumo = new ModeloInsumo();

	$ayuda = "btnayudaVencido";
	$vistaActiva = "vencidos";
	$insumos = $modeloInsumo->insumos();
	require_once './src/vistas/vistaInsumos/vistaInsumosVencidos.php';
}

function vencidos()
{
	$modeloInsumo = new ModeloInsumo();

	echo json_encode($modeloInsumo->InsumosVencidos());
}

function info($datos)
{
	$modeloInsumo = new ModeloInsumo();

	$id_insumo = $datos[0];
	$modeloInsumo->setIdInsumo($id_insumo);

	$datosDeInsumo = $modeloInsumo->insumosInfo();
	$datosDeVencimiento =  $modeloInsumo->retornarFechaDeVencimiento();
	$informacion = array(
		'insumo' => $datosDeInsumo,
		'vencimiento' => $datosDeVencimiento,
		'dolar' => $_SESSION["dolar"]
	);
	echo json_encode($informacion);
}


function mostrarBusquedaInsumo()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	$modeloInsumo = new ModeloInsumo();

	$modeloInsumo->setParametro($_POST['nombre']);

	$respuesta = $modeloInsumo->buscarInsumos();
	// $respuesta = array('nombre' => "Dixon");
	echo json_encode($respuesta);
}

function guardarInsumo()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {

		$modeloInsumo = new ModeloInsumo();
		$proveedores = new ModeloProveedores();
		$bitacora = new ModeloBitacora();



		// 1. Quitar separadores de miles
		$valor = str_replace('.', '', $_POST['precioD']);
		// 2. Cambiar coma decimal por punto
		$valor = str_replace(',', '.', $valor);
		// 3. Convertir a float
		$numero = (float)$valor;
		$iva = isset($_POST["iva"]) && $_POST["iva"] == 1 ? 1 : 0;

		if ($iva === 1) {
			$numero += $numero * 0.30;
		}

		$tiempo = new DateTime();
		$fecha = date("Y-m-d");

		 $imagen = $fecha . "_" . $tiempo->getTimestamp() . "_" . $_FILES['imagen']['name'];
		$imagen_temporal = $_FILES['imagen']['tmp_name'];
		move_uploaded_file($imagen_temporal, "./src/assets/images/img_ingresadas_por_usuarios/insumos/" . $imagen);

		$modeloInsumo->setNombre($_POST['nombre']);
		$modeloInsumo->setIdProveedor($_POST['proveedor']);
		$modeloInsumo->setDescripcion($_POST['descripcion']);
		$modeloInsumo->setFechaDeIngreso($_POST['fecha_de_ingreso']);
		$modeloInsumo->setFechaDeVencimiento($_POST['fechaDeVencimiento']);
		$modeloInsumo->setCantidad($_POST['cantidad']);
		$modeloInsumo->setStockMinimo($_POST['stockMinimo']);
		$modeloInsumo->setLote($_POST['lote']);
		$modeloInsumo->setMarca($_POST['marca']);
		$modeloInsumo->setMedida($_POST['medida']);
		$modeloInsumo->setIva($iva);
		$modeloInsumo->setImagen($imagen);
		$modeloInsumo->setPrecio($valor);


		$insercion = $modeloInsumo->insertarInsumos();

		// if (is_array($insercion) && $insercion[0] === "exito") {

		// 	$bitacora->setId_usuario($_POST['id_usuario_bitacora']);
		// 	$bitacora->setTabla("insumo");
		// 	$bitacora->setActividad("Ha Insertado un insumo");
		// 	$bitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito','data'=>$insercion]);
		// } else {
		// 	http_response_code(409);
		// 	echo json_encode(['ok' => false, 'error' => $insercion]);
		// 	exit;
		// }
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function eliminar($datos)
{
	$modeloInsumo = new ModeloInsumo();
	$bitacora = new ModeloBitacora();

	$id_insumo = $datos[0];
	$id_usuario_bitacora = $datos[1];

	$modeloInsumo->setIdInsumo($id_insumo);
	$eliminacion = $modeloInsumo->eliminar();

	if (is_array($eliminacion) && $eliminacion[0] === "exito") {
		$bitacora->setId_usuario($id_usuario_bitacora);
		$bitacora->setTabla("insumo");
		$bitacora->setActividad("Ha eliminado un insumo");
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $eliminacion]);
		exit;
	}
}

function editar()
{
	$modeloInsumo = new ModeloInsumo();
	$bitacora = new ModeloBitacora();

	$tiempo = new DateTime();
	$fecha = date("Y-m-d");
	$imagen_editar = $fecha . "_" . $tiempo->getTimestamp() . "_" . $_FILES['imagen']['name'];
	$imagen_temporal = $_FILES['imagen']['tmp_name'];
	// move_uploaded_file($imagen_temporal, "./src/assets/img_ingresadas_por_usuarios/insumos/" . $imagen_editar);

	$modeloInsumo->setIdInsumo($_POST["idInsumoOculto"]);
	$modeloInsumo->setNombre($_POST["nombre"]);
	$modeloInsumo->setDescripcion($_POST['descripcion']);
	$modeloInsumo->setStockMinimo($_POST["stockMinimo"]);
	$modeloInsumo->setMarca($_POST["marca"]);
	$modeloInsumo->setMedida($_POST["medida"]);
	$modeloInsumo->setImagenAntigua($_FILES["imagen"]);
	$modeloInsumo->setImagen($imagen_editar);

	// echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data'=>$_POST]);

	$edicion = $modeloInsumo->editar();


	if (is_array($edicion) && $edicion[0] === "exito") {

		$bitacora->setId_usuario($_POST['id_usuario_bitacora']);
		$bitacora->setTabla("insumo");
		$bitacora->setActividad("Ha modificado un insumo");
		$bitacora->insertarBitacora();

		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data'=>$edicion]);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $edicion]);
		exit;
	}
}


function papelera($parametro)
{
	require_once './src/vistas/vistaInsumos/insumosPapelera.php';
}

function papeleraInsumosAjax()
{
	$modeloInsumo = new ModeloInsumo();

	echo json_encode($modeloInsumo->papelera());
}

function restablecerInsumo($datos)
{
	$modeloInsumo = new ModeloInsumo();
	$bitacora = new ModeloBitacora();

	$id_insumo = $datos[0];
	$id_usuario_bitacora = $datos[1];
	$modeloInsumo->setIdInsumo($id_insumo);
	$restablecimiento = $modeloInsumo->restablecerInsumo();


	if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {

		$bitacora->setId_usuario($id_usuario_bitacora);
		$bitacora->setTabla("insumo");
		$bitacora->setActividad("Ha restablecido un insumo");
		$bitacora->insertarBitacora();

		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $restablecimiento]);
		exit;
	}
}

function permisos($id_rol, $permiso, $modulo)
{
	$permisos = new ModeloPermisos();
	$permisos->setIdRol($id_rol);
	$permisos->setPermiso($permiso);
	$permisos->setModulo($modulo);

	return $permisos->gestionarPermisos();
}
