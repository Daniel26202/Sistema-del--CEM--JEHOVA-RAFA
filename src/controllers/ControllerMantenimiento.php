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
	$resultado = $modeloMantenimiento->traerBds($backupRuta);
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
			echo json_encode(['ok' => false, 'error' => "Error, no tiene permiso para realizar esta acción"]);
			exit;
		}

		$backupRuta = __DIR__ . "/../config/backups/";
		if (!is_dir($backupRuta)) {
			mkdir($backupRuta, 0777, true);
		}

		// Lee el tipo enviado desde el JS (por defecto manual siempre será completo)
		$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'completo';

		$modeloMantenimiento = new ModeloMantenimiento();
		$modeloBitacora = new ModeloBitacora();

		$id_usuario = $_SESSION["id_usuario"];
		$mensaje = $modeloMantenimiento->generateBackup($backupRuta, $tipo);

		if ($mensaje === true) {
			$modeloBitacora->setId_usuario($id_usuario);
			$modeloBitacora->setTabla("mantenimiento");
			$modeloBitacora->setActividad("Se ha realizado un respaldo ({$tipo}) manual de la base de datos");
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => "La copia de seguridad se creó con éxito."]);
		} else {
			throw new Exception($mensaje);
		}
	} catch (Exception $e) {
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
			echo json_encode(['ok' => false, 'error' => "Error, no tiene permiso para ejecutar la restauración."]);
			exit;
		}

		$backupRuta = __DIR__ . "/../config/backups/";
		if (!is_dir($backupRuta)) {
			mkdir($backupRuta, 0777, true);
		}

		$modeloMantenimiento = new ModeloMantenimiento();
		$modeloBitacora = new ModeloBitacora();

		// Si el JS envió un archivo específico a restaurar
		if (isset($parametro[0]) && $parametro[0] != "nohay") {
			$archivoSujeto = $parametro[0];

			// Si el nombre ya trae el .zip desde el JS, no se lo duplicamos
			if (strpos($archivoSujeto, '.zip') !== false) {
				$nombreBd = $backupRuta . $archivoSujeto;
				$nombreZip = $archivoSujeto;
			} else {
				$nombreBd = $backupRuta . $archivoSujeto . ".zip";
				$nombreZip = $archivoSujeto . ".zip";
			}
		} else {
			// Si no envió nada ("nohay"), buscamos de forma automática el respaldo más reciente
			$archivosZip = glob($backupRuta . "bd-*.zip");

			// Si no encuentra con 'bd-', buscamos cualquier ZIP con prefijo que esté en la carpeta
			if (empty($archivosZip)) {
				$archivosZip = glob($backupRuta . "*.zip");
			}

			if (!empty($archivosZip)) {
				// Ordenar por fecha de modificación (Más reciente primero)
				usort($archivosZip, function ($a, $b) {
					return filemtime($b) - filemtime($a);
				});
				$nombreZip = basename($archivosZip[0]);
				$nombreBd = $archivosZip[0];
			} else {
				echo json_encode(['ok' => false, 'error' => "No se encontró ningún archivo de respaldo en la máquina local."]);
				exit;
			}
		}

		$id_usuario = $_SESSION["id_usuario"];

		// Ejecutamos la restauración local
		$result = $modeloMantenimiento->restaurarBackup($backupRuta, $nombreBd);

		// Validamos si el modelo retornó un mensaje exitoso o un error string
		if (strpos($result, 'exitosa') !== false) {
			$modeloBitacora->setId_usuario($id_usuario);
			$modeloBitacora->setTabla("mantenimiento");
			$modeloBitacora->setActividad("Se ha restablecido la base de datos local desde el archivo ($nombreZip)");
			$modeloBitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => "Éxito: " . $result]);
		} else {
			echo json_encode(['ok' => false, 'error' => $result]);
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
	echo json_encode(($resultado) ? true : false);
}

function permisos($id_rol, $permiso, $modulo)
{
	$modeloPermisos = new ModeloPermisos();
	$modeloPermisos->setIdRol($id_rol);
	$modeloPermisos->setPermiso($permiso);
	$modeloPermisos->setModulo($modulo);
	return $modeloPermisos->gestionarPermisos();
}
