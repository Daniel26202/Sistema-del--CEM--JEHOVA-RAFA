<?php

use App\modelos\ModeloPacientes;
use App\modelos\ModeloBitacora; 

class ControladorPacientes
{
	private $modelo;
	private $bitacora;


	function __construct()
	{
		$this->modelo = new ModeloPacientes;
		$this->bitacora = new ModeloBitacora; // Guarda la instancia de la bitacora
	}



	public function getPacientes($parametro)
	{
		$pacientes = $this->modelo->index();
		require_once './src/vistas/vistaPacientes/pacientes.php';
	}
	public function papeleraPaciente($parametro)
	{
		$pacientes = $this->modelo->indexPapelera();
		require_once './src/vistas/vistaPacientes/pacientesPapelera.php';
	}



	public function guardar()
	{
        $resultadoDeCedula = $this->modelo->validarCedula($_POST['cedula']);
		// date_default_timezone_set('America/Mexico_City');
		$fecha = date("Y-m-d");
		
		if ($resultadoDeCedula === "existeC") {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/error");

        } elseif ($fecha <= $_POST['fn']) {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorfecha");
          	
			}else{

				// guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario'],"paciente","Ha Insertado un nuevo paciente");


				$this->modelo->insertar($_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn']);

				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/registro");
			}
			

        
		
	}

	public function setPaciente($cedula)
	{
		$cedula = $cedula[0];
		$resultadoDeCedula = $this->modelo->validarCedula($cedula);
		// date_default_timezone_set('America/Mexico_City');
		$fechaEditar = date("Y-m-d");

        //se verifica si la cédula del input es igual a la cédula ya existente 
	
		if ($fechaEditar <= $_POST['fnEditar'] ) {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/errorfecha");
			exit();
		}
        elseif ($cedula == $_POST["cedulaEditar"]) {

        	// guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'],"paciente","Ha modificado un paciente");

            $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidadEditar'], $_POST['cedulaEditar'], $_POST['nombreEditar'], $_POST['apellidoEditar'], $_POST['telefonoEditar'], $_POST['direccionEditar'], $_POST['fnEditar']);

			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/editar");

            // NOTA: Esto "&&" es "Y"
            //se verifica si la cédula del input no es igual a la cédula ya existente.  
        } elseif ($_GET["cedulaDb"] != $_POST["cedulaEditar"]) {

            //verifica si la cédula es igual a la información de la base de datos.
            if ($resultadoDeCedula === "existeC") {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/error");

            } else {

            	// guardar la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario'],"paciente","Ha modificado un paciente");

				$this->modelo->update($_POST['id_paciente'], $_POST['nacionalidadEditar'], $_POST['cedulaEditar'], $_POST['nombreEditar'], $_POST['apellidoEditar'], $_POST['telefonoEditar'], $_POST['direccionEditar'], $_POST['fnEditar']);

				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/editar");

            }

        } else {

        	// guardar la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'],"paciente","Ha modificado un paciente");

            $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidadEditar'], $_POST['cedulaEditar'], $_POST['nombreEditar'], $_POST['apellidoEditar'], $_POST['telefonoEditar'], $_POST['direccionEditar'], $_POST['fnEditar']);
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/editar");

	}

	}

	public function eliminar($datos)
	{
		

		$id_paciente = $datos[0];
		$id_usuario = $datos[1];

		// guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario,"paciente","Ha eliminado un  paciente");
		$this->modelo->delete($id_paciente);
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/eliminar");
		
		//$this->modelo->delete($_GET['getPacientes']);
		//header("location: ?c=ControladorPacientes/getPacientes&eliminar");

	}
	public function restablecer($datos)
	{

		$id_paciente = $datos[0];
		$id_usuario = $datos[1];

		// guardar la bitacora
		$this->bitacora->insertarBitacora($id_usuario,"paciente","Ha restablecido un paciente");

		$this->modelo->restablecer($id_paciente);
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Pacientes/getPacientes/restablecido");
		
		//$this->modelo->delete($_GET['getPacientes']);
		//header("location: ?c=ControladorPacientes/getPacientes&eliminar");

	}

	
	public function mostrarPaciente()
	{
		$respuesta = $this->modelo->buscar($_POST['cedula']);
		echo json_encode($respuesta);
	}
	public function eliminarBuscador()
	{
		$this->modelo->delete($_POST['id_paciente']);
		header("location: ?c=ControladorPacientes/getPacientes/eliminar");
		

	}

}

?>