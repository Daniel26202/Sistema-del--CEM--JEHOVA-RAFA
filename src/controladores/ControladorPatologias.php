<?php

use App\modelos\ModeloPatologia;


class ControladorPatologias
{
	private $patologia;

	function __construct()
	{
		$this->patologia = new ModeloPatologia();
	}

	public function patologias()
	{
		$datosPatologias = $this->patologia->mostrarPatologias();
		require_once './src/vistas/vistaPatologia/patologia.php';
	}
	public function papeleraPatologias()
	{
		$datosPatologias = $this->patologia->mostrarPatologiasEliminadas();
		require_once './src/vistas/vistaPatologia/patologiapapelera.php';
	}

	//insertar patologia 
	public function registrarPatologia(){
	

		$resultaPatologia = $this->patologia->nombrePatologia($_POST['nombrePatologia']);

		
		if ($resultaPatologia === "existeC") {
			header("location:?c=ControladorPatologias/patologias&error");

        } else {
          
            
			$this->patologia->insertarPatologia($_POST["nombrePatologia"]);
		header("location: ?c=ControladorPatologias/patologias&agregado");

        }
	}

	//eliminar patologia
	public function eliminarPatologia(){
		$this->patologia->eliminarPatologia($_GET["id_patologia"]);
		header("location: ?c=ControladorPatologias/patologias&eliminado");
	}
	public function restablecerPatologia(){
		$this->patologia->restablecer($_GET["id_patologia"]);
		header("location: ?c=ControladorPatologias/patologias&restablecida");
	}

	


	

}

?>