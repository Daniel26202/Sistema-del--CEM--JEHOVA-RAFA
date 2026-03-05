<?php

use App\modelos\ModeloControl;
use App\modelos\ModeloSintomas;
use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloUsuarios;
use App\config\RateLimiter;

function control($parametro)
{
	$modeloInicio = new ModeloInicio();


	$ayuda = "btnayudaControl";

	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	$idPersonal = $_SESSION['id_personal'];

	$modeloInicio->setIdPersonal($idPersonal);
	$validacionCargo = $modeloInicio->comprobarCargo();

	require_once __DIR__ . "/../../src/vistas/vistaControl/vistaControl.php";
}

function returnSistomasPaciente()
{
	$modeloSintomas = new ModeloSintomas();
	echo json_encode($modeloSintomas->selects());
}

function returnPatologiasPaciente()
{
	$modeloPatologia = new ModeloPatologia();
	echo json_encode($modeloPatologia->mostrarPatologias());
}

function returnPatologiasPacienteId()
{
	$modeloPatologia = new ModeloControl();
	echo json_encode($modeloPatologia->mostrarPatologiaC());
}

function returnDoctores()
{
	$modeloControl = new ModeloControl();
	echo json_encode($modeloControl->mostrarDoctor());
}

function listPacientesJS()
{
	$modeloControl = new ModeloControl();

	$respuesta = $modeloControl->consultarPacientes();
	echo json_encode($respuesta);
}

function mostrarBusquedaPacientesJS($datos)
{
	$modeloControl = new ModeloControl();
	$modeloControl->setCedula($datos[0]);
	$modeloControl->setNacionalidad($datos[1]);


	$respuesta = $modeloControl->buscarPacientes();
	echo json_encode($respuesta);
}

function mostrarControlPacientesJS($datos)
{
	$modeloControl = new ModeloControl();
	$modeloSintomas = new ModeloSintomas();
	$modeloPatologia = new ModeloPatologia();
	$modeloInicio = new ModeloInicio();

	// verifica si la sesión esta activa.
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	$idUsuario = $_SESSION['id_usuario'];
	$modeloInicio->setIdPersonal($_SESSION['id_personal']);
	$validacionCargo = $modeloInicio->comprobarCargo();

	$cedula = $datos[0];

	$sintomas = $modeloSintomas->selects();
	// patologías
	$modeloControl->setCedula($cedula);
	$registradosP = $modeloPatologia->buscarPatologiaPaciente();
	$patologias = $modeloPatologia->mostrarPatologias();

	// cero es administrador mas no doctor 
	if ($validacionCargo == 0) {
		$modeloControl->setCedula($cedula);
		$respuestaP = $modeloControl->mostrarControlPacienteA();

		// este array tiene tres valores de tres funciones en el modelo
		$arrayPSS = [$respuestaP, $sintomas, $registradosP, $patologias];
		echo json_encode($arrayPSS);
		// uno es doctor
	} else if ($validacionCargo == 1) {
		// devuelve solo los datos del paciente atendido por el mismo doctor que inicio sesión(Usuario)
		$modeloControl->setIdUsuario($idUsuario);
		$modeloControl->setCedula($cedula);
		$respuesta = $modeloControl->mostrarControlPacienteU();

		// este array tiene tres valores de tres funciones en el modelo
		$arrayPSS = [$respuesta, $sintomas, $registradosP, $patologias];
		echo json_encode($arrayPSS);
	}
}

function mostrarPacienteJS($datos)
{
	$modeloControl = new ModeloControl();

	$modeloControl->setNacionalidad($datos[0]);
	$modeloControl->setCedula($datos[1]);
	// me traigo los datos de los pacientes
	$respuesta = $modeloControl->mostrarPaciente();

	echo json_encode($respuesta);
}

