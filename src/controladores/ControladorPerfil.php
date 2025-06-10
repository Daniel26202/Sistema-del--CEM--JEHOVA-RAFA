<?php

use App\modelos\ModeloPerfil;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloBitacora;

class ControladorPerfil
{

	private $modelo;
	private $permisos;
	private $bitacora;


	function __construct()
	{
		$this->modelo = new ModeloPerfil();
		$this->permisos = new ModeloPermisos();
		$this->bitacora = new ModeloBitacora();
	}

	public function perfil($parametro)
	{
		require_once './src/vistas/vistaPerfil/vistaPerfil.php';
	}

	private function permisos($id_rol, $permiso, $modulo)
	{
		return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
	}

	//guardar perffil
	public function guardar()
	{
		if (isset($_POST)) {
			$edicion = $this->modelo->update($_POST["id_usuario"], $_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["usuario"], $_POST["correo"]);

			if ($edicion) {
				// Guardar la bitacora
				$this->bitacora->insertarBitacora($_POST["id_usuario"], "Perfil", "Ha modificado un perfil");
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil/editar");
			} else {
				header("location: /Sistema-del--CEM--JEHOVA-RAFA/Perfil/perfil/errorSistem");
			}
		}
	}
}
