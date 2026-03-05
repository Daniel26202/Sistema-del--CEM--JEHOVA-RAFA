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
	$modelo = new ModeloPatologia();
	echo json_encode($modelo->mostrarPatologias());
}

function papeleraPatologias($parametro)
{
	$vistaActiva = "papelera";
	$ayuda = "btnayudaPatologia";
	require_once './src/vistas/vistaPatologia/patologia.php';
}

function papeleraAjax()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$modelo = new ModeloPatologia();

	echo json_encode($modelo->mostrarPatologiasEliminadas());
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
		// RATE LIMIT: 5 peticiones cada 1 segundos
		$limiter = new RateLimiter();
		$limiter->verificar('guardar_patologia_' . $idUsuario, 5, 1);

		$modelo = new ModeloPatologia();
		$bitacora = new ModeloBitacora();

		$modelo->setNombrePatologia($_POST["nombre"]);

		$bitacora->setId_usuario($_POST['id_usuario']);
		$bitacora->setActividad("Ha Insertado un nuevo patologia");
		$bitacora->setTabla("patologia");

		$insercion = $modelo->insertarPatologia();


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
		// RATE LIMIT: 5 peticiones cada 1 segundos
		$limiter = new RateLimiter();
		$limiter->verificar('eliminar_patologia_' . $idUsuario, 5, 1);

		$modelo = new ModeloPatologia();
		$bitacora = new ModeloBitacora();

		$modelo->setIdPatologia($datos[0]);

		$bitacora->setId_usuario($datos[1]);
		$bitacora->setActividad("Ha eliminado una  patologia");
		$bitacora->setTabla("patologia");

		$eliminar = $modelo->eliminarPatologia();

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
		// RATE LIMIT: 5 peticiones cada 1 segundos
		$limiter = new RateLimiter();
		$limiter->verificar('restablecer_patologia_' . $idUsuario, 5, 1);

		$modelo = new ModeloPatologia();
		$bitacora = new ModeloBitacora();

		$modelo->setIdPatologia($datos[0]);

		$bitacora->setId_usuario($datos[1]);
		$bitacora->setActividad("Ha restablecido una  patologia");
		$bitacora->setTabla("patologia");

		$eliminar = $modelo->restablecer();

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
