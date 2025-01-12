<?php 
use App\modelos\ModeloCita;

class ControladorCitas{

	private $modelo;

	function __construct(){
		$this->modelo = new ModeloCita();
	}

	public function mostrarPacienteCita(){
		$datosPaciente = $this->modelo->selectPaciente($_POST["nacionalidad"], $_POST["cedula"]);
		echo json_encode($datosPaciente);
	}
	
	public function citas(){
		$datosCitas = $this->modelo->mostrarCita();
		$especialidades = $this->modelo->mostrarEspecialidadCita();
		require_once './src/vistas/vistasCitas/vistaCitas.php';
	}
	public function citasHoy(){
		date_default_timezone_set('America/Mexico_City');
		$fecha = date('Y-m-d');
		$datosCitasHoy = $this->modelo->mostrarCitaHoy($fecha);
		$especialidades = $this->modelo->mostrarEspecialidadCita();
		require_once './src/vistas/vistasCitas/vistaCitasHoy.php';
	}
	public function citasP(){
		$datosCitas = $this->modelo->mostrarCita();
		echo json_encode($datosCitas);
	}

	public function guardarCita(){
		date_default_timezone_set('America/Mexico_City');
		$fecha = date("Y-m-d");
		$resultadoDeCita = $this->modelo->validarCita($_POST['id_servicioMedico'],$_POST["fecha"],$_POST["hora"]);

		if ($resultadoDeCita === "existeC") {
			header("location:?c=controladorCitas/citas&error");

        }elseif ($_POST["fecha"] < $fecha){
			header("location:?c=controladorCitas/citas&fechainvalida");
		}
		else{
  
			print_r($_POST["dia"]);
		$this->modelo->insertarCita($_POST["id_paciente"],$_POST["id_servicioMedico"],$_POST["fecha"],$_POST["hora"],$_POST["estado"]);
		header("location: ?c=controladorCitas/citas&agregado");


        }
	}

	public function eliminarCita(){
		$this->modelo->eliminarCita($_GET["id_cita"]);
		header("location: ?c=controladorCitas/citas&eliminado");
	}
	public function eliminarCitaHoy(){
		$this->modelo->eliminarCita($_GET["id_cita"]);
		header("location: ?c=controladorCitas/citasHoy&eliminado");
	}
	
	public function eliminarCitaR(){
		$this->modelo->eliminarCita($_GET["id_cita"]);
		header("location: ?c=controladorCitas/citasRealizadas&eliminado");
	}



	
	public function citasHoyP(){
		date_default_timezone_set('America/Mexico_City');
		$fecha = date("Y-m-d");
		$datosCitasHoy = $this->modelo->mostrarCitaHoy($fecha);
		echo json_encode($datosCitasHoy);
	}

	public function citasRealizadas(){
		$datosCitasR = $this->modelo->mostrarCitaR();
		require_once './src/vistas/vistasCitas/vistaCitasRealizadas.php';
	}

	public function mostrarDoctoresCita(){
		$respuesta = $this->modelo->mostrarDoctores($_GET["id"]);
		echo json_encode($respuesta);
	}

	public function mostrarHorario(){
		$respuesta = $this->modelo->mostrarHorarioDoctores($_GET["idD"]);
		echo json_encode($respuesta);
	}


	public function mostrarBusquedaPendiente(){
		$datosCitas = $this->modelo->buscarPaciente($_POST["cedula"]);
		require_once './src/vistas/vistasCitas/busquedaCitas/resCitaP.php';
	}


	public function mostrarBusquedaPendienteHoy(){
		date_default_timezone_set('America/Mexico_City');
		$fecha = date("Y-m-d");
		$datosCitasHoy = $this->modelo->buscarPacienteHoy($_POST["cedula"],$fecha);
		require_once './src/vistas/vistasCitas/busquedaCitas/resCitaH.php';
	}


	public function mostrarBusquedaRealizadas(){
	
		$datosCitasR = $this->modelo->buscarRealizadas($_POST["cedula"]);
		require_once './src/vistas/vistasCitas/busquedaCitas/resCitaR.php';
	}


	public function editarCita(){
		date_default_timezone_set('America/Mexico_City');
		
		$fecha = date("Y-m-d");


		$resultadoDeCita = $this->modelo->validarCita($_POST['id_servicioMedico'],$_POST["fecha"],$_POST["hora"]);

        //se verifica si la cédula del input es igual a la cédula ya existente 
        if ($_GET["cedulaDb"] == $_POST["id_servicioMedico"]) {

			$this->modelo->update($_POST["id_servicioMedico"],$_POST["fecha"],$_POST["hora"],$_POST["id_cita"]);
			header("location: ?c=controladorCitas/citas&editado");

            // NOTA: Esto "&&" es "Y"
            //se verifica si la cédula del input no es igual a la cédula ya existente.  
        } elseif ($_GET["cedulaDb"] != $_POST["id_servicioMedico"]) {

            //verifica si la cédula es igual a la información de la base de datos.
            if ($resultadoDeCita === "existeC") {
				header("location: ?c=controladorCitas/citas&error");

            } else {

				$this->modelo->update($_POST["id_servicioMedico"],$_POST["fecha"],$_POST["hora"],$_POST["id_cita"]);
		header("location: ?c=controladorCitas/citas&editado");

            }

        } else {

			$this->modelo->update($_POST["id_servicioMedico"],$_POST["fecha"],$_POST["hora"],$_POST["id_cita"]);
			header("location: ?c=controladorCitas/citas&editado");

        }if ($_POST["fecha"] < $fecha){
			header("location:?c=controladorCitas/citas&fechainvalida");
		}




	}
	public function editarCitaHoy(){
		date_default_timezone_set('America/Mexico_City');

		$fecha = date("Y-m-d");

		
		$resultadoDeCita = $this->modelo->validarCita($_POST['id_servicioMedico'],$_POST["fecha"],$_POST["hora"]);

        //se verifica si la cédula del input es igual a la cédula ya existente 
        if ($_GET["cedulaDb"] == $_POST["id_servicioMedico"]) {

			$this->modelo->update($_POST["id_servicioMedico"],$_POST["fecha"],$_POST["hora"],$_POST["id_cita"]);
			header("location: ?c=controladorCitas/citasHoy&editado");

            // NOTA: Esto "&&" es "Y"
            //se verifica si la cédula del input no es igual a la cédula ya existente.  
        } elseif ($_GET["cedulaDb"] != $_POST["id_servicioMedico"]) {

            //verifica si la cédula es igual a la información de la base de datos.
            if ($resultadoDeCita === "existeC") {
				header("location: ?c=controladorCitas/citasHoy&error");

            } else {

				$this->modelo->update($_POST["id_servicioMedico"],$_POST["fecha"],$_POST["hora"],$_POST["id_cita"]);
		header("location: ?c=controladorCitas/citasHoy&editado");

            }

        } else {

			$this->modelo->update($_POST["id_servicioMedico"],$_POST["fecha"],$_POST["hora"],$_POST["id_cita"]);
			header("location: ?c=controladorCitas/citasHoy&editado");

        }
if ($_POST["fecha"] < $fecha){
			header("location:?c=controladorCitas/citasHoy&fechainvalida");
		}

	}


	// public function prueba(){
	// 	$respuesta = $this->modelo->prueba();
	// 	//$respuesta = array('id' =>7);
	// 	echo json_encode($respuesta);
	// }

	

		
}

 ?>