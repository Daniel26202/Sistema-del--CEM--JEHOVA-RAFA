<?php

use App\modelos\ModeloUsuarios;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloInicioSesion;
use App\modelos\ModeloRecuperarContr;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloRoles;



function usuarios($parametro)
{
    $modeloUsuarios = new ModeloUsuarios();
    $ayuda = "btnayudaUsuario";
    $datosU  = $modeloUsuarios->select();
    $vistaActiva = "usuarios";
    require_once './src/vistas/vistaUsuarios/vistaUsuarios.php';
}

function usuariosAjax()
{
    $modeloUsuarios = new ModeloUsuarios();

    echo json_encode($modeloUsuarios->select());
}

function administradores($parametro)
{
    $modeloUsuarios = new ModeloUsuarios();
    $modeloRoles = new ModeloRoles();

    $ayuda = "btnayudaUsuario";
    $datosU  = $modeloUsuarios->selectAdmin();
    $vistaActiva = "administradores";
    $datosRoles = $modeloRoles->roles();
    require_once './src/vistas/vistaUsuarios/vistaUsuarios.php';
}

function administradoresAjax()
{
    $modeloUsuarios = new ModeloUsuarios();
    echo json_encode($modeloUsuarios->selectAdmin());
}

// editar usuario
function editarUsuario()
{

    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {

        $idUsuario = $_SESSION['id_usuario'];

        $modeloUsuarios = new ModeloUsuarios();
        $modeloBitacora = new ModeloBitacora();

        $modeloUsuarios->setIdUsuario($_POST["id_usuario"]);
        $modeloUsuarios->setUsuario($_POST["usuario"]);
        $modeloUsuarios->setUsuarioRegistrado($_POST['usuarioRegistrado']);
        $modeloUsuarios->setImagen($_FILES['imagen']["name"]);
        $modeloUsuarios->setImagenTemporal($_FILES['imagen']['tmp_name']);

        $edicion = $modeloUsuarios->editarUsuario($idUsuario);


        if (is_array($edicion) && $edicion[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha modificado un  usuario");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $edicion]);
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

// eliminación lógica de usuario
function borrarUsuario($datos)
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {

        $idUsuario = $_SESSION['id_usuario'];

        $modeloUsuarios = new ModeloUsuarios();
        $modeloBitacora = new ModeloBitacora();

        $id_usuario = $datos[0];
        $modeloUsuarios->setIdUsuario($id_usuario);

        $eliminacion = $modeloUsuarios->eliminarUsuario($idUsuario);

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha eliminado un  usuario");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $eliminacion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
function registrarAdmin()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
        $idUsuario = $_SESSION['id_usuario'];
        $modeloUsuarios = new ModeloUsuarios();
        $modeloDoctores = new ModeloDoctores();
        $modeloBitacora = new ModeloBitacora();

        // Generamos la contraseña encriptada de la contraseña ingresada
        $passwordEncrip = password_hash($_POST["password"], PASSWORD_BCRYPT);

        $modeloUsuarios->setUsuario($_POST["usuario"]);
        $modeloUsuarios->setPassword($passwordEncrip);
        $modeloUsuarios->setCorreo($_POST["correo"]);
        $modeloUsuarios->setIdRol($_POST["id_rol"]);
        $modeloUsuarios->setImagen($_FILES['imagen']);

        $id_usuario = $modeloUsuarios->agregarUsuario($idUsuario);

        $modeloDoctores->setNacionalidad($_POST["nacionalidad"]);
        $modeloDoctores->setCedula($_POST["cedula"]);
        $modeloDoctores->setNombre($_POST["nombre"]);
        $modeloDoctores->setApellido($_POST["apellido"]);
        $modeloDoctores->setTelefono($_POST["telefono"]);
        $modeloDoctores->setIdUsuario($id_usuario);

        $insercion = $modeloDoctores->RegistrarAdmin();

        if (is_array($insercion) && $insercion[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha insertado un administrador");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
            exit;
        }
        // echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion]);
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}


function editarAdministrador()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('editar_usuario_admin_' . $idUsuario, 5, 1);

        $modeloUsuarios = new ModeloUsuarios();
        $modeloBitacora = new ModeloBitacora();

        $modeloUsuarios->setIdUsuario($_POST["id_usuario"]);
        $modeloUsuarios->setUsuario($_POST["usuario"]);
        $modeloUsuarios->setImagen($_FILES['imagenUsuario']["name"]);
        $modeloUsuarios->setImagenTemporal($_FILES['imagenUsuario']['tmp_name']);

        $id_usuario = $modeloUsuarios->updateUsuario();

        // Guardar la bitacora
        $modeloBitacora->setTabla("usuario");
        $modeloBitacora->setActividad("Ha modificado un administrador");
        $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
        $modeloBitacora->insertarBitacora();


        if (is_array($id_usuario) && $id_usuario[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha modificado un administrador");
            $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
            $modeloBitacora->insertarBitacora();

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $id_usuario]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}


function eliminarAdministrador()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
        $idUsuario = $_SESSION['id_usuario'];
        // RATE LIMIT: 5 peticiones cada 1 segundos
        $limiter = new RateLimiter();
        $limiter->verificar('eliminar_usuario_admin_' . $idUsuario, 5, 1);

        $modeloUsuarios = new ModeloUsuarios();
        $modeloBitacora = new ModeloBitacora();

        $modeloUsuarios->setIdUsuario($_POST["id_usuario"]);

        $eliminacion = $modeloUsuarios->eliminacionLogica();

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha eliminado un administrador");
            $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $eliminacion]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

function verificarPassw()
{
    if (empty($_POST)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error  al realizar la peticion :("]);
        exit;
    }

    try {
        $modeloInicioSesion = new ModeloInicioSesion();
        $modeloRecuperarContr = new ModeloRecuperarContr();
        $modeloUsuarios = new ModeloUsuarios();

        $modeloInicioSesion->setUsuario($_POST["usuario"]);
        $modeloInicioSesion->setPassword($_POST["password"]);

        $datosU = $modeloInicioSesion->validarIniciarSesion();
        $verificar = ($datosU) ? "existe" : false;


        if ($verificar == "existe") {
            // Generamos la contraseña encriptada de la contraseña ingresada
            $passwordEncrip = password_hash($_POST["passwordNew"], PASSWORD_BCRYPT);

            $modeloRecuperarContr->setIdUsuario($datosU["id_usuario"]);
            $modeloRecuperarContr->setPassword($passwordEncrip);

            $modeloRecuperarContr->updatePassword();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $datosU]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => 'error']);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

// function permisos($id_rol, $permiso, $modulo)
// {
//     return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
// }
