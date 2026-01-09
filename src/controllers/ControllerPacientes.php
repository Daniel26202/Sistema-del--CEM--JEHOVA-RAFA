<?php

use App\modelos\ModeloPacientes;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
// use App\



//  function permisos($id_rol, $permiso, $modulo)
// {
// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }

function returnObjectClass()
{
	$modelo = new ModeloPacientes(true);
	$bitacora = new ModeloBitacora(false);
	return [$modelo, $bitacora];
}


function getPacientes($parametro)
{
	$ayuda = "btnayudaPaciente";
	$vistaActiva = 'pacientes';
	require_once './src/vistas/vistaPacientes/pacientes.php';
}

function getPacientesAjax($parametro)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	[$modelo] = returnObjectClass();
	echo json_encode($modelo->index());
}

// /* hay q hacerlo con ajax, pero lo hice sencillo, no se si se vaya a pasar a ajax to esto, pa despues del sabado ;) */
//  function getHistorialSalud($parametro)
// {
// 	$historial = $this->modelo->indexHistorial();
// 	$vistaActiva = 'historial';
// 	require './src/vistas/vistaPacientes/pacientes.php';
// }

function papeleraPaciente($parametro)
{
	$modelo = new ModeloPacientes(true);
	$vistaActiva = 'papelera';
	$pacientes = $modelo->indexPapelera();
	require_once './src/vistas/vistaPacientes/pacientes.php';
}

function papeleraPacienteAjax()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$modelo = new ModeloPacientes(true);
	echo json_encode($modelo->indexPapelera());
}



function guardar()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {

		[$modelo, $bitacora] = returnObjectClass();

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
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}


function setPaciente()
{

	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	[$modelo, $bitacora] = returnObjectClass();


	$modelo->setIdPaciente($_POST['id_paciente']);
	$modelo->setNacionalidad($_POST['nacionalidad']);
	$modelo->setCedulaRegistrada($_POST['cedulaRegistrada']);
	$modelo->setCedula($_POST['cedula']);
	$modelo->setNombre($_POST['nombre']);
	$modelo->setApellido($_POST['apellido']);
	$modelo->setTelefono($_POST['telefono']);
	$modelo->setDireccion($_POST['direccion']);
	$modelo->setFn($_POST['fn']);
	$modelo->setGenero($_POST['genero']);

	// $bitacora->setId_usuario($_POST['id_usuario']);
	// $bitacora->setActividad("Ha modificado un paciente");
	// $bitacora->setTabla("paciente");

	$edicion = $modelo->update_paciente();


	// Verifica si es un array con clave "exito"
	if (is_array($edicion) && $edicion[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $edicion]);
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

	[$modelo, $bitacora] = returnObjectClass();

	$modelo->setIdPaciente($datos[0]);

	$bitacora->setId_usuario($datos[1]);
	$bitacora->setActividad("Ha eliminado un  paciente");
	$bitacora->setTabla("paciente");

	$eliminacion = $modelo->delete();

	//Verifica si es un array con clave "exito"
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

	[$modelo, $bitacora] = returnObjectClass();

	$modelo->setIdPaciente($datos[0]);

	$bitacora->setId_usuario($datos[1]);
	$bitacora->setActividad("Ha restablecido un paciente");
	$bitacora->setTabla("paciente");

	$restablecer = $modelo->restablecer();

	//Verifica si es un array con clave "exito"
	if (is_array($restablecer) && $restablecer[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $restablecer]);
		exit;
	}
}
