<?php

use App\modelos\ModeloCita;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloServicios;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloPermisos;




function returnObjectClass()
{
	return [
		'paciente' => new ModeloPacientes(),
		'bitacora' => new ModeloBitacora(),
		'cita' => new ModeloCita(),
		'doctor' => new ModeloDoctores(),
		'servicio' => new ModeloServicios()
	];
}




function mostrarDataPaciente($datos)
{
	try {
		$paciente = returnObjectClass()['paciente'];
		$cita = returnObjectClass()['cita'];

		$paciente->setNacionalidad($datos[0]);
		$paciente->setCedula($datos[1]);

		echo json_encode($cita->selectPaciente($paciente));
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function citas($parametro)
{
	$ayuda = "btnayudaCitaP";
	$vistaActiva = 'pendientes';
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

function mostrarServiciosMedicosAjax()
{
	echo json_encode(returnObjectClass()['cita']->mostrarServicioDoctor());
}

function validarHorariosDisponlibles($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		$cita = returnObjectClass()['cita'];
		$doctor = returnObjectClass()['doctor'];

		$doctor->setIdDoctor($datos[1]);
		$cita->setFecha($datos[0]);

		echo  json_encode($cita->validarHorariosDisponlibles($doctor));
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function guardarCita()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		$cita = new ModeloCita();
		$bitacora = new ModeloBitacora();

		$horaString = $_POST['listHoras'];
		$resultado = explode('a', $horaString);
		$resultado = array_map('trim', $resultado);

		$fechaHora1 = DateTime::createFromFormat('g:i A', $resultado[0]);
		$horaCita = $fechaHora1->format('H:i:s');
		$fechaHora2 = DateTime::createFromFormat('g:i A', $resultado[1]);
		$horaCitaSalida = $fechaHora2->format('H:i:s');

		// echo json_encode([$horaCita,$horaCitaSalida]);

		$cita->setIdPaciente(intval($_POST["id_paciente"]));
		$cita->setIdServicioMedico(intval($_POST["id_servicio"]));
		$cita->setFecha($_POST["fechaDeCita"]);
		$cita->setHora($horaCita);
		$cita->setHoraSalida($horaCitaSalida);
		$cita->setEstado("Pendiente");
		$cita->setIdDoctor(intval($_POST["id_personal"]));

		$bitacora->setId_usuario($_POST['id_usuario']);
		$bitacora->setActividad("Ha Insertado una  cita");
		$bitacora->setTabla("cita");

		$insercion = $cita->insertarCita();

		if (is_array($insercion) && $insercion[0] === "exito") {
			$bitacora->insertarBitacora();
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
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

function eliminarCita($datos)
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}
	try {
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
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
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
	$servicio = returnObjectClass()['servicio'];
	$servicio->setIdServicioMedico($datos[0]);
	echo json_encode(returnObjectClass()['cita']->mostrarDoctores($servicio));
}

function mostrarHorario($datos)
{
	$doctor = returnObjectClass()['doctor'];
	$doctor->setIdDoctor($datos[0]);
	echo json_encode(returnObjectClass()['cita']->mostrarHorarioDoctores($doctor));
	// echo json_encode(['dffdf']);
}
function editarCita()
{
	if (empty($_POST)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		$cita = new ModeloCita();
		$bitacora = new ModeloBitacora();

		$horaString = $_POST['listHoras'];
		$resultado = explode('a', $horaString);
		$resultado = array_map('trim', $resultado);

		$fechaHora1 = DateTime::createFromFormat('g:i A', $resultado[0]);
		$horaCita = $fechaHora1->format('H:i:s');
		$fechaHora2 = DateTime::createFromFormat('g:i A', $resultado[1]);
		$horaCitaSalida = $fechaHora2->format('H:i:s');

		// echo json_encode([$horaCita,$horaCitaSalida]);

		$cita->setIdPaciente(intval($_POST["id_paciente"]));
		$cita->setIdServicioMedico(intval($_POST["id_servicio"]));
		$cita->setFecha($_POST["fechaDeCita"]);
		$cita->setHora($horaCita);
		$cita->setHoraSalida($horaCitaSalida);
		$cita->setEstado("Pendiente");
		$cita->setIdDoctor(intval($_POST["id_personal"]));
		$cita->setIdCita($_POST['id_cita']);

		$bitacora->setId_usuario($_POST['id_usuario']);
		$bitacora->setActividad("Ha Modificado una  cita");
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
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

// function permisos($id_rol, $permiso, $modulo)
// {
// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }
