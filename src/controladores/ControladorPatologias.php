<?php

use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora; 


class ControladorPatologias
{
	private $patologia;
	private $bitacora;

	function __construct()
	{
		$this->patologia = new ModeloPatologia();
		$this->bitacora = new ModeloBitacora();
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

			// Guardo la bitacora
			$this->bitacora->insertarBitacora($_POST['id_usuario'],"patologia","Ha Insertado una patologia");

			header("location: ?c=ControladorPatologias/patologias&agregado");

        }
	}

	//eliminar patologia
	public function eliminarPatologia(){
		$this->patologia->eliminarPatologia($_GET["id_patologia"]);
		// Guardo la bitacora
		$this->bitacora->insertarBitacora($_GET['id_usuario'],"patologia","Ha eliminado una patologia");
		header("location: ?c=ControladorPatologias/patologias&eliminado");
	}
	public function restablecerPatologia(){
		$this->patologia->restablecer($_GET["id_patologia"]);
		// Guardo la bitacora
		$this->bitacora->insertarBitacora($_GET['id_usuario'],"patologia","Ha restablecido una patologia");
		header("location: ?c=ControladorPatologias/patologias&restablecida");
	}

	


	

}

?>