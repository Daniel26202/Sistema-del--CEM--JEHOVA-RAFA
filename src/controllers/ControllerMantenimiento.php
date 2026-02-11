<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloMantenimiento;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloUsuarios;




function __construct()
{
	$backupRuta = __DIR__ . "/../config/backups/";
	// Crea la carpeta de respaldos si no existe
	if (!is_dir($backupRuta)) {
		mkdir($backupRuta, 0777, true);
	}
}

function mantenimiento($parametro)
{
	$ayuda = "btnayudaMantenimiento";
	require_once './src/vistas/vistaMantenimiento/mantenimiento.php';
}

function bajarBdsNube($parametro)
{
	$backupRuta = __DIR__ . "/../config/backups/";
	$modeloMantenimiento = new ModeloMantenimiento();
	$resultado = $modeloMantenimiento->traerBdsNube($backupRuta);
	echo json_encode($resultado);
}

function consultarBd($parametro)
{
	// verifica si la sesión esta activa.
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	$backupRuta = __DIR__ . "/../config/backups/";
	$modeloMantenimiento = new ModeloMantenimiento();

	$idUsuario = $_SESSION["id_usuario"];
	$respaldos = $modeloMantenimiento->traerBds($backupRuta);
	$arrayRU = [$respaldos, $idUsuario];
	echo json_encode($arrayRU);
}

function generarRespaldo($parametro)
{
	$backupRuta = __DIR__ . "/../config/backups/";
	$modeloMantenimiento = new ModeloMantenimiento();
	$modeloBitacora = new ModeloBitacora();

	$id_usuario = $parametro[0];
	$modeloMantenimiento->generateBackup($backupRuta);

	$modeloBitacora->setId_usuario($id_usuario);
	$modeloBitacora->setTabla("mantenimiento");
	$modeloBitacora->setActividad("Se ha realizado una descarga del respaldo de la base de datos");
	$modeloBitacora->insertarBitacora();

	header("location: /Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento/guardado");
}

function restaurarRespaldo($parametro)
{
	$backupRuta = __DIR__ . "/../config/backups/";
	$modeloMantenimiento = new ModeloMantenimiento();
	$modeloBitacora = new ModeloBitacora();

	// buscar todos los archivos ZIP de respaldo
	$archivosZip = glob($backupRuta . "bd-*.zip");

	if (!empty($archivosZip)) {

		print_r($parametro);
		if (isset($parametro[0]) && $parametro[0] != "nohay") {
			$nombreBd = $backupRuta .  $parametro[0] . ".zip";
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
		$modeloMantenimiento->restaurarBackup($backupRuta, $nombreBd);
		$modeloBitacora->setId_usuario($id_usuario);
		$modeloBitacora->setTabla("mantenimiento");
		$modeloBitacora->setActividad("Se ha restablecido la base de datos($nombreZip) desde el respaldo");
		$modeloBitacora->insertarBitacora();

		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento/restaurado");
	} else {
		header("location: /Sistema-del--CEM--JEHOVA-RAFA/Mantenimiento/mantenimiento/noExisteRespaldo");
	}
}

function verificacionU($parametro)
{
	$modeloMantenimiento = new ModeloMantenimiento();
	$modeloUsuarios = new ModeloUsuarios();

	$modeloUsuarios->setUsuario($_POST["usuario"]);
	$modeloUsuarios->setPassword($_POST["password"]);
	$resultado = $modeloMantenimiento->verifU();
	echo json_encode($resultado);
}

function permisos($id_rol, $permiso, $modulo)
{
	$modeloPermisos = new ModeloPermisos();
	$modeloPermisos->setIdRol($id_rol);
	$modeloPermisos->setPermiso($permiso);
	$modeloPermisos->setModulo($modulo);
	return $modeloPermisos->gestionarPermisos();
}
