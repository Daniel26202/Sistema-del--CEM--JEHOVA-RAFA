<?php

use App\modelos\ModeloPacientes;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
// use App\



//  function permisos($id_rol, $permiso, $modulo)
// {
// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }


function getPacientes($parametro)
{
	$ayuda = "btnayudaPaciente";
	$vistaActiva = 'pacientes';
	require_once './src/vistas/vistaPacientes/pacientes.php';
}

function getPacientesAjax($parametro)
{
	$modelo = new ModeloPacientes(true);
	echo json_encode($modelo->index());
}

// /* hay q hacerlo con ajax, pero lo hice sencillo, no se si se vaya a pasar a ajax to esto, pa despues del sabado ;) */
//  function getHistorialSalud($parametro)
// {
// 	$historial = $this->modelo->indexHistorial();
// 	$vistaActiva = 'historial';
// 	require './src/vistas/vistaPacientes/pacientes.php';
// }

//  function papeleraPaciente($parametro)
// {
// 	$pacientes = $this->modelo->indexPapelera();
// 	require_once './src/vistas/vistaPacientes/pacientesPapelera.php';
// }

//  function papeleraPacienteAjax()
// {
// 	echo json_encode($this->modelo->indexPapelera());
// }



function guardar()
{
	if(empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$modelo = new ModeloPacientes(true);
	$bitacora = new ModeloBitacora(true);

	$modelo->setNacionalidad($_POST['nacionalidad']);
	$modelo->setCedula($_POST['cedula']);
	$modelo->setNombre($_POST['nombre']);
	$modelo->setApellido($_POST['apellido']);
	$modelo->setTelefono($_POST['telefono']);
	$modelo->setDireccion($_POST['direccion']);
	$modelo->setFn($_POST['fn']);
	$modelo->setGenero($_POST['genero']);

	$bitacora->setId_usuario($_POST['id_usuario']);
	$bitacora->setActividad("Ha Insertado un nuevo paciente");
	$bitacora->setTabla("paciente");

	$insercion = $modelo->insertar();

	// Verifica si es un array con clave "exito"
	if (is_array($insercion) && $insercion[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $insercion]);
		exit;
	}
}


	//  function setPaciente()
	// {

	// 	$edicion = $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero'], $_POST['cedulaRegistrada']);


	// 	// // Verifica si es un array con clave "exito"
	// 	if (is_array($edicion) && $edicion[0] === "exito") {
	// 		$this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha modificado un paciente");
	// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	// 	} else {
	// 		http_response_code(409);
	// 		echo json_encode(['ok' => false, 'error' => $edicion]);
	// 		exit;
	// 	}
	// }

	//  function eliminar($datos)
	// {
	// 	$cedula = $datos[0];
	// 	$id_usuario = $datos[1];
	// 	// guardar la bitacora
	// 	$eliminacion = $this->modelo->delete($cedula);

	// 	//Verifica si es un array con clave "exito"
	// 	if (is_array($eliminacion) && $eliminacion[0] === "exito") {
	// 		$this->bitacora->insertarBitacora($id_usuario, "paciente", "Ha eliminado un  paciente");
	// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	// 	} else {
	// 		http_response_code(409);
	// 		echo json_encode(['ok' => false, 'error' => $eliminacion]);
	// 		exit;
	// 	}
	// }
	//  function restablecer($datos)
	// {
	// 	$id_paciente = $datos[0];
	// 	$id_usuario = $datos[1];
	// 	// guardar la bitacora
	// 	$restablecimiento = $this->modelo->restablecer($id_paciente);

	// 	//Verifica si es un array con clave "exito"
	// 	if (is_array($restablecimiento) && $restablecimiento[0] === "exito") {
	// 		$this->bitacora->insertarBitacora($id_usuario, "paciente", "Ha restablecido un  paciente");
	// 		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	// 	} else {
	// 		http_response_code(409);
	// 		echo json_encode(['ok' => false, 'error' => $restablecimiento]);
	// 		exit;
	// 	}
	// }


	//  function mostrarPaciente()
	// {
	// 	$respuesta = $this->modelo->buscar($_POST['cedula']);
	// 	echo json_encode($respuesta);
	// }
