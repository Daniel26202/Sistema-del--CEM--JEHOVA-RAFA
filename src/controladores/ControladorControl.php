<?php

use App\modelos\ModeloControl;
use App\modelos\ModeloSintomas;
use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;

class ControladorControl
{

	private $modelo;
	private $modeloSintomas;
	private $modeloPatologia;
	private $bitacora;
	private $permisos;
	private $inicio;


	function __construct()
	{
		$this->modelo = new ModeloControl();
		$this->modeloSintomas = new ModeloSintomas();
		$this->modeloPatologia = new ModeloPatologia();
		$this->bitacora = new ModeloBitacora();
		$this->permisos = new ModeloPermisos();
		$this->inicio = new ModeloInicio();
	}

	public function control($parametro)
	{
		$datosS = $this->modeloSintomas->selects();
		$datosD = $this->modelo->mostrarDoctor();
		$datosPatologias = $this->modeloPatologia->mostrarPatologias();

		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		$idPersonal = $_SESSION['id_personal'];
		$validacionCargo = $this->inicio->comprobarCargo($idPersonal);

		require_once './src/vistas/vistaControl/vistaControl.php';
	}

	public function mostrarPacientesJS()
	{
		$respuesta = $this->modelo->consultarPacientes();
		echo json_encode($respuesta);
	}

	public function mostrarBusquedaPacientesJS($datos)
	{
		$cedula = $datos[0];
		$respuesta = $this->modelo->buscarPacientes($cedula);
		echo json_encode($respuesta);
	}

	public function mostrarControlPacientesJS($datos)
	{

		// verifica si la sesión esta activa.
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		$idUsuario = $_SESSION['id_usuario'];
		$validacionCargo = $this->inicio->comprobarCargo($idUsuario);

		$cedula = $datos[0];

		//síntomas
		$registradosS = $this->modelo->mostrarSintomasPa($cedula);
		$sintomas = $this->modeloSintomas->selects();
		// patologías
		$registradosP = $this->modeloPatologia->buscarPatologiaPaciente($cedula);
		$patologias = $this->modeloPatologia->mostrarPatologias();

		// cero es administrador mas no doctor 
		if ($validacionCargo == 0) {

			$respuestaP = $this->modelo->mostrarControlPacienteA($cedula);

			// este array tiene tres valores de tres funciones en el modelo
			$arrayPSS = [$respuestaP, $registradosS, $sintomas, $registradosP, $patologias];
			echo json_encode($arrayPSS);
			// uno es doctor
		} else if ($validacionCargo == 1) {
			// devuelve solo los datos del paciente atendido por el mismo doctor que inicio sesión(Usuario)
			$respuesta = $this->modelo->mostrarControlPacienteU($cedula, $idUsuario);

			// este array tiene tres valores de tres funciones en el modelo
			$arrayPSS = [$respuesta, $registradosS, $sintomas, $registradosP, $patologias];
			echo json_encode($arrayPSS);
		}
	}

	public function mostrarPacienteJS($datos)
	{
		$cedula = $datos[0];
		// me traigo los datos de los pacientes
		$respuesta = $this->modelo->mostrarPaciente($cedula);

		echo json_encode($respuesta);
	}

	public function insertarControl()
	{
		$patologia = (isset($_POST["patologias"])) ? $_POST["patologias"] : false;

		$this->modelo->insertControl($_POST["historial"], $_POST["doctor"], $_POST["id_paciente"], $_POST["diagnostico"], $_POST["sintomas"], $_POST["indicaciones"], $_POST["fechaRegreso"], $patologia, $_POST["nota"], $_POST["fecha_hora"]);

		// Guardar la bitacora
		$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "control", "Ha Insertado un nuevo  control medico");


		echo json_encode($_POST);
	}

	public function eliminarControl($datos)
	{
		$id_control = $datos[0];
		$this->modelo->eliminarControl($id_control);
		echo json_encode($_GET);
	}

	public function editarControl()
	{
		if ($_POST) {

			$editar = $this->modelo->editarControl($_POST["historialE"], $_POST["id_control"], $_POST["indicaciones"], $_POST["fechaRegreso"], $_POST["nota_e"]);

			if ($editar) {
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "control", "Ha modificado un  control medico");

				echo json_encode($_POST);
			} else {
				echo json_encode(["mensaje"=> "lamentablemente ocurrió un error por favor intente mas tarde."]);
			}
			
		}
	}
	// mostrar síntomas de pacientes
	public function mostrarSP($datos)
	{
		$idC = $datos[0];
		$respuestaS = $this->modelo->mostrarSintomasPaId($idC);
		echo json_encode($respuestaS);
	}
	// mostrar patología de pacientes
	public function mostrarPP($datos)
	{
		$idC = $datos[0];
		$registradosP = $this->modelo->mostrarPatologiaP($idC);
		echo json_encode($registradosP);
	}
	// mostrar patología de paciente por id del paciente
	public function mostrarPIdP($datos)
	{
		$idC = $datos[0];
		$registradosP = $this->modelo->mostrarPatologiaC($idC);
		echo json_encode($registradosP);
	}

	// síntomas 
	public function eliminarSintoma($datos)
	{
		$id_sintomas = $datos[0];
		$id_usuario_bitacora = $datos[1];
		$eliminar = $this->modeloSintomas->eliminarL($id_sintomas);
		if ($eliminar) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($id_usuario_bitacora, "sintomas", "Ha eliminado un  sintoma");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Control/control/eliminar");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Control/control/errorSistem");
		}
	}

	public function agregarSintoma()
	{
		$insertar = $this->modeloSintomas->insertar($_POST["nombreS"]);
		if ($insertar) {
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "sintomas", "Ha Insertado un  sintoma");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Control/control/registro");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Control/control/errorSistem");
		}
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
