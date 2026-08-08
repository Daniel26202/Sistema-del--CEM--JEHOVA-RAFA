<?php

use App\models\ModeloPerfil;
use App\models\ModeloBitacora;
use App\models\Db;
use App\models\Validator;

function perfil($parametro)
{
	$ayuda = "btnayudaPerfil";
	require_once './src/vistas/vistaPerfil/vistaPerfil.php';
}

function perfilAjax()
{
	$db = new Db();
	$validator = new Validator();
	$modelo = new ModeloPerfil($db,$validator);
	$modelo->setUsuario($_SESSION["usuario"]);
	$modelo->setIdUsuario($_SESSION['id_usuario']);
	echo json_encode($modelo->seleccionarUsuario());
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
		$db = new Db();
		$validator = new Validator();
		$validator->set_session($_SESSION);
		$validator->set_id_usuario($idUsuario);

		$bitacora = new ModeloBitacora($db,$validator);
		$modelo = new ModeloPerfil($db,$validator);

		$modelo->setIdUsuario($_POST["id_usuario"]);
		$modelo->setUsuario($_POST["usuario"]);
		$modelo->setCorreo($_POST["correo"]);

		$modelo->setCedula($_POST["cedula"]);
		$modelo->setNombre($_POST["nombre"]);
		$modelo->setApellido($_POST["apellido"]);
		$modelo->setTelefono($_POST["telefono"]);
		$modelo->setImagen($_FILES['imagen']["name"]);
		$modelo->setImagenTemporal($_FILES['imagen']['tmp_name']);


		$edicion = $modelo->actualizar($modelo->get_all(),['id_usuario'=>$modelo->getIdUsuario()],$validator);

		if (is_array($edicion) && $edicion[0] === "exito") {
			$_SESSION['usuario'] = $_POST['usuario'];
			$_SESSION['nombre'] = $_POST['nombre'];
			$_SESSION['apellido'] = $_POST['apellido'];

			$bitacora->setId_usuario($_POST["id_usuario"]);
			$bitacora->setTabla("Perfil");
			$bitacora->setActividad("Ha modificado un perfil");
			$bitacora->guardar($bitacora->get_all(),$validator);

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

function perfilApk()
{
	if (ob_get_length()) ob_clean();
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Origin: *");

	try {
		$db = new Db();
		$validator = new Validator();
		$modelo = new ModeloPerfil($db,$validator);
		$modelo->setIdUsuario($_SESSION['id_usuario']);
		$perfil = $modelo->seleccionarUsuarioApk();

		if (!$perfil || empty($perfil)) {
			throw new \Exception("No se encontró el perfil.");
		}

		// Nunca enviar datos sensibles al móvil
		unset($perfil['password']);
		unset($perfil['token_session']);

		echo json_encode(['ok' => true, 'data' => $perfil]);
	} catch (\Throwable $e) {
		http_response_code(500);
		echo json_encode(["ok" => false, "error" => $e->getMessage()]);
	}
	exit;
}
