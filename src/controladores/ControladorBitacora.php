<?php

use App\modelos\ModeloBitacora;

class ControladorBitacora
{

	private $modelo;


	function __construct()
	{
		$this->modelo = new ModeloBitacora();
	}


	public function bitacora($parametro)
	{
		$vistaActiva = 'Admin';
		require_once "./src/vistas/vistaBitacora/bitacora.php";
	}

	public function bitacoraUsuario($parametro)
	{
		$vistaActiva = 'Usuario';
		require_once "./src/vistas/vistaBitacora/bitacora.php";
	}
}
