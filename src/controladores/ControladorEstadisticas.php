<?php

use App\modelos\ModeloEstadisticas;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

class ControladorEstadisticas
{
	private $modelo;
	private $bitacora;
	private $permisos;


	function __construct()
	{
		$this->modelo = new ModeloEstadisticas;
		$this->bitacora = new ModeloBitacora; // Guarda la instancia de la bitacora
		$this->permisos = new ModeloPermisos();
	}



	public function estadisticas()
	{
		$ayuda = "btnayudaEstadistica";
		require_once './src/vistas/vistaEstadisticas/vistaEstadisticas.php';
	}

	public function edadGenero()
	{
		$edadGenero = $this->modelo->distribucion_edad_genero();
		echo json_encode($edadGenero);
	}

	public function tasaMorbilidad()
	{
		$tasa_morbilidad = $this->modelo->tasa_morbilidad();
		echo json_encode($tasa_morbilidad);
	}

	public function filtrar_tasaMorbilidad($datos)
	{
		$tasa_morbilidad = $this->modelo->tasa_morbilidad($datos[0], $datos[1]);
		echo json_encode($tasa_morbilidad);
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}

	public function insumos()
	{
		$insumos = $this->modelo->insumos();
		echo json_encode($insumos);
	}
}
