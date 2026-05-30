<?php

use \App\modelos\ModeloRoles;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

function mostrar($parametro)
{
    $modeloRoles = new ModeloRoles();

    $ayuda = "btnayudaRoles";
    $vistaActiva = "roles";
    $roles = $modeloRoles->roles();
    $modulos = require_once './src/vistas/vistaRoles/modal/listaModulos.php';
    require_once './src/vistas/vistaRoles/vistaRoles.php';
}

function mostrarAjax()
{
    $modeloRoles = new ModeloRoles();

    echo json_encode($modeloRoles->roles());
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
    $modeloRoles->setIdRol($datos["0"]);
    echo json_encode($modeloRoles->mostrarPermisos());
}


function returnPermisos()
{
    $modeloRoles = new ModeloRoles();
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
        $modeloRoles = new ModeloRoles();
        $modeloBitacora = new ModeloBitacora();

        $id_rol = $datos[0];
        $modeloRoles->setIdRol($id_rol);
        $eliminacion = $modeloRoles->eliminarRol($idUsuario);

        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $modeloBitacora->setTabla("Roles");
            $modeloBitacora->setActividad("Ha Eliminado un rol");
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





    //  function permisos($id_rol, $permiso, $modulo)
    // {
    //     return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    // }
