<?php

use App\modelos\ModeloUsuarios;
use App\modelos\ModeloDoctores;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloInicioSesion;
use App\modelos\ModeloRecuperarContr;
use App\modelos\ModeloSanetizarJSON;
use App\modelos\ModeloRoles;



function usuarios($parametro)
{
    $modeloUsuarios = new ModeloUsuarios();
    $sanetizacion = new ModeloSanetizarJSON();
    $ayuda = "btnayudaUsuario";
    $datosU  = $sanetizacion->sanitizeRecursive($modeloUsuarios->select());
    $vistaActiva = "usuarios";
    require_once './src/vistas/vistaUsuarios/vistaUsuarios.php';
}

function usuariosAjax()
{
    $modeloUsuarios = new ModeloUsuarios();
    $sanetizacion = new ModeloSanetizarJSON();
    echo json_encode($sanetizacion->sanitizeRecursive($modeloUsuarios->select()));
}

function administradores($parametro)
{
    $modeloUsuarios = new ModeloUsuarios();
    $modeloRoles = new ModeloRoles();
    $sanetizacion = new ModeloSanetizarJSON();

    $ayuda = "btnayudaUsuario";
    $datosU  = $sanetizacion->sanitizeRecursive($modeloUsuarios->selectAdmin());
    $vistaActiva = "administradores";
    $datosRoles = $sanetizacion->sanitizeRecursive($modeloRoles->roles());
    require_once './src/vistas/vistaUsuarios/vistaUsuarios.php';
}

function administradoresAjax()
{
    $modeloUsuarios = new ModeloUsuarios();
    $sanetizacion = new ModeloSanetizarJSON();

    echo json_encode($sanetizacion->sanitizeRecursive($modeloUsuarios->selectAdmin()));
}

function listaNegra()
{
    require_once './src/vistas/vistaUsuarios/vistaListaNegra.php';
}

function listaNegraAjax()
{
    if (empty($_GET)) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => "Error al realizar la petición :("]);
        exit;
    }

    $draw = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;
    $inicio = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limite = isset($_GET['length']) ? (int)$_GET['length'] : 10;
    $buscar = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';


    $columnasMapeadas = ['cedula', 'nombre', 'apellido', 'telefono', 'correo', 'user'];

    $colIndex = isset($_GET['order'][0]['column']) ? (int)$_GET['order'][0]['column'] : 0;

    $ordenDir = isset($_GET['order'][0]['dir']) && in_array(strtoupper($_GET['order'][0]['dir']), ['ASC', 'DESC']) ? strtoupper($_GET['order'][0]['dir']) : 'DESC';

    $ordenColumna = isset($columnasMapeadas[$colIndex]) ? $columnasMapeadas[$colIndex] : 'id_usuario';

    if (!preg_match('/^[a-zA-Z_]+$/', $ordenColumna)) {
        $ordenColumna = 'id_usuario';
    }

    $modeloUsuarios = new ModeloUsuarios();
    $usuarios = $modeloUsuarios->selectUserInBlackList($inicio, $limite, $buscar, $ordenColumna, $ordenDir);

    $totalRegistros = $modeloUsuarios->contarTotalUsuariosBlackList();
    $totalFiltrados = !empty($buscar) ? $modeloUsuarios->contarTotalUsuariosBlackList($buscar) : $totalRegistros;

    //datos que se le envia al js (esto es estandar de datatable)
    $response = [
        "draw" => $draw,
        "recordsTotal" => $totalRegistros,
        "recordsFiltered" => $totalFiltrados,
        "data" => is_array($usuarios) ? $usuarios : []
    ];

    echo json_encode($response);
    exit;
}

function listaUserAjax()
{
    $modeloUsuarios = new ModeloUsuarios();
    echo json_encode($modeloUsuarios->selectAllUser());
}

