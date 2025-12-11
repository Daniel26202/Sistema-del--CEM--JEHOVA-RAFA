<?php

use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;




function patologias($parametro)
{
	$ayuda = "btnayudaPatologia";
	require_once './src/vistas/vistaPatologia/patologia.php';
}

	//  function patologiasAjax()
	// {
	// 	echo json_encode($this->patologia->mostrarPatologias());
	// }
	//  function papeleraPatologias($parametro)
	// {
	// 	$ayuda = "btnayudaPatologia";
	// 	require_once './src/vistas/vistaPatologia/patologiapapelera.php';
	// }
	//  function papeleraAjax()
	// {
	// 	echo json_encode($this->patologia->mostrarPatologiasEliminadas());
	// }

	// //insertar patologia 
	//  function registrarPatologia()
	// {

	// 	$insercion = $this->patologia->insertarPatologia($_POST["nombre"]);

	// 	if (is_array($insercion) && $insercion[0] === "exito") {
	// 		$this->bitacora->insertarBitacora($_POST['id_usuario'], "patologia", "Ha Insertado una nueva patologia");
	// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
	// 	} else {
	// 		http_response_code(409);
	// 		echo json_encode(['ok' => false, 'error' => $insercion]);
	// 		exit;
	// 	}
	// }

	// //eliminar patologia
	//  function eliminarPatologia($datos)
	// {

	// 	$id_patologia = $datos[0];
	// 	$id_usuario = $datos[1];

	// 	$eliminar = $this->patologia->eliminarPatologia($id_patologia);

	// 	if (is_array($eliminar) && $eliminar[0] === "exito") {
	// 		$this->bitacora->insertarBitacora($id_usuario, "patologia", "Ha eliminado una patologia");
	// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	// 	} else {
	// 		http_response_code(409);
	// 		echo json_encode(['ok' => false, 'error' => $eliminar]);
	// 		exit;
	// 	}
	// }


	//  function restablecerPatologia($datos)
	// {
	// 	$id_patologia = $datos[0];
	// 	$id_usuario = $datos[1];

	// 	$restablecer = $this->patologia->restablecer($id_patologia);

	// 	if (is_array($restablecer) && $restablecer[0] === "exito") {
	// 		$this->bitacora->insertarBitacora($id_usuario, "patologia", "Ha restablecido una patologia");
	// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	// 	} else {
	// 		http_response_code(409);
	// 		echo json_encode(['ok' => false, 'error' => $restablecer]);
	// 		exit;
	// 	}
	// }



	//  function permisos($id_rol, $permiso, $modulo)
	// {
	// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	// }
