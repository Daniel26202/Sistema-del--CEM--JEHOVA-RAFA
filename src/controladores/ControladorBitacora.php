<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

class ControladorBitacora
{

	private $modelo;
	private $permisos;

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

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
