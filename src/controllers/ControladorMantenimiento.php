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
		$ayuda = "btnayudaMantenimiento";
		require_once './src/vistas/vistaMantenimiento/mantenimiento.php';
	}

	public function bajarBdsNube($parametro)
	{
		$resultado = $this->modelo->traerBdsNube($this->backupRuta);
		echo json_encode($resultado);
	}

	public function consultarBd($parametro)
	{
		// verifica si la sesión esta activa.
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
		$idUsuario = $_SESSION["id_usuario"];
		$respaldos = $this->modelo->traerBds($this->backupRuta);
		$arrayRU = [$respaldos, $idUsuario];
		echo json_encode($arrayRU);
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
				$nombreBd = $this->backupRuta .  $parametro[0] . ".zip";
				$nombreZip = $parametro[0];
				$id_usuario = $parametro[1];
			} else {
				// Ordenar por fecha de modificación
				usort($archivosZip, function ($a, $b) {
					return filemtime($b) - filemtime($a);
				});
				$nombreZip = basename($archivosZip[0]);

				$nombreBd = $archivosZip[0];
				$id_usuario = $parametro[1];
			}
			$this->modelo->restaurarBackup($this->backupRuta, $nombreBd);
			$this->bitacora->insertarBitacora($id_usuario, "mantenimiento", "Se ha restablecido la base de datos($nombreZip) desde el respaldo");


			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento/restaurado");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento/noExisteRespaldo");
		}
	}

	public function verificacionU($parametro)
	{
		$resultado = $this->modelo->verifU($_POST["usuario"], $_POST["password"]);
		echo json_encode($resultado);
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
