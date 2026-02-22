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


//guardar el rol

function guardarRol()
{
    $modeloPermisos = new ModeloPermisos();
    $modeloRoles = new ModeloRoles();
    $modeloBitacora = new ModeloBitacora();

    $modeloRoles->setNombre($_POST["nombre"]);
    $modeloRoles->setDescripcion($_POST["descripcion"]);
    // $modeloPermisos->setModulo($_POST["modulos"]);
    // $modeloPermisos->setPermiso($_POST["permisos"]);

    echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $_POST]);


    // $insercion = $modeloRoles->insertar();

    // if (is_array($insercion) && $insercion[0] === "exito") {
    //     $modeloBitacora->setTabla("Roles");
    //     $modeloBitacora->setActividad("Ha Insertado un nuevo rol");
    //     $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
    //     $modeloBitacora->insertarBitacora();

    //     echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
    // } else {
    //     http_response_code(409);
    //     echo json_encode(['ok' => false, 'error' => $insercion]);
    //     exit;
    // }
}


//modiicar rol
function modificarRol()
{
    $modeloPermisos = new ModeloPermisos();
    $modeloRoles = new ModeloRoles();
    $modeloBitacora = new ModeloBitacora();

    $modeloRoles->setIdRol($_POST["id_rol"]);
    $modeloRoles->setNombre($_POST["nombre"]);
    $modeloRoles->setDescripcion($_POST["descripcion"]);
    $modeloRoles->setNombreRegistrado($_POST['nombreRegistrado']);
    $modeloPermisos->setModulo($_POST["modulos"]);
    $modeloPermisos->setPermiso($_POST["permisos"]);

    $edicion =  $modeloRoles->editar();


    if (is_array($edicion) && $edicion[0] === "exito") {
        $modeloBitacora->setTabla("Roles");
        $modeloBitacora->setActividad("Ha Modificado un rol");
        $modeloBitacora->setId_usuario($_POST['id_usuario_bitacora']);
        $modeloBitacora->insertarBitacora();

        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $edicion]);
        exit;
    }
}

//eliminar Rol
function eliminarRol($datos)
{
    $modeloRoles = new ModeloRoles();
    $modeloBitacora = new ModeloBitacora();

    $id_rol = $datos[0];
    $id_usuario = $datos[1];
    $modeloRoles->setIdRol($id_rol);
    $eliminacion = $modeloRoles->eliminar();

    if (is_array($eliminacion) && $eliminacion[0] === "exito") {
        $modeloBitacora->setTabla("Roles");
        $modeloBitacora->setActividad("Ha Eliminado un rol");
        $modeloBitacora->setId_usuario($id_usuario);
        $modeloBitacora->insertarBitacora();

        echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
    } else {
        http_response_code(409);
        echo json_encode(['ok' => false, 'error' => $eliminacion]);
        exit;
    }
}

    //  function permisos($id_rol, $permiso, $modulo)
    // {
    //     return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    // }
