<?php
use App\config\Cifrado;
use App\modelos\ModeloPerfil;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloUsuarios;
// use App\config\RateLimiter;

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
		$headers = getallheaders();
		$csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;

		if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
			http_response_code(403);
			echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
			exit;
		}

		$idUsuario = $_SESSION['id_usuario'];


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
			if (is_string($edicion)) {
				http_response_code(409);
				echo json_encode(['ok' => false, 'error' => $edicion]);
			} else {
				http_response_code(409);
				error_log("Error en guardar: " . print_r($edicion, true));
				echo json_encode(['ok' => false, 'error' => 'Error al modificar el perfil.']);
				exit;
			}
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
		$modelo = new ModeloPerfil();
		$modelo->setIdUsuario($_SESSION['id_usuario']);
		$perfil = $modelo->seleccionarUsuarioApk();

		if (!$perfil || empty($perfil)) {
			throw new \Exception("No se encontró el perfil.");
		}

		// Nunca enviar datos sensibles al móvil
		unset($perfil['password']);
		unset($perfil['token_session']);

		echo json_encode(Cifrado::cifrarRespuesta(['ok' => true, 'data' => $perfil]));
	} catch (\Throwable $e) {
		http_response_code(500);
		echo json_encode(Cifrado::cifrarRespuesta(["ok" => false, "error" => $e->getMessage()]));
	}
	exit;
}
