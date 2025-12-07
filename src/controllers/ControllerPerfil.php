<?php

use App\modelos\ModeloPerfil;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloBitacora;



function perfil($parametro)
{
	$ayuda = "btnayudaPerfil";
	// require_once './src/vistas/vistaPerfil/vistaPerfil.php';
	echo "perfil";
}

function perfilAjax()
{
	$modelo = new ModeloPerfil();
	echo json_encode($modelo->seleccionarUsuario($_SESSION["usuario"]));
}

function permisos($id_rol, $permiso, $modulo)
{
	$permisos = new ModeloPermisos();
	return $permisos->gestionarPermisos($id_rol, $permiso, $modulo);
}

//guardar perffil
function guardar()
{
	if (isset($_POST)) {
		$bitacora = new ModeloBitacora();
		$modelo = new ModeloPerfil();

		$edicion = $modelo->update($_POST["id_usuario"], $_POST["cedula"], $_POST["nombre"], $_POST["apellido"], $_POST["telefono"], $_POST["usuario"], $_POST["correo"]);

		if (is_array($edicion) && $edicion[0] === "exito") {
			$_SESSION['usuario'] = $_POST['usuario'];
			$_SESSION['nombre'] = $_POST['nombre'];
			$_SESSION['apellido'] = $_POST['apellido'];
			$bitacora->insertarBitacora($_POST["id_usuario"], "Perfil", "Ha modificado un perfil");

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $edicion]);
			exit;
		}
	}
}
