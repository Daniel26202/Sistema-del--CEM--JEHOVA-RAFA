<?php

use App\modelos\ModeloEstadisticas;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;





function estadisticas()
{
	$ayuda = "btnayudaEstadistica";
	$vistaActiva = "estadisticas";
	require_once './src/vistas/vistaEstadisticas/vistaEstadisticas.php';
}

function edadGenero()
{
	$modeloEstadisticas = new ModeloEstadisticas();
	$edadGenero = $modeloEstadisticas->distribucion_edad_genero();
	echo json_encode($edadGenero);
}

function tasaMorbilidad()
{
	$modeloEstadisticas = new ModeloEstadisticas();

	$tasa_morbilidad = $modeloEstadisticas->tasa_morbilidad();
	echo json_encode($tasa_morbilidad);
}

function filtrar_tasaMorbilidad($datos)
{
	$modeloEstadisticas = new ModeloEstadisticas();
	$modeloEstadisticas->setFechaInicio($datos[0]);
	$modeloEstadisticas->setFechaFinal($datos[1]);

	$tasa_morbilidad = $modeloEstadisticas->tasa_morbilidad();
	echo json_encode($tasa_morbilidad);
}

function permisos($id_rol, $permiso, $modulo)
{
	$modeloPermisos = new ModeloPermisos();
	$modeloPermisos->setIdRol($id_rol);
	$modeloPermisos->setPermiso($permiso);
	$modeloPermisos->setModulo($modulo);

	return $modeloPermisos->gestionarPermisos();
}

function insumos()
{
	$modeloEstadisticas = new ModeloEstadisticas();
	$insumos = $modeloEstadisticas->insumos();
	echo json_encode($insumos);
}