// editar usuario
function addUserBlackList()
{

    if (empty($_POST)) {
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

        $modeloUsuarios = new ModeloUsuarios();
        $modeloBitacora = new ModeloBitacora();

        $modeloUsuarios->setIdUsuario($_POST["id_personal"]);
        $add = $modeloUsuarios->addUserBlackList($idUsuario);

        if (is_array($add) && $add[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha agregado a la lista negra a un usuario");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $add]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $add]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

// quitar el usuario de la blackList
function removeBlackList()
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

        $modeloUsuarios = new ModeloUsuarios();
        $modeloBitacora = new ModeloBitacora();

        $input = json_decode(file_get_contents("php://input"), true);
        $id = $input["id"] ?? null;

        $modeloUsuarios->setIdUsuario($id);
        $remove = $modeloUsuarios->removeUserBlackList($idUsuario);

        if (is_array($remove) && $remove[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha quitado un  usuario de la lista negra");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            error_log("Error en removeBlackLIst: " . $remove);
            echo json_encode(['ok' => false, 'error' => "Error en al remover el usuario de la lista negra."]);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
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

        $headers = getallheaders();
        $csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;


        if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }

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
            error_log("Error en editarUsuario: " . $edicion); // Registro interno
            echo json_encode(['ok' => false, 'error' => 'Error al editar el usuario.']);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

// eliminación lógica de usuario
function borrarUsuario()
{
    try {

        $headers = getallheaders();
        $csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;


        if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }

        $idUsuario = $_SESSION['id_usuario'];

        $modeloUsuarios = new ModeloUsuarios();
        $modeloBitacora = new ModeloBitacora();

        $input = json_decode(file_get_contents("php://input"), true);
        $id = $input["id"] ?? null;

        $modeloUsuarios->setIdUsuario($id);

        $eliminacion = $modeloUsuarios->eliminarUsuario($idUsuario);

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha eliminado un  usuario");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            error_log("Error en borrarUsuario: " . $eliminacion);
            echo json_encode(['ok' => false, 'error' => 'Error al eliminar el usuario.']);
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
        $headers = getallheaders();
        $csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;


        if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }

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

        $insercion = $modeloDoctores->registrarAdmin();

        if (is_array($insercion) && $insercion[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha insertado un administrador");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();
            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            error_log("Error en registrarAdmin: " . $insercion);
            echo json_encode(['ok' => false, 'error' => 'Error al registrar el administrador.']);
            exit;
        }
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
        $headers = getallheaders();
        $csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;


        if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }
        $idUsuario = $_SESSION['id_usuario'];

        $modeloUsuarios = new ModeloUsuarios();
        $modeloBitacora = new ModeloBitacora();

        $modeloUsuarios->setIdUsuario($_POST["id_usuario"]);
        $modeloUsuarios->setUsuario($_POST["usuario"]);
        $modeloUsuarios->setImagen($_FILES['imagenUsuario']["name"]);
        $modeloUsuarios->setImagenTemporal($_FILES['imagenUsuario']['tmp_name']);

        $id_usuario = $modeloUsuarios->editarUsuario($idUsuario);

        if (is_array($id_usuario) && $id_usuario[0] === "exito") {
            $modeloBitacora->setTabla("usuario");
            $modeloBitacora->setActividad("Ha modificado un administrador");
            $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
            $modeloBitacora->insertarBitacora();

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            error_log("Error en editarAdministrador: " . $id_usuario);
            echo json_encode(['ok' => false, 'error' => 'Error al editar el administrador.']);
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
        $headers = getallheaders();
        $csrf_token = $headers['X-CSRF-Token'] ?? $_POST['csrf_token'] ?? null;


        if (empty($_SESSION['csrf_token']) || empty($csrf_token) || !hash_equals($_SESSION['csrf_token'], $csrf_token)) {
            http_response_code(403);
            echo json_encode(['ok' => false, 'error' => 'Token CSRF inválido']);
            exit;
        }

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
            error_log("Error en verificarPassw: " . $verificar);
            echo json_encode(['ok' => false, 'error' => 'Error al verificar la contraseña.']);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
