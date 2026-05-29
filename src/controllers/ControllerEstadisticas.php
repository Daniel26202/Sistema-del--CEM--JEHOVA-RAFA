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
	// Sin filtro de fechas
	$tasa_morbilidad = $modeloEstadisticas->obtenerTasaMorbilidad();
	echo json_encode($tasa_morbilidad);
}

function filtrar_tasaMorbilidad($datos)
{
	$modeloEstadisticas = new ModeloEstadisticas();
	try {
		$fechaInicio = $datos[0] ?? '';
		$fechaFinal = $datos[1] ?? '';
		$tasa_morbilidad = $modeloEstadisticas->obtenerTasaMorbilidad($fechaInicio, $fechaFinal);
		echo json_encode($tasa_morbilidad);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
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
