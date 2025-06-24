<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloMantenimiento;
use App\modelos\ModeloPermisos;

class ControladorMantenimiento
{

	private $modelo;
	// private $bitacora;
	private $permisos;
	private $backupRuta = __DIR__ . "/../config/backups/";

	function __construct()
	{
		// $this->bitacora = new ModeloBitacora;
		$this->modelo = new ModeloMantenimiento();
		$this->permisos = new ModeloPermisos();
		// Crea la carpeta de respaldos si no existe
		if (!is_dir($this->backupRuta)) {
			mkdir($this->backupRuta, 0777, true);
		}
	}

	public function mantenimiento()
	{
		$respaldos = $this->modelo->traerBds($this->backupRuta);
		require_once './src/vistas/vistaMantenimiento/mantenimiento.php';
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}

	public function generarRespaldo()
	{
		return $this->modelo->generateBackup($this->backupRuta);
		header("location:/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento");
	}
	public function restaurarRespaldo($parametro)
	{

		if (isset($parametro[0])) {
			$nombreBd = $parametro[0];
		} else {
			$nombreBd = null;
		}
		$this->modelo->restaurarBackup($this->backupRuta, $nombreBd);
		header("location:/Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento");
	}
}
