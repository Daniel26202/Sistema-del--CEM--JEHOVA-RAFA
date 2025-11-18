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
		$ayuda ="btnayudaPerfil";
		require_once './src/vistas/vistaPerfil/vistaPerfil.php';
	}

	public function perfilAjax() {
		echo json_encode($this->modelo->seleccionarUsuario($_SESSION["usuario"]));
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

			if (is_array($edicion) && $edicion[0] === "exito") {
				$_SESSION['usuario'] = $_POST['usuario'];
				$_SESSION['nombre'] = $_POST['nombre'];
				$_SESSION['apellido'] = $_POST['apellido'];
				$this->bitacora->insertarBitacora($_POST["id_usuario"], "Perfil", "Ha modificado un perfil");

				echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
			} else {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $edicion]);
				exit;
			}
		}
	}
}
