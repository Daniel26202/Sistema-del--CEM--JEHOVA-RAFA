<?php

use App\modelos\ModeloPacientes;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
// use App\

class ControladorPacientes
{
	private $modelo;
	private $bitacora;
	private $permisos;
	// private $hospitalizacion;


	function __construct()
	{
		$this->modelo = new ModeloPacientes;
		$this->bitacora = new ModeloBitacora; // Guarda la instancia de la bitacora
		$this->permisos = new ModeloPermisos();
		// $this->hospitalizacion = new ModeloHospitalizacion();
	}



	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}


	public function getPacientes($parametro)
	{
		$ayuda = "btnayudaPaciente";
		$pacientes = $this->modelo->index();
		$vistaActiva = 'pacientes';
		require_once './src/vistas/vistaPacientes/pacientes.php';
	}

	public function getPacientesAjax($parametro)
	{
		echo json_encode($this->modelo->index());
	}

	/* hay q hacerlo con ajax, pero lo hice sencillo, no se si se vaya a pasar a ajax to esto, pa despues del sabado ;) */
	public function getHistorialSalud($parametro)
	{
		$historial = $this->modelo->indexHistorial();
		$vistaActiva = 'historial';
		require './src/vistas/vistaPacientes/pacientes.php';
	}

	public function papeleraPaciente($parametro)
	{
		$pacientes = $this->modelo->indexPapelera();
		require_once './src/vistas/vistaPacientes/pacientesPapelera.php';
	}



	public function guardar()
	{
			$insercion = $this->modelo->insertar(
				$_POST['nacionalidad'],
				$_POST['cedula'],
				$_POST['nombre'],
				$_POST['apellido'],
				$_POST['telefono'],
				$_POST['direccion'],
				$_POST['fn'],
				$_POST['genero']
			);

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


	public function setPaciente()
	{
		// $edicion = $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero'], $_POST['cedulaRegistrada']);
		$edicion = $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'], $_POST['genero'], $_POST['cedulaRegistrada']);

		// $edicion = $this->modelo->validarCedula($_POST['cedula']);


		// echo json_encode(['ok' => true, 'error' => $edicion]);



		// // Verifica si es un array con clave "exito"
		if (is_array($edicion) && $edicion[0] === "exito") {
			$this->bitacora->insertarBitacora($_POST['id_usuario'], "paciente", "Ha modificado un paciente");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $edicion]);
			exit;
		}
	}

	public function eliminar($datos)
	{
		$cedula = $datos[0];
		$id_usuario = $datos[1];
		// guardar la bitacora
		$eliminacion = $this->modelo->delete($cedula);

		//Verifica si es un array con clave "exito"
		if (is_array($eliminacion) && $eliminacion[0] === "exito") {
			$this->bitacora->insertarBitacora($id_usuario, "paciente", "Ha eliminado un  paciente");
			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $eliminacion]);
			exit;
		}

	}
	public function restablecer($datos)
	{
		$id_paciente = $datos[0];
		$id_usuario = $datos[1];
		// guardar la bitacora
		$restablecimiento = $this->modelo->restablecer($id_paciente);
		if ($restablecimiento) {
			$this->bitacora->insertarBitacora($id_usuario, "paciente", "Ha restablecido un paciente");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/restablecido");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorSistem");
		}
	}


	public function mostrarPaciente()
	{
		$respuesta = $this->modelo->buscar($_POST['cedula']);
		echo json_encode($respuesta);
	}
}
