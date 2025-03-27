<?php 
use App\modelos\ModeloBitacora; 

class ControladorBitacora{

	private $modelo;


	function __construct(){
		$this->modelo = new ModeloBitacora();
	}


	public function bitacora($parametro){
		require_once "./src/vistas/vistaBitacora/bitacora.php";
	}

}