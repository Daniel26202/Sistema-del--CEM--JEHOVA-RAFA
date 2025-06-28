<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloMantenimiento;
use App\modelos\ModeloPermisos;

class ControladorMantenimiento
{

	private $modelo;
	private $bitacora;
	private $permisos;
	private $backupRuta = __DIR__ . "/../config/backups/";

	function __construct()
	{
		$this->bitacora = new ModeloBitacora;
		$this->modelo = new ModeloMantenimiento();
		$this->permisos = new ModeloPermisos();


		// Crea la carpeta de respaldos si no existe
		if (!is_dir($this->backupRuta)) {
			mkdir($this->backupRuta, 0777, true);
		}
	}



	public function mantenimiento($parametro)
	{
		$respaldos = $this->modelo->traerBds($this->backupRuta);
		require_once './src/vistas/vistaMantenimiento/mantenimiento.php';
	}

	public function generarRespaldo($parametro)
	{
		$id_usuario = $parametro[0];
		$this->modelo->generateBackup($this->backupRuta);
		$this->bitacora->insertarBitacora($id_usuario, "mantenimiento", "Se ha realizado una descarga del respaldo de la base de datos");

		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento/guardado");
	}
	public function restaurarRespaldo($parametro)
	{
		

		// buscar todos los archivos ZIP de respaldo
		$archivosZip = glob($this->backupRuta . "bd-*.zip");

		if (!empty($archivosZip)) {

			print_r($parametro);
			if (isset($parametro[0]) && $parametro[0] != "nohay") {
				$nombreBd = $parametro[0];
				$nombreZip = $parametro[0];
				$id_usuario = $parametro[1];
			} else {
				$nombreBd = null;
				// Ordenar por fecha de modificación
				usort($archivosZip, function ($a, $b) {
					return filemtime($b) - filemtime($a);
				});
				$nombreZip = basename($archivosZip[0]);
				$id_usuario = $parametro[1];
			}
			$this->modelo->restaurarBackup($this->backupRuta, $nombreBd);
			$this->bitacora->insertarBitacora($id_usuario, "mantenimiento", "Se ha restablecido la base de datos($nombreZip) desde el respaldo");


			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento/restaurado");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento/noExisteRespaldo");
		}
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
