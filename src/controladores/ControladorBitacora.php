<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;

class ControladorBitacora
{

	private $modelo;
	private $permisos;
	private $modeloInicio;

	function __construct()
	{
		$this->modelo = new ModeloBitacora();
		$this->permisos = new ModeloPermisos();
		$this->modeloInicio = new ModeloInicio();
	}


	public function bitacoraUsuario($parametro)
	{
		$vistaActiva = 'Usuario';
		$cargo = $this->modeloInicio->comprobarCargo($_SESSION["id_usuario"]);
		require_once "./src/vistas/vistaBitacora/bitacora.php";
	}

	public function bitacora($parametro)
	{
		$vistaActiva = 'Admin';
		$cargo = $this->modeloInicio->comprobarCargo($_SESSION["id_usuario"]);
		require_once "./src/vistas/vistaBitacora/bitacora.php";
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
