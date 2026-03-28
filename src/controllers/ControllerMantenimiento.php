<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloMantenimiento;
use App\modelos\ModeloPermisos;


function mantenimiento($parametro)
{
	$ayuda = "btnayudaMantenimiento";
	$vistaActiva = 'mantenimiento';
	require_once './src/vistas/vistaMantenimiento/mantenimiento.php';
}

function bajarBdsNube($parametro)
{
	$backupRuta = __DIR__ . "/../config/backups/";
	// Crea la carpeta de respaldos si no existe
	if (!is_dir($backupRuta)) {
		mkdir($backupRuta, 0777, true);
	}
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
	// Crea la carpeta de respaldos si no existe
	if (!is_dir($backupRuta)) {
		mkdir($backupRuta, 0777, true);
	}
	$modeloMantenimiento = new ModeloMantenimiento();

	$idUsuario = $_SESSION["id_usuario"];
	$respaldos = $modeloMantenimiento->traerBds($backupRuta);
	$arrayRU = [$respaldos, $idUsuario];
	echo json_encode($arrayRU);
}

function generarRespaldo($parametro)
{
	try {

		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		if (!$_SESSION["validarPBD"]) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => "Error, no tine permiso para generar el respaldo"]);
			exit;
		}

		$backupRuta = __DIR__ . "/../config/backups/";
		// Crea la carpeta de respaldos si no existe
		if (!is_dir($backupRuta)) {
			mkdir($backupRuta, 0777, true);
		}
		$modeloMantenimiento = new ModeloMantenimiento();
		$modeloBitacora = new ModeloBitacora();

		$id_usuario = $_SESSION["id_usuario"];
		$mensaje = $modeloMantenimiento->generateBackup($backupRuta);

		$modeloBitacora->setId_usuario($id_usuario);
		$modeloBitacora->setTabla("mantenimiento");
		$modeloBitacora->setActividad("Se ha realizado una descarga del respaldo de la base de datos");
		$modeloBitacora->insertarBitacora();

		echo json_encode(['ok' => true, 'message' => "La descarga se realizó con éxito."]);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function restaurarRespaldo($parametro)
{
	try {
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		if (!$_SESSION["validarPBD"]) {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => "Error, no tine permiso para el respaldo"]);
			exit;
		}

		$backupRuta = __DIR__ . "/../config/backups/";
		// Crea la carpeta de respaldos si no existe
		if (!is_dir($backupRuta)) {
			mkdir($backupRuta, 0777, true);
		}

		$modeloMantenimiento = new ModeloMantenimiento();
		$modeloBitacora = new ModeloBitacora();

		// buscar todos los archivos ZIP de respaldo
		$archivosZip = glob($backupRuta . "bd-*.zip");

		if (!empty($archivosZip)) {

			// print_r($parametro);
			if (isset($parametro[0]) && $parametro[0] != "nohay") {
				$nombreBd = $backupRuta .  $parametro[0] . ".zip";
				$nombreZip = $parametro[0];
			} else {
				// Ordenar por fecha de modificación
				usort($archivosZip, function ($a, $b) {
					return filemtime($b) - filemtime($a);
				});
				$nombreZip = basename($archivosZip[0]);
				$nombreBd = $archivosZip[0];
			}

			$id_usuario = $_SESSION["id_usuario"];

			$result = $modeloMantenimiento->restaurarBackup($backupRuta, $nombreBd);
			$modeloBitacora->setId_usuario($id_usuario);
			$modeloBitacora->setTabla("mantenimiento");
			$modeloBitacora->setActividad("Se ha restablecido la base de datos($nombreZip) desde el respaldo");
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => "La restauración se realizó con éxito, " . $result]);
		} else {
			echo json_encode(['ok' => false, 'error' => "No existe respaldo"]);
		}
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function verificacionU()
{
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	$_SESSION["validarPBD"] = false;
	$modeloMantenimiento = new ModeloMantenimiento();

	$modeloMantenimiento->setUsuario($_POST["usuario"]);
	$modeloMantenimiento->setPassword($_POST["password"]);
	$resultado = $modeloMantenimiento->verifU();
	$_SESSION["validarPBD"] = ($resultado) ? true : false;
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
