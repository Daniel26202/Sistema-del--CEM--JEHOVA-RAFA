<?php

use App\modelos\ModeloEstadisticas;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;





function estadisticas()
{
	$ayuda = "btnayudaEstadistica";
	require_once './src/vistas/vistaEstadisticas/vistaEstadisticas.php';
	
}

	//  function edadGenero()
	// {
	// 	$edadGenero = $this->modelo->distribucion_edad_genero();
	// 	echo json_encode($edadGenero);
	// }

	//  function tasaMorbilidad()
	// {
	// 	$tasa_morbilidad = $this->modelo->tasa_morbilidad();
	// 	echo json_encode($tasa_morbilidad);
	// }

	//  function filtrar_tasaMorbilidad($datos)
	// {
	// 	$tasa_morbilidad = $this->modelo->tasa_morbilidad($datos[0], $datos[1]);
	// 	echo json_encode($tasa_morbilidad);
	// }

	// private function permisos($id_rol, $permiso, $modulo)
	// {
	// 	return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	// }

	//  function insumos()
	// {
	// 	$insumos = $this->modelo->insumos();
	// 	echo json_encode($insumos);
	// }
