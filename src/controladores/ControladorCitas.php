<?php

use App\modelos\ModeloCita;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPacientes;

class ControladorCitas
{

	private $modelo;
	private $bitacora;
	private $modeloPacientes;

	function __construct()
	{
		$this->modelo = new ModeloCita();
		$this->bitacora = new ModeloBitacora;
		$this->modeloPacientes = new ModeloPacientes();
	}

	public function insertaPaciente()
	{
		//si la cedula eiste le mando un mensaje al usuario y si else pues lo inserto normal
		$resultadoDeCedula = $this->modeloPacientes->validarCedula($_POST['cedula']);
		if ($resultadoDeCedula === "existeC") {
			//mensaje de erro
			$mensajeDeError = array("cedula" => "error");
			echo json_encode($mensajeDeError);
		} else {
			// guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha Insertado un nuevo paciente");


			$this->modeloPacientes->insertar($_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn']);

			echo json_encode($_POST);
		}
	}

	public function mostrarPacienteCita()
	{
		$datosPaciente = $this->modelo->selectPaciente($_POST["nacionalidad"], $_POST["cedula"]);
		echo json_encode($datosPaciente);
	}



	public function mostrarPacienteCitaGet($datos)
	{
		$nacionalidad = $datos[0];
		$cedula = $datos[1];
		$datosPaciente = $this->modelo->selectPaciente($nacionalidad, $cedula);
		echo json_encode($datosPaciente);
	}

	public function citas($parametro)
	{

		$vistaActiva = 'pendientes';

		$especialidades = $this->modelo->mostrarEspecialidadCita();

		$datosCitas = $this->modelo->mostrarCita();

		require_once './src/vistas/vistasCitas/vistaCitas.php';
	}
	public function citasHoy($parametro)
	{
		$vistaActiva = 'hoy';

		date_default_timezone_set('America/Mexico_City');
		$fecha = date('Y-m-d');

		$especialidades = $this->modelo->mostrarEspecialidadCita();


		$datosCitas = $this->modelo->mostrarCitaHoy($fecha);


		require_once './src/vistas/vistasCitas/vistaCitas.php';
	}
	public function citasP($parametro)
	{
		$datosCitas = $this->modelo->mostrarCita();
		echo json_encode($datosCitas);
	}

	public function guardarCita()
	{
		date_default_timezone_set('America/Mexico_City');
		$fecha = date("Y-m-d");
		$resultadoDeCita = $this->modelo->validarCita($_POST['id_paciente'], $_POST["fecha"], $_POST["hora"]);

		if ($resultadoDeCita === "existeC") {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/error");
		} elseif ($_POST["fecha"] < $fecha) {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/fechainvalida");
		} else {
			print_r($_POST);

			echo $_POST["id_servicioMedico"];
			
			$this->modelo->insertarCita($_POST["id_paciente"], $_POST["id_servicioMedico"], $_POST["fecha"], $_POST["hora"], $_POST["estado"]);

			

			// // Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha Insertado una  cita");

			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/agregado");
		}
	}

	public function eliminarCita($datos)
	{
		$id_cita = $datos[0];
		$id_usuario = $datos[1];
		$this->modelo->eliminarCita($id_cita);
		$this->bitacora->insertarBitacora($id_usuario, "cita", "Ha eliminado una  cita");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/eliminado");
	}
	public function eliminarCitaHoy($datos)
	{
		$id_cita = $datos[0];
		$id_usuario = $datos[1];
		$this->modelo->eliminarCita($id_cita);
		$this->bitacora->insertarBitacora($id_usuario, "cita", "Ha eliminado una  cita");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citasHoy/eliminado");
	}

	public function eliminarCitaR($datos)
	{
		$id_cita = $datos[0];
		$id_usuario = $datos[1];
		$this->modelo->eliminarCita($id_cita);
		$this->bitacora->insertarBitacora($id_usuario, "cita", "Ha eliminado una  cita");
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citasRealizadas/eliminado");
	}




	public function citasHoyP()
	{
		date_default_timezone_set('America/Mexico_City');
		$fecha = date("Y-m-d");
		$datosCitasHoy = $this->modelo->mostrarCitaHoy($fecha);
		echo json_encode($datosCitasHoy);
	}

	public function citasRealizadas($parametro)
	{

		$vistaActiva = 'realizadas';
		$datosCitas = $this->modelo->mostrarCitaR();


		require_once './src/vistas/vistasCitas/vistaCitas.php';
	}

	public function mostrarDoctoresCita($datos)
	{
		$id = $datos[0];
		$respuesta = $this->modelo->mostrarDoctores($id);
		echo json_encode($respuesta);
	}

	public function mostrarHorario($datos)
	{
		$idD = $datos[0];
		$respuesta = $this->modelo->mostrarHorarioDoctores($idD);
		echo json_encode($respuesta);
	}








	public function editarCita($datos)
	{
		date_default_timezone_set('America/Mexico_City');

		$fecha = date("Y-m-d");
		$cedula = $datos[0];


		$resultadoDeCita = $this->modelo->validarCita($_POST['id_paciente'], $_POST["fecha"], $_POST["hora"]);

		//se verifica si la cédula del input es igual a la cédula ya existente 
		if ($cedula == $_POST["id_servicioMedico"]) {

			$this->modelo->update($_POST["id_servicioMedico"], $_POST["fecha"], $_POST["hora"], $_POST["id_cita"]);
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una  cita");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/editado");

			// NOTA: Esto "&&" es "Y"
			//se verifica si la cédula del input no es igual a la cédula ya existente.  
		} elseif ($cedula != $_POST["id_servicioMedico"]) {

			//verifica si la cédula es igual a la información de la base de datos.
			if ($resultadoDeCita === "existeC") {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/error");
			} else {

				$this->modelo->update($_POST["id_servicioMedico"], $_POST["fecha"], $_POST["hora"], $_POST["id_cita"]);
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una  cita");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/editado");
			}
		} else {

			$this->modelo->update($_POST["id_servicioMedico"], $_POST["fecha"], $_POST["hora"], $_POST["id_cita"]);
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una  cita");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/editado");
		}
		if ($_POST["fecha"] < $fecha) {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/fechainvalida");
		}
	}
	public function editarCitaHoy($datos)
	{
		date_default_timezone_set('America/Mexico_City');

		$fecha = date("Y-m-d");

		$cedula = $datos[0];


		$resultadoDeCita = $this->modelo->validarCita($_POST['id_paciente'], $_POST["fecha"], $_POST["hora"]);

		//se verifica si la cédula del input es igual a la cédula ya existente 
		if ($cedula == $_POST["id_servicioMedico"]) {

			$this->modelo->update($_POST["id_servicioMedico"], $_POST["fecha"], $_POST["hora"], $_POST["id_cita"]);
			// Guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una  cita");

			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citasHoy/editado");

			// NOTA: Esto "&&" es "Y"
			//se verifica si la cédula del input no es igual a la cédula ya existente.  
		} elseif ($_GET["cedulaDb"] != $_POST["id_servicioMedico"]) {

			//verifica si la cédula es igual a la información de la base de datos.
			if ($resultadoDeCita === "existeC") {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citasHoy/error");
			} else {

				$this->modelo->update($_POST["id_servicioMedico"], $_POST["fecha"], $_POST["hora"], $_POST["id_cita"]);
				$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una  cita");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citasHoy/editado");
			}
		} else {

			$this->modelo->update($_POST["id_servicioMedico"], $_POST["fecha"], $_POST["hora"], $_POST["id_cita"]);
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una  cita");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citasHoy/editado");
		}
		if ($_POST["fecha"] < $fecha) {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citasHoy/fechainvalida");
		}
	}


	// public function prueba(){
	// 	$respuesta = $this->modelo->prueba();
	// 	//$respuesta = array('id' =>7);
	// 	echo json_encode($respuesta);
	// }




}
