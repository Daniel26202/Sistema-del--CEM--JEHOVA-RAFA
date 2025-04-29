<?php

use App\modelos\ModeloPerfil;
use App\modelos\ModeloPermisos;
class ControladorPerfil{

	private $modelo;
	private $permisos;


	function __construct(){
		$this->modelo = new ModeloPerfil();
		$this->permisos = new ModeloPermisos();
	}
	
	public function perfil(){
		require_once './src/vistas/vistaPerfil/vistaPerfil.php';
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}


	

}


 ?>