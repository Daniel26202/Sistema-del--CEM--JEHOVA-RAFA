<?php

use \App\modelos\ModeloRoles;
use App\modelos\ModeloBitacora;
use App\modelos\ModeloPermisos;

class ControladorRoles
{

    private $modelo;
    private $bitacora;
    private $permisos;

    function __construct()
    {
        $this->modelo = new ModeloRoles;
        $this->bitacora = new ModeloBitacora; //bitacora
        $this->permisos = new ModeloPermisos;
    }


    public function mostrar($parametro)
    {
        $ayuda = "btnayudaRoles";
        $vistaActiva = "roles";
        $roles = $this->modelo->roles();
        $modulos = require_once './src/vistas/vistaRoles/modal/listaModulos.php';
        require_once './src/vistas/vistaRoles/vistaRoles.php';
    }

    public function mostrarAjax()
    {
        echo json_encode($this->modelo->roles());
    }

    public function mostrarPermisos($id_rol, $modulo)
    {
        $this->modelo->mostrarPermisos($id_rol, $modulo);
    }


    //guardar el rol

    public function guardarRol()
    {

        $insercion = $this->modelo->insertar($_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"]);

        if (is_array($insercion) && $insercion[0] === "exito") {
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Insertado un nuevo rol");

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito', 'data' => $insercion[1]]);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $insercion]);
            exit;
        }
    }


    //modiicar rol
    public function modificarRol()
    {

        $edicion =  $this->modelo->editar($_POST["id_rol"], $_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"], $_POST['nombreRegistrado']);


        if (is_array($edicion) && $edicion[0] === "exito") {
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Modiicado un rol");

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $edicion]);
            exit;
        }
    }

    //eliminar Rol
    public function eliminarRol($datos)
    {
        $id_rol = $datos[0];
        $id_usuario = $datos[1];
        $eliminacion = $this->modelo->eliminar($id_rol);


        if (is_array($eliminacion) && $eliminacion[0] === "exito") {
            $this->bitacora->insertarBitacora($id_usuario, "Roles", "Ha Eliminado un rol");

            echo json_encode(['ok' => true, 'message' => 'La operación se realizó con éxito']);
        } else {
            http_response_code(409);
            echo json_encode(['ok' => false, 'error' => $eliminacion]);
            exit;
        }
    }


    private function permisos($id_rol, $permiso, $modulo)
    {
        return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    }
}
