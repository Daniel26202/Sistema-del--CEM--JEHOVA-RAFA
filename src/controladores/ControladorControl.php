<?php

use App\modelos\ModeloControl;
use App\modelos\ModeloSintomas;
use App\modelos\ModeloPatologia;

class ControladorControl
{

	private $modelo;
	private $modeloSintomas;
	private $modeloPatologia;


	function __construct()
	{
		$this->modelo = new ModeloControl();
		$this->modeloSintomas = new ModeloSintomas();
		$this->modeloPatologia = new ModeloPatologia();
	}

	public function control()
	{
		$datosS = $this->modeloSintomas->selects();
		$datosD = $this->modelo->mostrarDoctor();
		$datosPatologias = $this->modeloPatologia->mostrarPatologias();

		require_once './src/vistas/vistaControl/vistaControl.php';
	}

	public function mostrarPacientesJS()
	{
		$respuesta = $this->modelo->consultarPacientes();
		echo json_encode($respuesta);
	}

	public function mostrarBusquedaPacientesJS()
	{
		$respuesta = $this->modelo->buscarPacientes($_GET["cedula"]);
		echo json_encode($respuesta);
	}

	public function mostrarControlPacientesJS()
	{

		session_start();
		$sesion = $_SESSION['rol'];
		$idUsuario = $_SESSION['id_usuario'];

		if ($sesion == "administrador") {

			$respuestaP = $this->modelo->mostrarControlPacienteA($_GET["cedula"]);
			//síntomas
			$registradosS = $this->modelo->mostrarSintomasPa($_GET["cedula"]);
			$sintomas = $this->modeloSintomas->selects();
			// patologías
			$registradosP = $this->modeloPatologia->buscarPatologiaPaciente($_GET["cedula"]);
			$patologias = $this->modeloPatologia->mostrarPatologias();

			// este array tiene tres valores de tres funciones en el modelo
			$arrayPSS = [$respuestaP, $registradosS, $sintomas, $registradosP, $patologias];
			echo json_encode($arrayPSS);
		} elseif ($sesion == "usuario") {
			// devuelve solo los datos del paciente atendido por el mismo doctor que inicio sesión(Usuario)
			$respuesta = $this->modelo->mostrarControlPacienteU($_GET["cedula"], $idUsuario);
			//síntomas
			$registradosS = $this->modelo->mostrarSintomasPa($_GET["cedula"]);
			$sintomas = $this->modeloSintomas->selects();
			// patologías
			$registradosP = $this->modeloPatologia->buscarPatologiaPaciente($_GET["cedula"]);
			$patologias = $this->modeloPatologia->mostrarPatologias();

			// este array tiene tres valores de tres funciones en el modelo
			$arrayPSS = [$respuesta, $registradosS, $sintomas, $registradosP, $patologias];
			echo json_encode($arrayPSS);
		}
	}

	public function mostrarPacienteJS()
	{
		// me traigo los datos de los pacientes
		$respuesta = $this->modelo->mostrarPaciente($_GET["cedula"]);

		echo json_encode($respuesta);
	}

	public function insertarControl()
	{
		$patologia = (isset($_POST["patologias"])) ? $_POST["patologias"] : false;
		$this->modelo->insertControl($_POST["doctor"], $_POST["id_paciente"], $_POST["diagnostico"], $_POST["sintomas"], $_POST["indicaciones"], $_POST["fechaRegreso"], $patologia, $_POST["nota"], $_POST["fecha_hora"]);

		echo json_encode($_POST);
	}

	public function eliminarControl()
	{
		$this->modelo->eliminarControl($_GET["id_control"]);
		echo json_encode($_GET);
	}

	public function editarControl()
	{
		if ($_POST) {

			$this->modelo->editarControl($_POST["id_control"], $_POST["indicaciones"], $_POST["fechaRegreso"], $_POST["nota_e"]);

			echo json_encode($_POST);
		}
	}
	// mostrar síntomas de pacientes
	public function mostrarSP()
	{
		$respuestaS = $this->modelo->mostrarSintomasPaId($_GET["idC"]);
		echo json_encode($respuestaS);
	}
	// mostrar patología de pacientes
	public function mostrarPP()
	{
		$registradosP = $this->modelo->mostrarPatologiaP($_GET["idC"]);
		echo json_encode($registradosP);
	}
	// mostrar patología de paciente por id del paciente
	public function mostrarPIdP()
	{
		$registradosP = $this->modelo->mostrarPatologiaC($_GET["idC"]);
		echo json_encode($registradosP);
	}

	// síntomas 
	public function eliminarSintoma()
	{
		$this->modeloSintomas->eliminarL($_GET["id_sintomas"]);
		header("location: ?c=ControladorControl/control");
	}

	public function agregarSintoma()
	{
		$this->modeloSintomas->insertar($_POST["nombreS"]);
		header("location: ?c=ControladorControl/control");
	}
}
