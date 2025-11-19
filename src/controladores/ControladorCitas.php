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

		$insercion = $this->modeloPacientes->insertar($_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST["genero"]);

		// Verifica si es un array con clave "exito"
		if (is_array($insercion) && $insercion[0] === "exito") {
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha Insertado un nuevo paciente");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insercion]);
			exit;
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
		require_once './src/vistas/vistasCitas/vistaCitas.php';
	}
	public function citasAjax()
	{
		$datosCitas = $this->modelo->mostrarCita();
		echo json_encode($datosCitas);
	}

	public function citasHoy($parametro)
	{
		$ayuda = "btnayudaCitaP";
		$vistaActiva = 'hoy';
		$servicios = $this->modelo->mostrarServicioDoctor();
		require_once './src/vistas/vistasCitas/vistaCitas.php';
	}

	public  function citasHoyAjax()
	{
		date_default_timezone_set('America/Mexico_City');
		$fecha = date('Y-m-d');
		echo json_encode($this->modelo->mostrarCitaHoy($fecha));
	}
	public function citasP($parametro)
	{
		$datosCitas = $this->modelo->mostrarCita();
		echo json_encode($datosCitas);
	}

	public function guardarCita()
	{

		$insercion = $this->modelo->insertarCita($_POST["id_paciente"], $_POST["id_servicioMedico"], $_POST["fechaDeCita"], $_POST["hora"], $_POST["estado"], $_POST["id_doctor"]);

		if (is_array($insercion) && $insercion[0] === "exito") {
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha Insertado una  cita");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $insercion]);
			exit;
		}
	}

	public function eliminarCita($datos)
	{
		$id_cita = $datos[0];
		$id_usuario = $datos[1];
		$eliminacion = $this->modelo->eliminarCita($id_cita);

		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$this->bitacora->insertarBitacora($id_usuario, "cita", "Ha eliminado una cita");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $eliminacion]);
			exit;
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
		require_once './src/vistas/vistasCitas/vistaCitas.php';
	}

	public  function citasRealizadasAjax()
	{
		echo json_encode($this->modelo->mostrarCitaR());
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
	public function editarCita()
	{
		$edicion = $this->modelo->update($_POST["serviciomedico_id_servicioMedico"], $_POST["fechaDeCita"], $_POST["hora"], $_POST["id_cita"]);

		if (is_array($edicion) && $edicion[0] === "exito") {
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "cita", "Ha modificado una cita");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $edicion]);
			exit;
		}
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}

	public function validarHorariosDisponlibles($datos)
	{
		echo  json_encode($this->modelo->validarHorariosDisponlibles($datos[0], $datos[1]));
	}
}
