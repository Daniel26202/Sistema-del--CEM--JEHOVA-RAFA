<?php

use \App\models\ModeloRoles;
use App\models\ModeloBitacora;
use App\models\ModeloPermisos;
use App\models\Db;
use App\models\Validator;



function mostrar($parametro)
{
    $db = new Db();
    $validator = new Validator();
    $modeloRoles = new ModeloRoles($db,$validator);

    $ayuda = "btnayudaRoles";
    $vistaActiva = "roles";
    $roles = $modeloRoles->roles();
    $modulos = require_once './src/vistas/vistaRoles/modal/listaModulos.php';
    require_once './src/vistas/vistaRoles/vistaRoles.php';
}

function mostrarAjax()
{
    $db = new Db();
    $validator = new Validator();
    $modeloRoles = new ModeloRoles($db,$validator);

    echo json_encode($modeloRoles->roles());
}

function mostrarPermisos($id_rol, $modulo)
{
    $db = new Db();
    $validator = new Validator();
    $modeloPermisos = new ModeloPermisos($db);
    $modeloRoles = new ModeloRoles($db,$validator);

    $modeloRoles->setIdRol($id_rol);
    $modeloPermisos->setModulo($modulo);
    // $modeloRoles->mostrarPermisos();
}

function cargarPermisosGuardados($datos)
{
    $db = new Db();
    $validator = new Validator();

    $modeloRoles = new ModeloRoles($db,$validator);
    $modeloRoles->setIdRol($datos["0"]);
    // echo json_encode($modeloRoles->mostrarPermisos());
}


function returnPermisos()
{
    $db = new Db();
    $validator = new Validator();
    $modeloRoles = new ModeloRoles($db,$validator);
    echo json_encode($modeloRoles->returnPermisos());
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
        $idUsuario = $_SESSION['id_usuario'];
        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);
        $modeloRoles = new ModeloRoles($db,$validator);
        $modeloBitacora = new ModeloBitacora($db,$validator);

        $modeloRoles->setNombre($_POST["nombre"]);
        $modeloRoles->setDescripcion($_POST["descripcion"]);
        $modeloRoles->setModulos($_POST["modulos"]);
        $modeloRoles->setPermisos($_POST["permisos"]);

        $insercion = $modeloRoles->guardar($modeloRoles->get_all(),$validator);

        if (is_array($insercion)) {
            $modeloBitacora->setTabla("Roles");
            $modeloBitacora->setActividad("Ha Insertado un nuevo rol");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->guardar($modeloBitacora->get_all(),$validator);

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
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
        $idUsuario = $_SESSION['id_usuario'];
        $db = new Db();
        $validator = new Validator();
        $validator->set_session($_SESSION);
        $validator->set_id_usuario($idUsuario);
        $modeloRoles = new ModeloRoles($db,$validator);
        $modeloBitacora = new ModeloBitacora($db,$validator);

        $modeloRoles->setIdRol($_POST["id_rol"]);
        $modeloRoles->setNombre($_POST["nombre"]);
        $modeloRoles->setDescripcion($_POST["descripcion"]);
        $modeloRoles->setModulos($_POST["modulos"]);
        $modeloRoles->setPermisos($_POST["permisos"]);

        $edicion =  $modeloRoles->actualizar($modeloRoles->get_all(),['id_rol'=>$modeloRoles->getIdRol()],$validator);


        if (is_array($edicion)) {
            $modeloBitacora->setTabla("Roles");
            $modeloBitacora->setActividad("Ha Modificado un rol");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->guardar($modeloBitacora->get_all(),$validator);

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

//eliminar Rol
function eliminarRol($datos)
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
        $modeloRoles = new ModeloRoles($db,$validator);
        $modeloBitacora = new ModeloBitacora($db,$validator);

        $id_rol = $datos[0];
        $modeloRoles->setIdRol($id_rol);
        $eliminacion = $modeloRoles->actualizar(['estado'=>'DES'],['id_rol'=>$modeloRoles->getIdRol()],$validator);

        if (is_array($eliminacion)) {
            $modeloBitacora->setTabla("Roles");
            $modeloBitacora->setActividad("Ha Eliminado un rol");
            $modeloBitacora->setId_usuario($idUsuario);
            $modeloBitacora->guardar($modeloBitacora->get_all(),$validator);

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





    //  function permisos($id_rol, $permiso, $modulo)
    // {
    //     return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    // }
