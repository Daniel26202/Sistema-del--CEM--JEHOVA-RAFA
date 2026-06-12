<?php

use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\config\RateLimiter;





function patologias($parametro)
{
	$ayuda = "btnayudaPatologia";
	$vistaActiva = "patologias";
	require_once './src/vistas/vistaPatologia/patologia.php';
}

function patologiasAjax()
{
  
    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

    $columnasMapeadas = ['id_patologia', 'nombre_patologia'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';
    

    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_patologia';

    $modelo = new ModeloPatologia();
    

    $patologias = $modelo->mostrarPatologias($inicio, $limite, $buscar, $ordenColumna, $ordenDir);
    $totalRegistros = $modelo->contarTotalPatologias('ACT');
    $totalFiltrados = !empty($buscar) ? $modelo->contarTotalPatologias('ACT', $buscar) : $totalRegistros;

    echo json_encode([
        "draw"            => $draw,
        "recordsTotal"    => (int)$totalRegistros,
        "recordsFiltered" => (int)$totalFiltrados,
        "data"            => $patologias
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
	$draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
	$inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
	$limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
	$buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';

	$columnasMapeadas = ['id_patologia', 'nombre_patologia'];

	$colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;
	$ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';


	$ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_patologia';

	$modelo = new ModeloPatologia();


	$patologias = $modelo->mostrarPatologiasEliminadas($inicio, $limite, $buscar, $ordenColumna, $ordenDir);
	$totalRegistros = $modelo->contarTotalPatologias('DES');
	$totalFiltrados = !empty($buscar) ? $modelo->contarTotalPatologias('DES', $buscar) : $totalRegistros;

	echo json_encode([
		"draw"            => $draw,
		"recordsTotal"    => (int)$totalRegistros,
		"recordsFiltered" => (int)$totalFiltrados,
		"data"            => $patologias
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
		$modelo = new ModeloPatologia();
		$bitacora = new ModeloBitacora();

		$modelo->setNombrePatologia($_POST["patologia"]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha Insertado un nuevo patologia");
		$bitacora->setTabla("patologia");

		$insercion = $modelo->guardarPatologia($idUsuario);


		if (is_array($insercion) && $insercion[0] === "exito") {
			$bitacora->insertarBitacora();
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


		$modelo = new ModeloPatologia();
		$bitacora = new ModeloBitacora();

		$modelo->setIdPatologia($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha eliminado una  patologia");
		$bitacora->setTabla("patologia");

		$eliminar = $modelo->deletePatologia($idUsuario);

		if (is_array($eliminar) && $eliminar[0] === "exito") {
			$bitacora->insertarBitacora();
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

		$modelo = new ModeloPatologia();
		$bitacora = new ModeloBitacora();

		$modelo->setIdPatologia($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha restablecido una  patologia");
		$bitacora->setTabla("patologia");

		$eliminar = $modelo->restablecerPatologia($idUsuario);

		if (is_array($eliminar) && $eliminar[0] === "exito") {
			$bitacora->insertarBitacora();
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



	//  function permisos($id_rol, $permiso, $modulo)
	// {
	// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	// }
