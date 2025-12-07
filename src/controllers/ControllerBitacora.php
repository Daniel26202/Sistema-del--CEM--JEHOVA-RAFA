<?php

use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloInicio;


function bitacoraUsuario($parametro)
{
	$ayuda = "btnayudaBitacora";
	$vistaActiva = 'Usuario';
	$modeloInicio = new ModeloInicio();

	$cargo = $modeloInicio->comprobarCargo($_SESSION['id_personal']);
	// require_once __DIR__ . "/../../src/vistas/vistaBitacora/bitacora.php";
	echo 'bitacora usuario';
}

function bitacora($parametro)
{
	$ayuda = "btnayudaBitacora";
	$vistaActiva = 'Admin';
	$modeloInicio = new ModeloInicio();

	echo 'bitacora administrador';
	$cargo = $modeloInicio->comprobarCargo($_SESSION['id_personal']);
	// require_once __DIR__ . "/../../src/vistas/vistaBitacora/bitacora.php";
}

function permisos($id_rol, $permiso, $modulo)
{
	$permisos = new ModeloPermisos();

	return $permisos->gestionarPermisos($id_rol, $permiso, $modulo);
}
