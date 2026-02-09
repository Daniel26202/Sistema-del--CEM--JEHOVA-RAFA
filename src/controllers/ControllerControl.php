<?php

use App\modelos\ModeloControl;
use App\modelos\ModeloSintomas;
use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloUsuarios;

function control($parametro)
{
	$modeloSintomas = new ModeloSintomas();
	$modeloPatologia = new ModeloPatologia();
	$modeloControl = new ModeloControl();
	$modeloInicio = new ModeloInicio();

	$datosS = $modeloSintomas->selects();
	$datosD = $modeloControl->mostrarDoctor();
	$datosPatologias = $modeloPatologia->mostrarPatologias();
	$ayuda = "btnayudaControl";

	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	$idPersonal = $_SESSION['id_personal'];

	$modeloInicio->setIdPersonal($idPersonal);
	$validacionCargo = $modeloInicio->comprobarCargo();

	require_once __DIR__ . "/../../src/vistas/vistaControl/vistaControl.php";
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
	$modeloPacientes = new ModeloPacientes();
	$modeloUsuarios = new ModeloUsuarios();

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
	$modeloPatologia->setCedulaPac($cedula);
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
		$modeloUsuarios->setIdUsuario($idUsuario);
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
	$modeloControl = new ModeloControl();
	$modeloUsuarios = new ModeloUsuarios();
	$modeloPacientes = new ModeloPacientes();
	$modeloBitacora = new ModeloBitacora();

	$patologia = (isset($_POST["patologias"])) ? $_POST["patologias"] : false;


	$modeloUsuarios->setIdUsuario($_POST["doctor"]);
	$modeloPacientes->setIdPaciente($_POST["id_paciente"]);

	$modeloControl->setHistorial($_POST["historial"]);
	$modeloControl->setDiagnostico($_POST["diagnostico"]);
	$modeloControl->setSintomas($_POST["sintomas"]);
	$modeloControl->setIndicaciones($_POST["indicaciones"]);
	$modeloControl->setFechaRegreso($_POST["fechaRegreso"]);
	$modeloControl->setPatologias($patologia);
	$modeloControl->setNota($_POST["nota"]);
	$modeloControl->setSeveridad($_POST["severidad"]);

	$registro = $modeloControl->insertControl();

	if (is_array($registro) && $registro[0] === "exito") {
		$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
		$modeloBitacora->setTabla("control");
		$modeloBitacora->setActividad("Ha Insertado un nuevo  control medico");
		$modeloBitacora->insertarBitacora();

		echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
	} else {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $registro]);
		exit;
	}
}

// function eliminarControl($datos)
// {

// 	$id_control = $datos[0];
// 	$this->modelo->eliminarControl($id_control);
// 	echo json_encode($_GET);
// }

function editarControl()
{
	if ($_POST) {
		$modeloControl = new ModeloControl();
		$modeloBitacora = new ModeloBitacora();

		$modeloControl->setHistorial($_POST["historialE"]);
		$modeloControl->setIdControl($_POST["id_control"]);
		$modeloControl->setIndicaciones($_POST["indicaciones"]);
		$modeloControl->setFechaRegreso($_POST["fechaRegreso"]);
		$modeloControl->setNota($_POST["nota_e"]);
		$editar = $modeloControl->editarControl();

		if (is_array($editar) && $editar[0] === "exito") {

			$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
			$modeloBitacora->setTabla("control");
			$modeloBitacora->setActividad("Ha modificado un  control medico");
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $editar]);
			exit;
		}
	}
}
// mostrar síntomas de pacientes
function mostrarSP($datos)
{
	$modeloControl = new ModeloControl();

	$idC = $datos[0];
	$modeloControl->setIdControl($idC);
	$respuestaS = $modeloControl->mostrarSintomasPaId();
	echo json_encode($respuestaS);
}
// mostrar patología de pacientes
function mostrarPP($datos)
{
	$modeloControl = new ModeloControl();

	$idC = $datos[0];
	$modeloControl->setIdControl($idC);
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
	$modeloSintomas = new ModeloSintomas();
	$modeloBitacora = new ModeloBitacora();

	$id_sintomas = $datos[0];
	$id_usuario_bitacora = $datos[1];
	$modeloSintomas->setIdSintomas($id_sintomas);
	$eliminar = $modeloSintomas->eliminarL();
	if ($eliminar) {
		// Guardar la bitacora
		$modeloBitacora->setId_usuario($id_usuario_bitacora);
		$modeloBitacora->setTabla("sintomas");
		$modeloBitacora->setActividad("Ha eliminado un  sintoma");
		$modeloBitacora->insertarBitacora();
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Control/control/eliminar");
	} else {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Control/control/errorSistem");
	}
}

function agregarSintoma()
{
	$modeloSintomas = new ModeloSintomas();
	$modeloBitacora = new ModeloBitacora();

	$modeloSintomas->setNombre($_POST["nombre"]);
	$insertar = $modeloSintomas->insertar();
	if ($insertar) {
		// Guardar la bitacora
		$modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
		$modeloBitacora->setTabla("sintomas");
		$modeloBitacora->setActividad("Ha Insertado un  sintoma");
		$modeloBitacora->insertarBitacora();
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Control/control/registro");
	} else {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Control/control/errorSistem");
	}
}

function permisos($id_rol, $permiso, $modulo)
{
	$modeloPermisos= new ModeloPermisos();
	$modeloPermisos->setIdRol($id_rol);
	$modeloPermisos->setPermiso($permiso);
	$modeloPermisos->setModulo($modulo);
	return $modeloPermisos->gestionarPermisos();
}
