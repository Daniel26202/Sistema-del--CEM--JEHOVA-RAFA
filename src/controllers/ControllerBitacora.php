<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;


function bitacoraUsuario($parametro)
{
	$ayuda = "btnayudaBitacora";
	$vistaActiva = 'Usuario';
	$modeloInicio = new ModeloInicio(true);
	$modeloBitacora = new ModeloBitacora(false);

	$modeloInicio->setIdPersonal($_SESSION['id_personal']);
	$cargo = $modeloInicio->comprobarCargo();
	require_once __DIR__ . "/../../src/vistas/vistaBitacora/bitacora.php";
}

function bitacora($parametro)
{
	$ayuda = "btnayudaBitacora";
	$vistaActiva = 'Admin';
	$modeloInicio = new ModeloInicio(true);
	$modeloBitacora = new ModeloBitacora(false);

	$modeloInicio->setIdPersonal($_SESSION['id_personal']);
	$cargo = $modeloInicio->comprobarCargo();
	require_once __DIR__ . "/../../src/vistas/vistaBitacora/bitacora.php";
}

function permisos($id_rol, $permiso, $modulo)
{
	$permisos = new ModeloPermisos();

	return $permisos->gestionarPermisos($id_rol, $permiso, $modulo);
}

function bitacoraAjax()
{
	$modeloBitacora = new ModeloBitacora(false);
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}

	if (isset($_GET['vista']) && $_GET['vista'] == 'Admin') {
		echo json_encode($modeloBitacora->consultarBitacora($_SESSION['id_usuario']));
	} else {
		echo json_encode($modeloBitacora->consultarBitacora());
	}
}
