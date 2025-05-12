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


        
    public function estadisticas(){
		require_once './src/vistas/vistaEstadisticas/vistaEstadisticas.php';
    }

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}