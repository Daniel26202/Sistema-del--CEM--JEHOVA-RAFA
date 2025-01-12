<?php

use App\modelos\ModeloPacientes;

class ControladorPacientes
{
	private $modelo;


	function __construct()
	{
		$this->modelo = new ModeloPacientes;
	}



	public function getPacientes()
	{
		$pacientes = $this->modelo->index();
		require_once './src/vistas/vistaPacientes/pacientes.php';
	}
	public function papeleraPaciente()
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
            header("location: ?c=ControladorPacientes/getPacientes&error");

        } elseif ($fecha <= $_POST['fn']) {
			header("location: ?c=ControladorPacientes/getPacientes&errorfecha");
          	
			}else{
				$this->modelo->insertar($_POST['nacionalidad'], $_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['direccion'], $_POST['fn'],$_POST["patologias"]);

				header("location: ?c=ControladorPacientes/getPacientes&registro=1");
			}
			

        
		
	}

	public function setPaciente()
	{
		$resultadoDeCedula = $this->modelo->validarCedula($_POST['cedulaEditar']);
		// date_default_timezone_set('America/Mexico_City');
		$fechaEditar = date("Y-m-d");

        //se verifica si la cédula del input es igual a la cédula ya existente 
	
		if ($fechaEditar <= $_POST['fnEditar'] ) {
			header("location: ?c=ControladorPacientes/getPacientes&errorfecha");
			exit();
		}
        elseif ($_GET["cedulaDb"] == $_POST["cedulaEditar"]) {

            $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidadEditar'], $_POST['cedulaEditar'], $_POST['nombreEditar'], $_POST['apellidoEditar'], $_POST['telefonoEditar'], $_POST['direccionEditar'], $_POST['fnEditar']);

			header("location: ?c=ControladorPacientes/getPacientes&editar=1");

            // NOTA: Esto "&&" es "Y"
            //se verifica si la cédula del input no es igual a la cédula ya existente.  
        } elseif ($_GET["cedulaDb"] != $_POST["cedulaEditar"]) {

            //verifica si la cédula es igual a la información de la base de datos.
            if ($resultadoDeCedula === "existeC") {
				header("location: ?c=ControladorPacientes/getPacientes&error");

            } else {

				$this->modelo->update($_POST['id_paciente'], $_POST['nacionalidadEditar'], $_POST['cedulaEditar'], $_POST['nombreEditar'], $_POST['apellidoEditar'], $_POST['telefonoEditar'], $_POST['direccionEditar'], $_POST['fnEditar']);

				header("location: ?c=ControladorPacientes/getPacientes&editar=1");

            }

        } else {

            $this->modelo->update($_POST['id_paciente'], $_POST['nacionalidadEditar'], $_POST['cedulaEditar'], $_POST['nombreEditar'], $_POST['apellidoEditar'], $_POST['telefonoEditar'], $_POST['direccionEditar'], $_POST['fnEditar']);
		header("location: ?c=ControladorPacientes/getPacientes&editar=1");

	}

	}

	public function eliminar()
	{
		$this->modelo->delete($_GET['id_paciente']);
		header("location: ?c=ControladorPacientes/getPacientes&eliminar");
		
		//$this->modelo->delete($_GET['getPacientes']);
		//header("location: ?c=ControladorPacientes/getPacientes&eliminar");

	}
	public function restablecer()
	{
		$this->modelo->restablecer($_GET['id_paciente']);
		header("location: ?c=ControladorPacientes/getPacientes&restablecido");
		
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
		header("location: ?c=ControladorPacientes/getPacientes&eliminar=1");
		

	}

}

?>