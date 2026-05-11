<?php

use App\modelos\ModeloPacientes;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
// use App\


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
	$modelo  = new ModeloPacientes();
	echo json_encode($modelo->index());
}

/* hay q hacerlo con ajax, pero lo hice sencillo, no se si se vaya a pasar a ajax to esto, pa despues del sabado ;) */
function getHistorialSalud($parametro)
{
	$modelo = new ModeloPacientes();

	$vistaActiva = 'historial';
	require './src/vistas/vistaPacientes/pacientes.php';
}

function getHistorialSaludAjax()
{
	$modelo = new ModeloPacientes();

	echo json_encode($modelo->indexHistorial());
}

function papeleraPaciente($parametro)
{

	$modelo  = new ModeloPacientes();
	$vistaActiva = 'papelera';
	$modelo  = new ModeloPacientes();

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
	$modelo  = new ModeloPacientes();

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
		$idUsuario = $_SESSION['id_usuario'];

		$modelo  = new ModeloPacientes();
		$bitacora = new ModeloBitacora();

		$modelo->setNacionalidad(isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : 'V');
		$modelo->setCedula($_POST['cedula']);
		$modelo->setNombre($_POST['nombre']);
		$modelo->setApellido($_POST['apellido']);
		$modelo->setTelefono($_POST['telefono']);
		$modelo->setDireccion($_POST['direccion']);
		$modelo->setFn($_POST['fn']);
		$modelo->setGenero($_POST['genero']);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha Insertado un nuevo paciente");
		$bitacora->setTabla("paciente");

		$insercion = $modelo->guardarPaciente($idUsuario);

		// Verifica si es un array con clave "exito"
		if (is_array($insercion) && $insercion[0] === "exito") {
			$bitacora->insertarBitacora($idUsuario);
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


	try {
		$idUsuario = $_SESSION['id_usuario'];

		$modelo  = new ModeloPacientes();
		$bitacora = new ModeloBitacora();


		$modelo->setIdPaciente(intval($_POST['id']));
		$modelo->setNacionalidad($_POST['nacionalidad']);
		$modelo->setCedulaRegistrada($_POST['cedulaRegistrada']);
		$modelo->setCedula($_POST['cedula']);
		$modelo->setNombre($_POST['nombre']);
		$modelo->setApellido($_POST['apellido']);
		$modelo->setTelefono($_POST['telefono']);
		$modelo->setDireccion($_POST['direccion']);
		$modelo->setFn($_POST['fn']);
		$modelo->setGenero($_POST['genero']);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha modificado un paciente");
		$bitacora->setTabla("paciente");

		$edicion = $modelo->editarPaciente($idUsuario);


		//Verifica si es un array con clave "exito"
		if (is_array($edicion) && $edicion[0] === "exito") {
			$bitacora->insertarBitacora($idUsuario);
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

function eliminar($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {

		$idUsuario = $_SESSION['id_usuario'];

		$modelo  = new ModeloPacientes();
		$bitacora = new ModeloBitacora();

		$modelo->setIdPaciente($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha eliminado un  paciente");
		$bitacora->setTabla("paciente");

		$eliminacion = $modelo->eliminarPaciente($idUsuario);

		//Verifica si es un array con clave "exito"
		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$bitacora->insertarBitacora($idUsuario);
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

		$modelo  = new ModeloPacientes();
		$bitacora = new ModeloBitacora();

		$modelo->setIdPaciente($datos[0]);

		$bitacora->setId_usuario($idUsuario);
		$bitacora->setActividad("Ha restablecido un paciente");
		$bitacora->setTabla("paciente");

		$restablecer = $modelo->restablecerPaciente($idUsuario);

		//Verifica si es un array con clave "exito"
		if (is_array($restablecer) && $restablecer[0] === "exito") {
			$bitacora->insertarBitacora($idUsuario);
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $restablecer]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
