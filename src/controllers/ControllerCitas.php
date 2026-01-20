<?php

use App\modelos\ModeloCita;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloPermisos;




function returnObjectClass()
{
	return [
		'paciente' => new ModeloPacientes(),
		'bitacora' => new ModeloBitacora(),
		'cita' => new ModeloCita(),
		'doctor' => new ModeloDoctores()
	];
}

function mostrarPacienteCita()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	returnObjectClass()['paciente']->setNacionalidad($_POST['nacionalidad']);
	returnObjectClass()['paciente']->setCedula($_POST['cedula']);

	echo json_encode(returnObjectClass()['cita']->selectPaciente());
}



function mostrarPacienteCitaGet($datos)
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	returnObjectClass()['paciente']->setNacionalidad($datos[0]);
	returnObjectClass()['paciente']->setCedula($datos[1]);

	echo json_encode(returnObjectClass()['cita']->selectPaciente());
}

function citas($parametro)
{
	$ayuda = "btnayudaCitaP";
	$vistaActiva = 'pendientes';
	// $servicios = $this->modelo->mostrarServicioDoctor();
	require_once './src/vistas/vistasCitas/vistaCitas.php';
}
function citasAjax()
{
	echo json_encode(returnObjectClass()['cita']->mostrarCita());
}

function citasHoy($parametro)
{
	$ayuda = "btnayudaCitaP";
	$vistaActiva = 'hoy';
	// $servicios = $this->modelo->mostrarServicioDoctor();
	require_once './src/vistas/vistasCitas/vistaCitas.php';
}

function citasHoyAjax()
{
	echo json_encode(returnObjectClass()['cita']->mostrarCitaHoy());
}
function citasP($parametro)
{
	echo json_encode(returnObjectClass()['cita']->mostrarCita());
}

function guardarCita()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$paciente = returnObjectClass()['paciente'];
	$cita = returnObjectClass()['cita'];
	$bitacora = returnObjectClass()['bitacora'];
	$doctor = returnObjectClass()['doctor'];

	$paciente->setIdPaciente($_POST["id_paciente"]);
	$cita->setIdServicioMedico($_POST["id_servicioMedico"]);
	$cita->setFecha($_POST["fechaDeCita"]);
	$cita->setHora($_POST["hora"]);
	$cita->setEstado($_POST["estado"]);
	$doctor->setIdDoctor($_POST["id_doctor"]);

	$bitacora->setId_usuario($_POST['id_usuario']);
	$bitacora->setActividad("Ha Insertado una  cita");
	$bitacora->setTabla("cita");

	$insercion = $cita->insertarCita();

	if (is_array($insercion) && $insercion[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $insercion]);
		exit;
	}
}

function eliminarCita($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$cita = returnObjectClass()['cita'];
	$bitacora = returnObjectClass()['bitacora'];

	$cita->setIdCita($datos[0]);

	$bitacora->setId_usuario($datos[1]);
	$bitacora->setActividad("Ha eliminado una  cita");
	$bitacora->setTabla("cita");
	
	$eliminacion = $cita->eliminarCita();

	if (is_array($eliminacion) && $eliminacion[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $eliminacion]);
		exit;
	}
}
function citasHoyP()
{
	echo json_encode(returnObjectClass()['cita']->mostrarCitaHoy());
}

function citasRealizadas($parametro)
{
	$ayuda = "btnayudaCitaP";
	$vistaActiva = 'realizadas';
	require_once './src/vistas/vistasCitas/vistaCitas.php';
}

function citasRealizadasAjax()
{
	echo json_encode(returnObjectClass()['cita']->mostrarCitaR());
}

function mostrarDoctoresCita($datos)
{
	returnObjectClass()['cita']->setIdServicioMedico($datos[0]);
	echo json_encode(returnObjectClass()['cita']->mostrarDoctores());
}

function mostrarHorario($datos)
{
	returnObjectClass()['doctor']->setIdDoctor($datos[0]);
	echo json_encode(returnObjectClass()['cita']->mostrarHorarioDoctores());
}
function editarCita()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	$cita = returnObjectClass()['cita'];
	$bitacora = returnObjectClass()['bitacora'];

	$cita->setIdServicioMedico($_POST["serviciomedico_id_servicioMedico"]);
	$cita->setFecha($_POST["fechaDeCita"]);
	$cita->setHora($_POST["hora"]);
	$cita->setIdCita($_POST["id_cita"]);

	$bitacora->setId_usuario($_POST['id_usuario']);
	$bitacora->setActividad("Ha modificado una  cita");
	$bitacora->setTabla("cita");

	$edicion = $cita->update_cita();

	if (is_array($edicion) && $edicion[0] === "exito") {
		$bitacora->insertarBitacora();
		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $edicion]);
		exit;
	}
}

// function permisos($id_rol, $permiso, $modulo)
// {
// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }

// function validarHorariosDisponlibles($datos)
// {
// 	echo  json_encode($this->modelo->validarHorariosDisponlibles($datos[0], $datos[1]));
// }
