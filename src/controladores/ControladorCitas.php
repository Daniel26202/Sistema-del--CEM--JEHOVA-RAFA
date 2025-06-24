<?php

use App\modelos\ModeloCita;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPacientes;
use App\modelos\ModeloPermisos;

class ControladorCitas
{

	private $modelo;
	private $bitacora;
	private $modeloPacientes;
	private $permisos;

	function __construct()
	{
		$this->modelo = new ModeloCita();
		$this->bitacora = new ModeloBitacora;
		$this->modeloPacientes = new ModeloPacientes();
		$this->permisos = new ModeloPermisos();
	}

	public function insertaPaciente()
	{
		//si la cedula eiste le mando un mensaje al usuario y si else pues lo inserto normal
		$resultadoDeCedula = $this->modeloPacientes->validarCedula($_POST['cedula']);
		//mensaje de erro
		$mensajeDeError = array("cedula" => "error");
		if ($resultadoDeCedula === "existeC") {
			echo json_encode($mensajeDeError);
		} else {
			$insercion = $this->modeloPacientes->insertar($_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST["genero"]);

			if ($insercion) {
				// guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha Insertado un nuevo paciente");
				echo json_encode($_POST);
			} else {
				echo json_encode($mensajeDeError);
			}
		}
	}

	public function mostrarPacienteCita()
	{
		$datosPaciente = $this->modelo->selectPaciente($_POST["nacionalidad"], $_POST["cedulaCita"]);
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
		$ayuda = "btnayudaCitaP";
		$vistaActiva = 'pendientes';
		$servicios = $this->modelo->mostrarServicioDoctor();
		$datosCitas = $this->modelo->mostrarCita();
		require_once './src/vistas/vistasCitas/vistaCitas.php';
	}
	public function citasHoy($parametro)
	{
		$ayuda = "btnayudaCitaP";
		$vistaActiva = 'hoy';
		date_default_timezone_set('America/Mexico_City');
		$fecha = date('Y-m-d');
		$servicios = $this->modelo->mostrarServicioDoctor();
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
		print_r($_POST);
		date_default_timezone_set('America/Mexico_City');
		$fecha = date("Y-m-d");
		$resultadoDeCita = $this->modelo->validarCita($_POST['id_paciente'], $_POST["fechaDeCita"], $_POST["hora"]);

		if ($resultadoDeCita === "existeC") {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/errorCita");
		} elseif ($_POST["fechaDeCita"] < $fecha) {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/fechainvalida");
		} else {
			$insercion = $this->modelo->insertarCita($_POST["id_paciente"], $_POST["id_servicioMedico"], $_POST["fechaDeCita"], $_POST["hora"], $_POST["estado"], $_POST["id_doctor"]);

			if ($insercion) {
				// // Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha Insertado una  cita");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/registro");
			} else {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/errorSistem");
			}
		}
	}

	public function eliminarCita($datos)
	{
		$id_cita = $datos[0];
		$id_usuario = $datos[1];
		$eliminacion = $this->modelo->eliminarCita($id_cita);
		if ($eliminacion) {
			$this->bitacora->insertarBitacora($id_usuario, "cita", "Ha eliminado una  cita");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/eliminar");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/errorSistem");
		}
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
		$ayuda = "btnayudaCitaP";
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

		$resultadoDeCita = $this->modelo->validarCita($_POST['id_paciente'], $_POST["fechaDeCita"], $_POST["hora"]);

		//se verifica si la cédula del input es igual a la cédula ya existente 
		if ($cedula == $_POST["serviciomedico_id_servicioMedico"]) {
			$edicion = $this->modelo->update($_POST["serviciomedico_id_servicioMedico"], $_POST["fechaDeCita"], $_POST["hora"], $_POST["id_cita"]);
			if ($edicion) {
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una  cita");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/editar");
			} else {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/errorSistem");
			}

			// NOTA: Esto "&&" es "Y"
			//se verifica si la cédula del input no es igual a la cédula ya existente.  
		} elseif ($cedula != $_POST["serviciomedico_id_servicioMedico"]) {

			//verifica si la cédula es igual a la información de la base de datos.
			if ($resultadoDeCita === "existeC") {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/error");
			} else {

				$edicion = $this->modelo->update($_POST["serviciomedico_id_servicioMedico"], $_POST["fechaDeCita"], $_POST["hora"], $_POST["id_cita"]);
				if ($edicion) {
					// Guardar la bitacora
					$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una  cita");
					header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/editar");
				} else {
					header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/errorSistem");
				}
			}
		} else {
			$edicion = $this->modelo->update($_POST["serviciomedico_id_servicioMedico"], $_POST["fechaDeCita"], $_POST["hora"], $_POST["id_cita"]);
			if ($edicion) {
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una  cita");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/editar");
			} else {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/errorSistem");
			}
		}
		if ($_POST["fechaDeCita"] < $fecha) {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Citas/citas/fechainvalida");
		}
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}

	public function validarHorariosDisponlibles($datos){
		echo  json_encode($this->modelo->validarHorariosDisponlibles($datos[0],$datos[1]));
	}
}
