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

    public function mostrarPermisos($id_rol, $modulo)
    {
        $this->modelo->mostrarPermisos($id_rol, $modulo);
    }


    //guardar el rol

    public function guardarRol()
    {
        //instacion el metodo de la validacion de el rol
        $validar = $this->modelo->validarRol($_POST["nombre"]);
        if ($validar) {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/error");
        } else {
            $insercion = $this->modelo->insertar($_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"]);

            if ($insercion) {
                // guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Insertado un nuevo rol");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/registro");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/errorSistem");
            }
        }
    }


    //modiicar rol
    public function modificarRol($datos)
    {
        $nombre = $datos[0];
        //instacion el metodo de la validacion de el rol
        $validar = $this->modelo->validarRol($_POST["nombre"]);
        if ($nombre == $_POST["nombre"]) {

            $edicion =  $this->modelo->editar($_POST["id_rol"], $_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"]);

            if ($edicion) {
                // guardar la bitacora
                $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Modiicado un rol");
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/editar");
            } else {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/errorSistem");
            }
        } else if ($nombre != $_POST["nombre"]) {
            if ($validar) {
                header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/error");
            } else {
                $edicion =  $this->modelo->editar($_POST["id_rol"], $_POST["nombre"], $_POST["descripcion"], $_POST["modulos"], $_POST["permisos"]);

                if ($edicion) {
                    // guardar la bitacora
                    $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Modiicado un rol");
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/editar");
                } else {
                    header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/errorSistem");
                }
            }
        }
    }

    //eliminar Rol
    public function eliminarRol()
    {
        $eliminacion = $this->modelo->eliminar($_POST["id_rol"]);

        if ($eliminacion) {
            // guardar la bitacora
            $this->bitacora->insertarBitacora($_POST['id_usuario_bitacora'], "Roles", "Ha Eliminado un rol");
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/eliminar");
        } else {
            header("location: /Sistema-del--CEM--JEHOVA-RAFA/Roles/mostrar/errorSistem");
        }
    }


    private function permisos($id_rol, $permiso, $modulo)
    {
        return $this->permisos->gestionarPermisos($id_rol, $permiso, $modulo);
    }
}
