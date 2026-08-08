<?php

use App\models\Db;
use App\models\ModeloEstadisticas;
use App\models\ModeloBitacora;
use App\models\ModeloPermisos;
use App\models\Validator;

function estadisticas()
{
	$ayuda = "btnayudaEstadistica";
	$vistaActiva = "estadisticas";
	require_once './src/vistas/vistaEstadisticas/vistaEstadisticas.php';
}

function edadGenero()
{
	$db = new Db();
	$validator = new Validator();
	$modeloEstadisticas = new ModeloEstadisticas($db,$validator);
	$edadGenero = $modeloEstadisticas->distribucion_edad_genero();
	echo json_encode($edadGenero);
}

function tasaMorbilidad()
{
	$db = new Db();
	$validator = new Validator();
	$modeloEstadisticas = new ModeloEstadisticas($db, $validator);
	// Sin filtro de fechas
	// $tasa_morbilidad = $modeloEstadisticas->obtenerTasaMorbilidad();
	echo json_encode([]);
}

function filtrar_tasaMorbilidad($datos)
{
	$db = new Db();
	$validator = new Validator();
	$modeloEstadisticas = new ModeloEstadisticas($db, $validator);
	try {
		$fechaInicio = $datos[0] ?? '';
		$fechaFinal = $datos[1] ?? '';
		// $tasa_morbilidad = $modeloEstadisticas->obtenerTasaMorbilidad($fechaInicio, $fechaFinal);
		echo json_encode([]);
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}

function insumos()
{
	$db = new Db();
	$validator = new Validator();
	$modeloEstadisticas = new ModeloEstadisticas($db,$validator);
	$insumos = $modeloEstadisticas->insumos();
	echo json_encode($insumos);
}
