<?php

use \App\modelos\ModeloRoles;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;
use App\modelos\ModeloSanetizarJSON;


function mostrar($parametro)
{
    $modeloRoles = new ModeloRoles();
    $sanetizar = new ModeloSanetizarJSON();

    $ayuda = "btnayudaRoles";
    $vistaActiva = "roles";
    $roles = $sanetizar->sanitizeRecursive($modeloRoles->roles());
    $modulos = require_once './src/vistas/vistaRoles/modal/listaModulos.php';
    require_once './src/vistas/vistaRoles/vistaRoles.php';
}

function mostrarAjax()
{
    $modeloRoles = new ModeloRoles();
    $sanetizar = new ModeloSanetizarJSON();
    echo json_encode($sanetizar->sanitizeRecursive($modeloRoles->roles()));
}

function mostrarPermisos($id_rol, $modulo)
{
    $modeloPermisos = new ModeloPermisos();
    $modeloRoles = new ModeloRoles();

    $modeloRoles->setIdRol($id_rol);
    $modeloPermisos->setModulo($modulo);
    $modeloRoles->mostrarPermisos();
}

function cargarPermisosGuardados($datos)
{
    $modeloRoles = new ModeloRoles();
    $sanetizar = new ModeloSanetizarJSON();
    $modeloRoles->setIdRol($datos["0"]);
    echo json_encode($sanetizar->sanitizeRecursive($modeloRoles->mostrarPermisos()));
}


function returnPermisos()
{
    $modeloRoles = new ModeloRoles();
    $sanetizar = new ModeloSanetizarJSON();
    echo json_encode($sanetizar->sanitizeRecursive($modeloRoles->returnPermisos()));
}

//guardar el rol

function guardarRol()
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
        $modeloRoles = new ModeloRoles();
        $modeloBitacora = new ModeloBitacora();

        $modeloRoles->setNombre($_POST["nombre"]);
        $modeloRoles->setDescripcion($_POST["descripcion"]);
        $modeloRoles->setModulos($_POST["modulos"]);
        $modeloRoles->setPermisos($_POST["permisos"]);

        $insercion = $modeloRoles->guardarRol($idUsuario);

        if (is_array($insercion) && $insercion[0] === "exito") {
            $modeloBitacora->setTabla("Roles");
            $modeloBitacora->setActividad("Ha Insertado un nuevo rol");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
        } else {
            http_response_code(409);
            error_log("Error en guardarRol: " . $insercion);
            echo json_encode(['ok' => false, 'error' => 'Error al guardar el rol.']);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}


//modiicar rol
function modificarRol()
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

        $modeloRoles = new ModeloRoles();
        $modeloBitacora = new ModeloBitacora();

        $modeloRoles->setIdRol($_POST["id_rol"]);
        $modeloRoles->setNombre($_POST["nombre"]);
        $modeloRoles->setNombreRegistrado($_POST["nombreRegiistrado"]);
        $modeloRoles->setDescripcion($_POST["descripcion"]);
        $modeloRoles->setModulos($_POST["modulos"]);
        $modeloRoles->setPermisos($_POST["permisos"]);

        $edicion =  $modeloRoles->editarRol($idUsuario);


        if (is_array($edicion) && $edicion[0] === "exito") {
            $modeloBitacora->setTabla("Roles");
            $modeloBitacora->setActividad("Ha Modificado un rol");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $edicion]);
        } else {
            http_response_code(409);
            error_log("Error en modificarRol: " . $edicion);
            echo json_encode(['ok' => false, 'error' => 'Error al editar el rol.']);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}

//eliminar Rol
function eliminarRol()
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
        $modeloRoles = new ModeloRoles();
        $modeloBitacora = new ModeloBitacora();

        $input = json_decode(file_get_contents("php://input"), true);
        $id = $input["id"] ?? null;

        $modeloRoles->setIdRol($id);
        $eliminacion = $modeloRoles->eliminarRol($idUsuario);

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->setTabla("Roles");
            $modeloBitacora->setActividad("Ha Eliminado un rol");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->insertarBitacora();

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            error_log("Error en eliminarRol: " . $eliminacion);
            echo json_encode(['ok' => false, 'error' => 'Error al eliminar el rol.']);
            exit;
        }
    } catch (InvalidArgumentException $e) {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        exit;
    }
}