function insertarControl()
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
		$limiter->verificar('guardar_control_' . $idUsuario, 5, 1);

		$modeloControl = new ModeloControl();
		$modeloBitacora = new ModeloBitacora();

		$patologia = (isset($_POST["patologias"])) ? $_POST["patologias"] : [null];
		$sintoma = (isset($_POST["sintomas"])) ? $_POST["sintomas"] : [null];



		$modeloControl->setIdUsuario($_POST["doctor"]);
		$modeloControl->setIdPaciente($_POST["id_paciente"]);

		$modeloControl->setHistorial($_POST["historial"]);
		$modeloControl->setDiagnostico($_POST["diagnostico"]);
		$modeloControl->setSintomas($sintoma);
		$modeloControl->setIndicaciones($_POST["indicaciones"]);
		$modeloControl->setFechaRegreso($_POST["fechaDeCita"]);
		$modeloControl->setPatologias($patologia);
		$modeloControl->setNota($_POST["nota"]);
		$modeloControl->setSeveridad($_POST["severidad"]);

		$registro = $modeloControl->insertControl();

		if (is_array($registro) && $registro[0] === "exito") {
			$modeloBitacora->setId_usuario($_POST['id_usuario']);
			$modeloBitacora->setTabla("control");
			$modeloBitacora->setActividad("Ha Insertado un nuevo  control medico");
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $registro]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function editarControl()
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
		$limiter->verificar('editar_control_' . $idUsuario, 5, 1);

		$modeloControl = new ModeloControl();
		$modeloBitacora = new ModeloBitacora();

		$modeloControl->setIdControl($_POST['id_control']);
		$modeloControl->setHistorial($_POST["historial"]);
		$modeloControl->setDiagnostico($_POST["diagnostico"]);
		$modeloControl->setIndicaciones($_POST["indicaciones"]);
		$modeloControl->setFechaRegreso($_POST["fechaDeCita"]);
		$modeloControl->setNota($_POST["nota"]);
		$modeloControl->setSeveridad($_POST["severidad"]);

		$editar = $modeloControl->editarControl();

		if (is_array($editar) && $editar[0] === "exito") {

			$modeloBitacora->setId_usuario($_POST['id_usuario']);
			$modeloBitacora->setTabla("control");
			$modeloBitacora->setActividad("Ha modificado un  control medico");
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $editar]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
// mostrar síntomas de pacientes del ultimo  control
function mostrarSP($datos)
{
	$modeloControl = new ModeloControl();
	$cedula = $datos[0];

	$modeloControl->setCedula($cedula);
	$modeloControl->setIdControl($modeloControl->mostrarUltimoIdControl());

	$respuestaS = $modeloControl->mostrarSintomasPaId();
	echo json_encode($respuestaS);
}
// mostrar patología de pacientes del ultimo  control
function mostrarPP($datos)
{
	$modeloControl = new ModeloControl();
	$cedula = $datos[0];

	$modeloControl->setCedula($cedula);

	$id_control = ($modeloControl->mostrarUltimoIdControl() != null) ? $modeloControl->mostrarUltimoIdControl() : 0;
	$modeloControl->setIdControl($id_control);

	$registradosP = $modeloControl->mostrarPatologiaP();
	echo json_encode($registradosP);
}


// mostrar síntomas de pacientes 
function mostrarSPAll($datos)
{
	$modeloControl = new ModeloControl();
	$modeloControl->setIdControl($datos[0]);

	$respuestaS = $modeloControl->mostrarSintomasPaId();
	echo json_encode($respuestaS);
}
// mostrar patología de pacientes
function mostrarPPAll($datos)
{
	$modeloControl = new ModeloControl();
	$modeloControl->setIdControl($datos[0]);

	$registradosP = $modeloControl->mostrarPatologiaP();
	echo json_encode($registradosP);
}



// mostrar patología de paciente por id del paciente
function mostrarPIdP($datos)
{
	$modeloControl = new ModeloControl();

	$idC = $datos[0];
	$modeloControl->setIdControl($idC);
	$registradosP = $modeloControl->mostrarPatologiaC();
	echo json_encode($registradosP);
}

// síntomas 
function eliminarSintoma($datos)
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
		$limiter->verificar('eliminar_sintoma_' . $idUsuario, 5, 1);

		$modeloSintomas = new ModeloSintomas();
		$modeloBitacora = new ModeloBitacora();


		$id_sintomas = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$modeloSintomas->setIdSintomas($id_sintomas);
		$eliminar = $modeloSintomas->eliminarL();

		if (is_array($eliminar) && $eliminar[0] === "exito") {
			// Guardar la bitacora
			$modeloBitacora->setId_usuario($id_usuario_bitacora);
			$modeloBitacora->setTabla("sintomas");
			$modeloBitacora->setActividad("Ha eliminado un  sintoma");
			$modeloBitacora->insertarBitacora();

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

function agregarSintoma()
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
		$limiter->verificar('guardar_sintoma_' . $idUsuario, 5, 1);

		$modeloSintomas = new ModeloSintomas();
		$modeloBitacora = new ModeloBitacora();

		$modeloSintomas->setNombre($_POST["nombre"]);
		$insertar = $modeloSintomas->insertar();
		if ($insertar) {
			// Guardar la bitacora
			$modeloBitacora->setId_usuario($_POST['id_usuario']);
			$modeloBitacora->setTabla("sintomas");
			$modeloBitacora->setActividad("Ha Insertado un  sintoma");
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insertar]);
			exit;
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function permisos($id_rol, $permiso, $modulo)
{
	$modeloPermisos = new ModeloPermisos();
	$modeloPermisos->setIdRol($id_rol);
	$modeloPermisos->setPermiso($permiso);
	$modeloPermisos->setModulo($modulo);
	return $modeloPermisos->gestionarPermisos();
}
