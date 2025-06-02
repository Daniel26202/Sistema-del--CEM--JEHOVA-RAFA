<?php

use App\modelos\ModeloPatologia;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;


class ControladorPatologias
{
	private $patologia;
	private $bitacora;
	private $permisos;

	function __construct()
	{
		$this->patologia = new ModeloPatologia();
		$this->bitacora = new ModeloBitacora();
		$this->permisos = new ModeloPermisos();
	}

	public function patologias($parametro)
	{
		$ayuda = "btnayudaPatologia";
		$datosPatologias = $this->patologia->mostrarPatologias();
		require_once './src/vistas/vistaPatologia/patologia.php';
	}
	public function papeleraPatologias($parametro)
	{
		$ayuda = "btnayudaPatologia";
		$datosPatologias = $this->patologia->mostrarPatologiasEliminadas();
		require_once './src/vistas/vistaPatologia/patologiapapelera.php';
	}

	//insertar patologia 
	public function registrarPatologia()
	{
		$resultaPatologia = $this->patologia->nombrePatologia($_POST['nombre']);


		if ($resultaPatologia === "existeC") {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias/error");
		} else {
			$insercion = $this->patologia->insertarPatologia($_POST["nombre"]);
			if ($insercion) {
				// // Guardo la bitacora
				$this->bitacora->insertarBitacora($_POST['id_usuario'], "patologia", "Ha Insertado una patologia");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias/registro");
			} else {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias/errorSistem");
			}
		}
	}

	//eliminar patologia
	public function eliminarPatologia($datos)
	{

		$id_patologia = $datos[0];
		$id_usuario = $datos[1];

		$eliminar = $this->patologia->eliminarPatologia($id_patologia);
		if ($eliminar) {
			// Guardo la bitacora
			$this->bitacora->insertarBitacora($id_usuario, "patologia", "Ha eliminado una patologia");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias/eliminar");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias/errorSintem");
		}
	}


	public function restablecerPatologia($datos)
	{
		$id_patologia = $datos[0];
		$id_usuario = $datos[1];

		$restablecer = $this->patologia->restablecer($id_patologia);
		if ($restablecer) {
			// Guardo la bitacora
			$this->bitacora->insertarBitacora($id_usuario, "patologia", "Ha restablecido una patologia");
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias/restablecido");
		} else {
			header("location: /Sistema-del--CEM--JEHOVA-RAFA/Patologias/patologias/errorSistem");
		}
	}



	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}
}
