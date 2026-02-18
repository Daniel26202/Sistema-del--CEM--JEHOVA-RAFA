<?php

use App\modelos\ModeloCategoria;
use App\modelos\ModeloServicios;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloPermisos;

function servicios($parametro)
{
	$ayuda = "btnayudaServicioMedico";
	require_once "./src/vistas/vistaServicios/vistaServiciosMedicos.php";
}

function papeleraServicio($parametro)
{
	require_once "./src/vistas/vistaServicios/vistaServiciosPapelera.php";
}

function datosServiciosPapelera($parametro)
{
	$modeloServicios = new ModeloServicios();
	$modeloCategoria = new ModeloCategoria();

	$doctores = $modeloServicios->mostrarDoctores();
	$categorias = $modeloCategoria->seleccionarCategoria();
	echo json_encode(["doctores" => $doctores, "categorias" => $categorias]);
}

function datosServicios($parametro)
{
	$modeloServicios = new ModeloServicios();
	$modeloCategoria = new ModeloCategoria();

	$doctores = $modeloServicios->mostrarDoctores();
	$todasLasCategorias = $modeloCategoria->seleccionarTodasLasCategoria();
	echo json_encode(["doctores" => $doctores, "categorias" => $todasLasCategorias]);
}

function categoriasAjax()
{
	$modeloCategoria = new ModeloCategoria();

	echo json_encode($modeloCategoria->seleccionarCategoria());
}

function serviciosAjax()
{
	$modeloServicios = new ModeloServicios();

	echo json_encode($modeloServicios->mostrarServicios());
}

function papeleraAjax()
{
	$modeloServicios = new ModeloServicios();
	echo json_encode($modeloServicios->mostrarServiciosDes());
}

function guardar()
{

	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$servicio = new ModeloServicios();
	$bitacora = new ModeloBitacora();
	// 1. Quitar separadores de miles
	$valor =  $_POST['precioD'];

	// 2. Cambiar coma decimal por punto
	// $valor = str_replace(',', '.', $valor);

	// 3. Convertir a float
	$numero = (float)$valor;

	$servicio->setIdCategoria($_POST['id_categoria']);
	$servicio->setPrecio($numero);
	$servicio->setTipo($_POST['tipo']);

	$bitacora->setId_usuario($_POST['id_usuario']);
	$bitacora->setActividad("Ha Insertado un nuevo servicio medico");
	$bitacora->setTabla("servicio Medico");

	$insercion = $servicio->insertarSevicio();

	if (is_array($insercion) && $insercion[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $insercion]);
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

	$servicio = new ModeloServicios();
	$bitacora = new ModeloBitacora();

	$servicio->setIdServicioMedico($datos[0]);

	$bitacora->setId_usuario($datos[1]);
	$bitacora->setActividad("Ha eliminado un servicio medico");
	$bitacora->setTabla("servicio Medico");

	$eliminacion = $servicio->eliminar();


	if (is_array($eliminacion) && $eliminacion[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $eliminacion]);
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

	$servicio = new ModeloServicios();
	$bitacora = new ModeloBitacora();

	$servicio->setIdServicioMedico($datos[0]);

	$bitacora->setId_usuario($datos[1]);
	$bitacora->setActividad("Ha restablecido un servicio medico");
	$bitacora->setTabla("servicio Medico");

	$restablecimiento = $servicio->restablecerServ();

	if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $restablecimiento]);
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
	$servicio = new ModeloServicios();
	$bitacora = new ModeloBitacora();

	//Quitar separadores de miles
	$valor = str_replace('.', '', $_POST['precioD']);
	//Cambiar coma decimal por punto
	$valor = str_replace(',', '.', $valor);
	$numero = (float)$valor;

	$servicio->setIdCategoria($_POST['id_categoria']);
	$servicio->setIdServicioMedico($_POST['id_servicioMedico']);
	$servicio->setPrecio($numero);
	$servicio->setTipo($_POST['tipo']);

	$bitacora->setId_usuario($_POST['id_usuario']);
	$bitacora->setActividad("Ha modificado un servicio medico");
	$bitacora->setTabla("servicio Medico");

	$edicion = $servicio->editar();

	if (is_array($edicion) && $edicion[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $edicion]);
		exit;
	}
}

function mostrarEspecialidad($datos)
{
	$modeloServicio = new ModeloServicios();
	$modeloDoctor = new ModeloDoctores();

	$modeloDoctor->setIdDoctor($datos[0]);
	echo json_encode($modeloServicio->especialidadDoctor());
}


function registrarCategoria()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$categoria = new ModeloCategoria();
	$bitacora = new ModeloBitacora();

	$categoria->setNombre($_POST["nombre"]);

	$insercion = $categoria->registrarCategoria();
	
	if (is_array($insercion) && $insercion[0] === "exito") {
		$bitacora->setId_usuario($_POST['id_usuario']);
		$bitacora->setActividad("Ha Insertado una nueva  categoria");
		$bitacora->setTabla("Categoria de servicio medico");
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $insercion]);
		exit;
	}
}
function eliminarCategoria($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$categoria = new ModeloCategoria();
	$bitacora = new ModeloBitacora();

	$categoria->setIdCategoria($datos[0]);

	$bitacora->setId_usuario($datos[1]);
	$bitacora->setActividad("Ha eliminado una categoria");
	$bitacora->setTabla("Categoria de servicio medico");

	$eliminacion  = $categoria->eliminarCategoria();

	if (is_array($eliminacion) && $eliminacion[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $eliminacion]);
		exit;
	}
}

	//  function permisos($id_rol, $permiso, $modulo)
	// {
	// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	// }
