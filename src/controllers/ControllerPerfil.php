<?php

use App\modelos\ModeloPerfil;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloUsuarios;

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

//guardar perfil
function guardar()
{
	if (isset($_POST)) {
		$bitacora = new ModeloBitacora();
		$modelo = new ModeloPerfil();
		$modeloUsuario = new ModeloUsuarios();
		$modeloDoctor = new ModeloDoctores();

		$modeloUsuario->setIdUsuario($_POST["id_usuario"]);
		$modeloUsuario->setUsuario($_POST["usuario"]);
		$modeloUsuario->setCorreo($_POST["correo"]);

		$modeloDoctor->setCedula($_POST["cedula"]);
		$modeloDoctor->setNombre($_POST["nombre"]);
		$modeloDoctor->setApellido($_POST["apellido"]);
		$modeloDoctor->setTelefono($_POST["telefono"]);


		$edicion = $modelo->update_perfil();

		if (is_array($edicion) && $edicion[0] === "exito") {
			$_SESSION['usuario'] = $_POST['usuario'];
			$_SESSION['nombre'] = $_POST['nombre'];
			$_SESSION['apellido'] = $_POST['apellido'];

			$bitacora->setId_usuario($_POST["id_usuario"]);
			$bitacora->setTabla("Perfil");
			$bitacora->setActividad("Ha modificado un perfil");
			$bitacora->insertarBitacora();

			echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
		} else {
			http_response_code(409);
			echo json_encode(['ok' => false, 'error' => $edicion]);
			exit;
		}
	}
}
