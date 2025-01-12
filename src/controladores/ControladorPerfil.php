<?php

use App\modelos\ModeloPerfil;
class ControladorPerfil{

	private $modelo;


	function __construct(){
		$this->modelo = new ModeloPerfil();
	}
	
	public function perfil(){
		require_once './src/vistas/vistaPerfil/vistaPerfil.php';
	}


	

}


 ?>