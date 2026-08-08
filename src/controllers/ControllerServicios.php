<?php

use App\models\ModeloCategoria;
use App\models\ModeloServicios;
use App\models\ModeloBitacora;
use App\models\ModeloDoctores;
use App\models\ModeloPermisos;
use App\models\Db;
use App\models\Validator;


function servicios($parametro)
{
	$vistaActiva = 'servicios';
	$ayuda = "btnayudaServicioMedico";
	require_once "./src/vistas/vistaServicios/vistaServiciosMedicos.php";
}

function papeleraServicio($parametro)
{
	$vistaActiva = 'papelera';
	require_once "./src/vistas/vistaServicios/vistaServiciosMedicos.php";
}

function datosServiciosPapelera($parametro)
{
	$db = new Db();
	$validator = new Validator();
	$modeloServicios = new ModeloServicios($db,$validator);
	$modeloCategoria = new ModeloCategoria($db,$validator);

	// $doctores = $modeloServicios->mostrarDoctores();
	$categorias = $modeloCategoria->seleccionarCategoria();
	echo json_encode(["doctores" => [], "categorias" => $categorias]);
}

function datosServicios($parametro)
{
	$db = new Db();
	$validator = new Validator();
	$modeloServicios = new ModeloServicios($db,$validator);
	$modeloCategoria = new ModeloCategoria($db,$validator);

	// $doctores = $modeloServicios->mostrarDoctores();
	$todasLasCategorias = $modeloCategoria->seleccionarCategoria();
	echo json_encode(["doctores" => [], "categorias" => $todasLasCategorias]);
}

function categoriasAjax()
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

	// mapeo de columnas
	$columnasMapeadas = ['nombre', 'precio_bolivar', 'precio_dolar', 'tipo'];
	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_servicioMedico';

	$modeloCategoria = new ModeloCategoria($db,$validator);

	$data = $modeloCategoria->seleccionarTodasLasCategoria($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$data['total'],
		"recordsFiltered" => (int)$data['total_filtrado'],
		"data"            => is_array($data['data']) ? $data['data']: []
	]);
	exit;
}

function serviciosAjax()
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

	// mapeo de columnas
	$columnasMapeadas = ['categoria', 'precio_bolivar', 'precio_dolar', 'tipo'];
	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_servicioMedico';

	$modeloServicios = new ModeloServicios($db,$validator);

	$data = $modeloServicios->mostrarServicios('ACT',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);


	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$data['total'],
		"recordsFiltered" => (int)$data['total_filtrado'],
		"data"            => is_array($data['data']) ? $data['data'] : []
	]);
	exit;
}

function papeleraAjax()
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

	// mapeo de columnas
	$columnasMapeadas = ['categoria', 'precio_bolivar', 'precio_dolar', 'tipo'];
	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_servicioMedico';

	$modeloServicios = new ModeloServicios($db,$validator);

	$data = $modeloServicios->mostrarServicios('DES',$inicio, $limite, $buscar, $ordenColumna, $ordenDir);

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$data['total'],
		"recordsFiltered" => (int)$data['total_filtrado'],
		"data"            => is_array($data['data']) ? $data['data'] : []
	]);
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

		$servicio = new ModeloServicios($db,$validator);
		$bitacora = new ModeloBitacora($db,$validator);
		// 1. Quitar separadores de miles
		$valor =  $_POST['precioD'];

		// 2. Cambiar coma decimal por punto
		// $valor = str_replace(',', '.', $valor);

		// 3. Convertir a float
		$numero = (float)$valor;

		// $servicio->setIdCategoria($_POST['id_categoria']);
		$servicio->setPrecio($numero);
		$servicio->setTipo($_POST['tipo']);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha Insertado un nuevo servicio medico");
		$bitacora->setTabla("servicio Medico");

		$insercion = $servicio->guardar($servicio->get_all(),$validator);

		if (is_array($insercion)) {
			$bitacora->guardar($bitacora->get_all(),$validator);
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
		
		$servicio = new ModeloServicios($db,$validator);
		$bitacora = new ModeloBitacora($db,$validator);

		$servicio->setIdServicioMedico($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha eliminado un servicio medico");
		$bitacora->setTabla("servicio Medico");

		$eliminacion = $servicio->actualizar(['estado'=>'DES'],['id_servicioMedico'=>$servicio->getIdServicioMedico()],$validator);

		if (is_array($eliminacion)) {
			$bitacora->guardar($bitacora->get_all(),$validator);
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

		$servicio = new ModeloServicios($db,$validator);
		$bitacora = new ModeloBitacora($db,$validator);

		$servicio->setIdServicioMedico($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha restablecido un servicio medico");
		$bitacora->setTabla("servicio Medico");

		$restablecimiento = $servicio->actualizar(['estado'=>'ACT'],['id_servicioMedico'=>$servicio->getIdServicioMedico()],$validator);

		if (is_array($restablecimiento)) {
			$bitacora->guardar($bitacora->get_all(),$validator);
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
		$servicio = new ModeloServicios($db,$validator);
		$bitacora = new ModeloBitacora($db,$validator);

		//Quitar separadores de miles
		$valor = str_replace('.', '', $_POST['precioD']);
		//Cambiar coma decimal por punto
		$valor = str_replace(',', '.', $valor);
		$numero = (float)$valor;

		// $servicio->setIdCategoria($_POST['id_categoria']);
		$servicio->setIdServicioMedico($_POST['id_servicioMedico']);
		$servicio->setPrecio($numero);
		$servicio->setTipo($_POST['tipo']);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha modificado un servicio medico");
		$bitacora->setTabla("servicio Medico");

		$edicion = $servicio->actualizar($servicio->get_all(),['id_servicioMedico'=>$servicio->getIdServicioMedico()],$validator);

		if (is_array($edicion)) {
			$bitacora->guardar($bitacora->get_all(),$validator);
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

function mostrarEspecialidad($datos)
{
	$db = new Db();
	$validator = new Validator();
	$modeloServicio = new ModeloServicios($db,$validator);
	$modeloDoctor = new ModeloDoctores($db,$validator);

	$modeloDoctor->setIdDoctor($datos[0]);
	// echo json_encode($modeloServicio->especialidadDoctor());
}


function registrarCategoria()
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

		$categoria = new ModeloCategoria($db,$validator);
		$bitacora = new ModeloBitacora($db,$validator);

		$categoria->setNombre($_POST["categoria"]);

		$insercion = $categoria->guardar($categoria->get_all(),$validator);

		if (is_array($insercion)) {
			$bitacora->setId_usuario($idUsuario);
			$bitacora->setActividad("Ha Insertado una nueva  categoria");
			$bitacora->setTabla("Categoria de servicio medico");
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
function eliminarCategoria($datos)
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

		$categoria = new ModeloCategoria($db,$validator);
		$bitacora = new ModeloBitacora($db,$validator);

		$categoria->setIdCategoria($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha eliminado una categoria");
		$bitacora->setTabla("Categoria de servicio medico");

		$eliminacion  = $categoria->actualizar(['estado'=>'DES'],['id_categoria'=>$categoria->getIdCategoria()],$validator);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$bitacora->guardar($bitacora->get_all(),$validator);
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