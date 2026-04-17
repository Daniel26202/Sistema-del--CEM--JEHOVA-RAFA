<?php

use App\modelos\ModeloPerfil;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloUsuarios;
use App\config\RateLimiter;

function perfil($parametro)
{
	$ayuda = "btnayudaPerfil";
	require_once './src/vistas/vistaPerfil/vistaPerfil.php';
}

function perfilAjax()
{
	$modelo = new ModeloPerfil();
	$modelo->setUsuario($_SESSION["usuario"]);
	$modelo->setIdUsuario($_SESSION['id_usuario']);
	echo json_encode($modelo->seleccionarUsuario());
}

function permisos($id_rol, $permiso, $modulo)
{
	$permisos = new ModeloPermisos();
	return $permisos->gestionarPermisos($id_rol, $permiso, $modulo);
}

//guardar perfil
function guardar()
{
	if (empty($_GET)) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
		exit;
	}

	try {
		$idUsuario = $_SESSION['id_usuario'];
		// RATE LIMIT: 5 peticiones cada 1 segundos
		$limiter = new RateLimiter();
		$limiter->verificar('guardar_perfil_' . $idUsuario, 5, 1);

		$bitacora = new ModeloBitacora();
		$modelo = new ModeloPerfil();

		$modelo->setIdUsuario($_POST["id_usuario"]);
		$modelo->setUsuario($_POST["usuario"]);
		$modelo->setCorreo($_POST["correo"]);

		$modelo->setCedula($_POST["cedula"]);
		$modelo->setNombre($_POST["nombre"]);
		$modelo->setApellido($_POST["apellido"]);
		$modelo->setTelefono($_POST["telefono"]);
		$modelo->setImagen($_FILES['imagen']["name"]);
		$modelo->setImagenTemporal($_FILES['imagen']['tmp_name']);


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
	} catch (InvalidArgumentException $e) {
		http_response_code(409);
		echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
		exit;
	}
}
