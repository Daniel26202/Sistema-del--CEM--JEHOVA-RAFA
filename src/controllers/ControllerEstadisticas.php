<?php

use App\modelos\ModeloEstadisticas;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloSanetizarJSON;





function estadisticas()
{
	$ayuda = "btnayudaEstadistica";
	$vistaActiva = "estadisticas";
	require_once './src/vistas/vistaEstadisticas/vistaEstadisticas.php';
}

function edadGenero()
{
	$modeloEstadisticas = new ModeloEstadisticas();
	$sanetizar = new ModeloSanetizarJSON();
	$edadGenero = $sanetizar->sanitizeRecursive($modeloEstadisticas->distribucion_edad_genero());
	echo json_encode($edadGenero);
}

function tasaMorbilidad()
{
	$modeloEstadisticas = new ModeloEstadisticas();
	$sanetizar = new ModeloSanetizarJSON();
	// Sin filtro de fechas
	$tasa_morbilidad = $sanetizar->sanitizeRecursive($modeloEstadisticas->obtenerTasaMorbilidad());
	echo json_encode($tasa_morbilidad);
}

function filtrar_tasaMorbilidad($datos)
{
	$modeloEstadisticas = new ModeloEstadisticas();
	$sanetizar = new ModeloSanetizarJSON();
	try {
		$fechaInicio = $datos[0] ?? '';
		$fechaFinal = $datos[1] ?? '';
		$tasa_morbilidad = $sanetizar->sanitizeRecursive($modeloEstadisticas->obtenerTasaMorbilidad($fechaInicio, $fechaFinal));
		echo json_encode($tasa_morbilidad);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function insumos()
{
	$modeloEstadisticas = new ModeloEstadisticas();
	$sanetizar = new ModeloSanetizarJSON();

	$insumos = $sanetizar->sanitizeRecursive($modeloEstadisticas->insumos());
	echo json_encode($insumos);
}
